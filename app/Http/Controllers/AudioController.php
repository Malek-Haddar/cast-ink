<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\UserPodcastAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class AudioController extends Controller
{
    public function stream(Request $request, Episode $episode)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired signature.');
        }

        // IP Binding Check
        if ($request->query('user_ip') !== $request->ip()) {
            abort(403, 'This link is locked to a different IP address.');
        }

        // Prevent direct browser access (must be embedded)
        $referer = $request->headers->get('referer');
        if (! $referer || ! str_contains($referer, $request->getHost())) {
             abort(403, 'Direct access not allowed.');
        }

        // Check access
        $hasAccess = $episode->is_free;
        
        if (! $hasAccess) {
            // Check session access (consistent with HomeController)
            $sessionKey = 'podcast_access_' . $episode->podcast_id;
            if ($request->session()->get($sessionKey)) {
                $hasAccess = true;
            } elseif (Auth::check()) {
                // Check database if not in session
                $hasAccess = UserPodcastAccess::where('user_id', Auth::id())
                    ->where('podcast_id', $episode->podcast_id)
                    ->exists();
                
                if ($hasAccess) {
                    $request->session()->put($sessionKey, true);
                }
            }
        }

        if (! $hasAccess) {
            abort(403, 'Unauthorized access.');
        }

        $path = $episode->audio_path;
        
        if (! Storage::disk('local')->exists($path)) {
            abort(404, 'File not found.');
        }

        $fullPath = Storage::disk('local')->path($path);
        $fileSize = filesize($fullPath);
        $mimeType = Storage::disk('local')->mimeType($path);

        $headers = [
            'Content-Type' => $mimeType,
            'Content-Length' => $fileSize,
            'Accept-Ranges' => 'bytes',
            'Content-Disposition' => 'inline',
            'X-Content-Type-Options' => 'nosniff',
        ];

        return response()->stream(function () use ($fullPath) {
            $stream = fopen($fullPath, 'r');
            fpassthru($stream);
            fclose($stream);
        }, 200, $headers);
    }

    public function getUrl(Request $request, Episode $episode)
    {
        // Check access
        $hasAccess = $episode->is_free;
        
        if (! $hasAccess) {
            $sessionKey = 'podcast_access_' . $episode->podcast_id;
            if ($request->session()->get($sessionKey)) {
                $hasAccess = true;
            } elseif (Auth::check()) {
                // Check database if not in session
                $hasAccess = UserPodcastAccess::where('user_id', Auth::id())
                    ->where('podcast_id', $episode->podcast_id)
                    ->exists();
                
                if ($hasAccess) {
                    $request->session()->put($sessionKey, true);
                }
            }
        }

        if (! $hasAccess) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $url = URL::temporarySignedRoute(
            'audio.stream',
            now()->addMinutes(5),
            [
                'episode' => $episode->id,
                'user_ip' => $request->ip() // Lock to this IP
            ]
        );

        return response()->json(['url' => $url]);
    }
}
