<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UrlShortenerService;

class UrlShortenerController extends Controller
{
    protected $shortenerService;

    public function __construct(UrlShortenerService $shortenerService)
    {
        $this->shortenerService = $shortenerService;
    }

    public function encode(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $shortUrl = $this->shortenerService->encode($request->url);
        
        return response()->json([
            'short_url' => url($shortUrl)
        ], 200);
    }

    public function decode(Request $request)
    {
        $request->validate([
            'short_url' => 'required|url'
        ]);

        $originalUrl = $this->shortenerService->decode($request->short_url);
        
        if (!$originalUrl) {
            return response()->json([
                'error' => 'Invalid short URL'
            ], 404);
        }

        return response()->json([
            'original_url' => $originalUrl
        ], 200);
    }
}
