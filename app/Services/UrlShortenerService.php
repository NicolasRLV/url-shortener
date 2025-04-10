<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UrlShortenerService
{
    private $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    private $base = 62;
    private $shortLength = 6;

    public function encode($url)
    {
        do {
            $shortCode = $this->generateShortCode();
        } while (Cache::has($shortCode));

        Cache::forever($shortCode, $url);
        Log::debug('Encoded', ['shortCode' => $shortCode, 'url' => $url]);
        return $shortCode;
    }

    public function decode($shortUrl)
    {
        $shortCode = basename(parse_url($shortUrl, PHP_URL_PATH));
        $originalUrl = Cache::get($shortCode);
        Log::debug('Decoded', ['shortUrl' => $shortUrl, 'shortCode' => $shortCode, 'originalUrl' => $originalUrl]);
        return $originalUrl;
    }

    private function generateShortCode()
    {
        $code = '';
        for ($i = 0; $i < $this->shortLength; $i++) {
            $code .= $this->chars[rand(0, $this->base - 1)];
        }
        return $code;
    }
}
