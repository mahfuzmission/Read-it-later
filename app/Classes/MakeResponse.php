<?php

namespace App\Classes;



use Illuminate\Http\JsonResponse;

class MakeResponse
{

    public const success = 200;
    public const created = 201;
    public const error = 400;
    public const exception = 500;
    public const validation_error = 422;


    public static function success($data, $code=200, $urls=[]): JsonResponse
    {
        $response['data'] = $data;

        if(!empty($urls))
        {
            $response['total_record'] = $urls['total_record'];
            $response['next_page_url'] = $urls['next_page_url'];
            $response['prev_page_url'] = $urls['prev_page_url'];
        }

        return response()->json($response, $code);
    }

    public static function error($message, $error_code): JsonResponse
    {
        return response()->json(["error" => $message], $error_code);
    }

    public static function paginate($request, $total_count, $offset, $limit): array
    {
        $previous_offset = $offset - $limit;
        if ($previous_offset < 0) $previous_offset = 0;
        $next_offset = $offset + $limit;
        $next_url = $request->fullUrlWithQuery(['limit' => $limit, 'offset' => $next_offset]);
        $previous_url = $request->fullUrlWithQuery(['limit' => $limit, 'offset' => $previous_offset]);
        if ($offset + $limit > $total_count) $next_url = null;
        if ($offset - $limit < 0) $previous_url = null;

        return [
            "total_record" => $total_count,
            "next_page_url" => $next_url,
            "prev_page_url" => $previous_url
        ];
    }
}
