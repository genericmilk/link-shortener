<?php

namespace App\Services;

use App\Models\Link;
use App\Models\User;
use Sqids\Sqids;

class LinkService
{
    public function createLink(string $url): Link
    {
        $link = auth()->user()->links()->firstOrCreate([
            'url' => $url,
        ]);

        return $link;
    }

    public function decode(string $url): int
    {
        $sqid = new Sqids;

        // Verify the Short URL parameter is correct and contains a short url /l/ structure
        if (empty($url)) {
            throw new \InvalidArgumentException('short_url parameter is required');
        }

        if (! filter_var($url, FILTER_VALIDATE_URL) || ! str_contains($url, url('/l/'))) {
            throw new \InvalidArgumentException('Invalid URL. Make sure it is a valid URL and contains the short URL');
        }

        // Grab the hash from the URL
        $hash = explode(url('/l/'), $url);

        if (count($hash) == 2) {
            $hash = $hash[1];
            $hash = str_replace('/', '', $hash);
        } else {
            throw new \InvalidArgumentException('Invalid URL');
        }

        $hash = explode('?', $hash)[0];
        $hash = e($hash);

        // Verify and convert the hash to ID
        $ids = $sqid->decode($hash);

        if (count($ids) == 0) {
            throw new \InvalidArgumentException('Invalid URL, Could not convert to ID');
        }

        if (! is_int($ids[0])) {
            throw new \InvalidArgumentException('Invalid URL, Not an ID');
        }

        return $ids[0];
    }
}
