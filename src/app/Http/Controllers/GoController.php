<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\LinkVisit;

class GoController extends Controller
{
public function go(string $hash, Request $request)
{
    $link = Link::where('short_url_hash', $hash)->firstOrFail();
    LinkVisit::create([
        'link_id' => $link->id,
        'ip_address' => $request->ip(),
        'visited_at' => now(),
    ]);
    return redirect()->away($link->url)->setStatusCode(301);
}
}
