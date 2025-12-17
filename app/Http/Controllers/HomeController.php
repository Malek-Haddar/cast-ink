<?php

namespace App\Http\Controllers;

use App\Models\AccessCode;
use App\Models\Podcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // eager load episodes; adjust limits/orders as needed
        $podcasts = Podcast::with(['episodes' => function ($q) {
            $q->orderByDesc('created_at'); // newest first
        }])->latest()->get();

        return view('pages.home', compact('podcasts'));
    }

    public function show(Podcast $podcast, Request $request)
    {
        $podcast->load(['episodes' => fn($q) => $q->latest()]);

        $sessionKey = $this->sessionKey($podcast);
        $accessGranted = (bool) $request->session()->get($sessionKey, false);

        return view('pages.podcast-show', [
            'podcast' => $podcast,
            'accessGranted' => $accessGranted,
        ]);
    }

    public function verifyAccessCode(Request $request, Podcast $podcast)
    {
        $validated = $request->validate([
            'code' => ['required', 'string'],
        ]);

        $accessCode = AccessCode::where('podcast_id', $podcast->id)
            ->where('code', $validated['code'])
            ->first();

        if (! $accessCode) {
            return back()->withErrors(['code' => 'Invalid code for this podcast.']);
        }

        if ($accessCode->is_used) {
            return back()->withErrors(['code' => 'This code has already been used.']);
        }

        $accessCode->is_used = true;
        if (Auth::check()) {
            $accessCode->used_by = Auth::id();
        }
        $accessCode->save();

        $request->session()->put($this->sessionKey($podcast), true);

        return redirect()
            ->route('podcasts.show', $podcast)
            ->with('status', 'Access granted. You can now play this podcast.');
    }

    private function sessionKey(Podcast $podcast): string
    {
        return 'podcast_access_'.$podcast->id;
    }
}