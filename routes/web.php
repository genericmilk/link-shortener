<?php

use App\Http\Controllers\LinksController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/', function () {
        return redirect()->route('links.index');
    });

    Route::resources([
        'links' => LinksController::class,
    ]);

});

Route::prefix('l')->group(function () {
    Route::get('{hash}', [LinksController::class, 'show'])->name('links.show');
});
