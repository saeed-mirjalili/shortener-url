<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RedirectController extends Controller
{
    public function show(string $short_code)
    {
        $url = Cache::remember("url:{$short_code}",10, function () use ($short_code) {
            return Url::where('short_code', $short_code)->first();
        });

        if (!$url) {
         abort(404);
        }

        if ($url->expires_at && now()->greaterThan($url->expires_at)) {
            abort(410);
        }

        Url::where('id', $url->id)->increment('clicks');

        return redirect()->away($url->original_url,301);
    }
}
