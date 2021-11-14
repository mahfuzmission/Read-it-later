<?php

namespace App\Http\Controllers\Api;

use App\Classes\MakeResponse;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContentsController extends Controller
{

    public function getContents(Request $request, $pocket_id)
    {
        $limit = intval($request->query('limit', 20));
        $offset = intval($request->query('offset', 0));

        $contents = Content::where('pocket_id', $pocket_id);
        $total = $contents->count();
        $contents = $contents->skip($offset)
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->get();

        $urls = MakeResponse::paginate($request, $total, $offset,$limit );

        return MakeResponse::success($contents,MakeResponse::success, $urls);
    }

    public function createContent(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'pocket_content' => 'required',
            'pocket_id' => 'required|exists:pockets,id',
        ]);

        if ($validator->fails()) {
            return MakeResponse::error($validator->errors(), MakeResponse::validation_error);
        }

        $content = new Content();
        $content->content = trim($request->pocket_content);
        $content->pocket_id = $request->pocket_id;
        $content->save();

        $tag_ids = [];

        Log::info(json_encode(trim($request->hashtags)));
        $content_tags = trim($request->hashtags);
        $hashtags = (!empty(trim($content_tags))) ? $this->getHashKeys($content_tags) : [];

        if (!empty($hashtags))
        {
            foreach($hashtags as $hashtag)
            {
                if(preg_match("/(\w*[a-zA-Z_]+\w*)/", $hashtag))
                {
                    $tag = Tag::firstOrCreate( ['tag_name' => $hashtag],['tag_name' => $hashtag] );
                    $tag_ids[] = $tag->id;
                }
            }

            if(!empty($tag_ids))
            {
                $content->tags()->sync($tag_ids);
            }

        }

        return MakeResponse::success("content successfully created", MakeResponse::created);
    }

    public function getContentByHashTag(Request $request)
    {
        $limit = intval($request->query('limit', 20));
        $offset = intval($request->query('offset', 0));
        $pocket_id = trim($request->pocket_id);
        $search = trim($request->search);
        $hashtag = $this->getHashKeys($search);

        $contents = Content::when(!empty($pocket_id), function ($query) use($pocket_id){
            return $query->where('pocket_id',$pocket_id);
        });

        if(!empty($hashtag))
        {
            $where_query = "";
            foreach($hashtag as $index => $tag){
                $where_query = $where_query." tag_name like '%$tag%' ";
                if($index != (sizeof($hashtag) -1))
                {
                    $where_query.= " or ";
                }
            }

            $hashtag_ids = Tag::whereRaw($where_query)->pluck('id')->toArray();
            $contents->whereHas('tags', function($query) use ($hashtag_ids){
                $query->whereIn('tags.id', $hashtag_ids);
            });
        }
        else if(!empty($search))
        {
            $contents->where('content', 'like', '%'.$search.'%');
        }

        $total = $contents->count();
        $contents = $contents->skip($offset)
            ->limit($limit)
            ->orderBy('id','desc')
            ->get();

        $urls = MakeResponse::paginate($request, $total, $offset, $limit );

        return MakeResponse::success($contents, MakeResponse::success, $urls);

    }

    public function deleteContent($content_id)
    {
        try {
            $content = Content::find($content_id);
            if($content != null)
            {
                $content->tags()->detach();
                $content->delete();
                return MakeResponse::success("content successfully deleted", MakeResponse::success);
            }

            return MakeResponse::error("content not found", MakeResponse::error);
        }
        catch (\Exception $exception)
        {
            return MakeResponse::error($exception->getMessage(), MakeResponse::exception);
        }
    }


    private function getHashKeys($pocket_content)
    {
        preg_match_all('/#([^#\s]+)/', $pocket_content, $hashtags);
        return $hashtags[1] ?? [];
    }

}
