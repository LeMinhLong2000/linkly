<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\RedirectResponse;

class RedirectController extends Controller
{
    public function show(string $code): RedirectResponse
    {
        $link = Link::where('code', $code)->first();

        if (! $link) {
            abort(404);
        }

        if (! $link->is_active) {
            abort(404);
        }

        if (
            $link->expires_at !== null &&
            $link->expires_at->isPast()
        ) {
            abort(404);
        }

        return redirect()->away(
            $link->original_url,
            302
        );
    }
}