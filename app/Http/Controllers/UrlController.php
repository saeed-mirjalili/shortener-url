<?php

namespace App\Http\Controllers;

use App\Http\ApiRequest\UrlStoreApiRequest;
use App\Http\Resources\UrlListApiResource;
use App\Models\Url;
use App\Http\Controllers\Controller;
use App\Support\ShortCode;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urls = Url::query()->latest()->paginate(5);

        return UrlListApiResource::collection($urls);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UrlStoreApiRequest $request)
    {
        $code = ShortCode::generate(7);

        $url = Url::create([
            'original_url' => $request['url'],
            'short_code' => $code,
            'expires_at' => isset($request['ttl_days']) ? now()->addDays((int)$request['ttl_days']) : null,
        ]);

        return response()->json([
        'short_url' => url($url->short_code),
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Url $url)
    {
        if (!$url) {
            return response()->json([
                'message' => 'Not Found',
            ],404);
        }

        $url->delete();

        return response()->json([],204);
    }
}
