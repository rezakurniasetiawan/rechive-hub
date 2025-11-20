<?php

namespace App\Http\Controllers\SPIManager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SPIManager\SPIManagerLink;

class SPIManagerLinkController extends Controller
{
    public function index()
    {
        $pending = SPIManagerLink::where('status', 'pending')
            ->orderByRaw('copied_at IS NULL DESC, copied_at DESC, created_at DESC')
            ->paginate(10, ['*'], 'pending_page');

        $copied = SPIManagerLink::where('status', 'copied')
            ->orderByRaw('copied_at IS NULL DESC, copied_at DESC, created_at DESC')
            ->paginate(10, ['*'], 'copied_page');

        $used = SPIManagerLink::where('status', 'used')
            ->orderByRaw('copied_at IS NULL DESC, copied_at DESC, created_at DESC')
            ->paginate(10, ['*'], 'used_page');

        return view('layouts.app', [
            'content' => view(
                'pages.spi_manager.link-content.link-content',
                compact('pending', 'copied', 'used')
            )->render()
        ]);
    }



    public function create()
    {
        return view('layouts.app', [
            'content' => view('pages.spi_manager.link-content.link-content-create')->render()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'video_url' => 'required|url',
        ]);

        $videoUrl = $request->input('video_url');
        $host = parse_url($videoUrl, PHP_URL_HOST);
        $platform = null;
        if ($host) {
            $hostParts = explode('.', $host);
            if (count($hostParts) >= 2) {
                $platform = $hostParts[1];
            }
        }

        SPIManagerLink::create([
            'video_url' => $request->input('video_url'),
            'platform' => $platform,
            'status' => 'pending',
            'created_by'  => Auth::id(),
        ]);

        return redirect()->route('spi.content.index')->with('success', 'SPI Manager Link created successfully.');
    }

    public function bulkCreate()
    {
        return view('layouts.app', [
            'content' => view('pages.spi_manager.link-content.link-content-bulk')->render()
        ]);
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'links' => 'required|string',
        ]);

        $lines = preg_split("/\r\n|\n|\r/", trim($request->links));
        $created = 0;

        foreach ($lines as $line) {
            $line = trim($line);
            if (!$line) continue; // skip baris kosong

            if (!filter_var($line, FILTER_VALIDATE_URL)) continue;

            $host = parse_url($line, PHP_URL_HOST);

            $platform = null;
            if ($host) {
                if (str_contains($host, 'instagram')) $platform = 'instagram';
                elseif (str_contains($host, 'tiktok')) $platform = 'tiktok';
                else $platform = 'other';
            }

            SPIManagerLink::create([
                'video_url' => $line,
                'platform' => $platform,
                'status' => 'pending',
                'created_by' => Auth::id(),
            ]);

            $created++;
        }

        return redirect()
            ->route('spi.content.index')
            ->with('success', "$created links uploaded successfully.");
    }



    public function copyLink($id)
    {
        $link = SPIManagerLink::findOrFail($id);
        $link->status = 'copied';
        $link->copied_at = now();
        $link->save();

        return redirect()->route('spi.content.index')->with('success', 'Link copied successfully.');
    }

    public function markAsUsed($id)
    {
        $link = SPIManagerLink::findOrFail($id);
        $link->status = 'used';
        $link->save();

        return redirect()->route('spi.content.index')->with('success', 'Link marked as used successfully.');
    }
}