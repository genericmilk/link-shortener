<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Sqids\Sqids;

class LinksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): InertiaResponse
    {
        return Inertia::render('Links/Index', [
            'links' => $request->user()->links()->latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        $url = $request->input('url');

        $request->validate([
            'url' => 'required|url|unique:links,url',
        ]);
        

        $link = $request->user()->links()->firstOrCreate([
            'url' => $url,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Link $link): void
    {
        // check if the user owns the link
        if ($link->user_id !== $request->user()->id) {
            abort(403);
        }

        $link->delete();

    }

    public function show(Request $request, string $hash): RedirectResponse
    {
        $sqid = new Sqids;

        // Verify and convert the hash to ID
        $ids = $sqid->decode($hash);

        if (count($ids) == 0) {
            abort(400);
        }

        if (! is_int($ids[0])) {
            abort(400);
        }

        $link = Link::find($ids[0]);

        if ($link == null) {
            abort(404);
        }

        return redirect($link->url);

    }
}
