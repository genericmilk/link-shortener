<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sqids\Sqids;
use App\Http\Requests\LinkEncodeRequest;
use App\Http\Resources\EncodedLinkResource;
use App\Http\Resources\DecodedLinkResource;
use App\Http\Requests\LinkDecodeRequest;
use App\Services\LinkService;

class ApiLinksController extends Controller
{
    protected LinkService $linkService;

    public function __construct()
    {
        $this->linkService = new LinkService();
    }

    public function encode(LinkEncodeRequest $request): EncodedLinkResource
    {
        $url = $request->validated('url');

        $link = $this->linkService->createLink($url);

        return new EncodedLinkResource($link);
    }

    public function decode(LinkDecodeRequest $request): DecodedLinkResource
    {
        $url = $request->validated('short_url');

        $id = $this->linkService->decode($url);

        $link = Link::find($id);

        return new DecodedLinkResource($link);
    }
}
