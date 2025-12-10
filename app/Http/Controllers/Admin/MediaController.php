<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Handle upload dari CKEditor atau Dropzone.
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            try {
                // 1. Validasi
                $request->validate([
                    // Max 3MB, format gambar umum
                    'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:3072', 
                ]);

                $file = $request->file('upload');
                
                // 2. Generate Nama Unik
                // Format: timestamp_slug-nama-asli.jpg
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . Str::slug($originalName) . '.' . $extension;
                
                // 3. Simpan Fisik (Storage Link)
                $path = $file->storeAs('uploads/media', $fileName, 'public');

                // 4. Simpan Record ke Database (Agar terlacak)
                $media = MediaUpload::create([
                    'uploaded_by' => auth()->id(), // Asumsi admin login
                    'filename'    => $fileName,
                    'disk'        => 'public',
                    'path'        => $path,
                    'mime_type'   => $file->getMimeType(),
                    'size'        => $file->getSize(),
                ]);

                // 5. Return JSON (Standar CKEditor 5)
                return response()->json([
                    'url' => $media->url, // Menggunakan accessor getUrlAttribute
                    'uploaded' => 1,      // Flag sukses
                    'fileName' => $fileName
                ]);

            } catch (\Exception $e) {
                Log::error('Media Upload Error: ' . $e->getMessage());
                
                return response()->json([
                    'error' => [
                        'message' => 'Upload failed: ' . $e->getMessage()
                    ]
                ], 500);
            }
        }

        return response()->json(['error' => ['message' => 'No file provided.']], 400);
    }
}