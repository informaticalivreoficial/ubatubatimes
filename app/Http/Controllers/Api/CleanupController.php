<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CleanupController extends Controller
{
    public function clean(Request $request)
    {
        $request->validate([
            'type' => 'required|in:card,boletim,all',
        ]);

        $folders = match ($request->type) {
            'card' => ['cards'],
            'boletim' => ['boletins'],
            'all' => ['cards', 'boletins'],
        };

        $removed = 0;

        foreach ($folders as $folder) {
            $files = Storage::disk('public')->allFiles($folder);

            $removed += count($files);

            if (!empty($files)) {
                Storage::disk('public')->delete($files);
            }
        }

        return response()->json([
            'success' => true,
            'removed' => $removed,
        ]);
    }
}
