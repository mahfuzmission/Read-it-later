<?php

namespace App\Http\Controllers\Api;

use App\Classes\MakeResponse;
use App\Http\Controllers\Controller;
use App\Models\Pocket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PocketsController extends Controller
{

    public function getPockets(Request $request)
    {
        $limit = intval($request->query('limit', 20));
        $offset = intval($request->query('offset', 0));

        $pockets = Pocket::query();
        $total = $pockets->count();
        $pockets = $pockets->skip($offset)
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->get();

        $urls = MakeResponse::paginate($request, $total, $offset,$limit );

        return MakeResponse::success($pockets, MakeResponse::success, $urls);
    }

    public function createPocket(Request $request)
    {
        try {
            $pocket = new Pocket();
            $pocket->pocket_name = Str::uuid()->toString();
            $pocket->save();

            return MakeResponse::success("pocket successfully created",MakeResponse::created);
        }
        catch (\Exception $exception)
        {
            return MakeResponse::error($exception->getMessage(), MakeResponse::exception);
        }
    }

}
