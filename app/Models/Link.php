<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sqids\Sqids;

class Link extends Model
{
    protected $appends = ['thumbnail', 'short_url', 'created_ago'];

    protected $fillable = [
        'url',
    ];

    public function getThumbnailAttribute(): string
    {
        // get the domain
        $domain = parse_url($this->url, PHP_URL_HOST);

        return 'https://www.google.com/s2/favicons?domain='.e($domain).'&sz=128';
    }

    public function getShortUrlAttribute(): string
    {
        $sqid = new Sqids;
        $hash = $sqid->encode([$this->id]);

        return url('/l/'.$hash);
    }

    public function getCreatedAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}
