<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function showFile($folder, $filename)
    {
        if (!Storage::disk($folder)->exists($filename)) {
            $path = 'https://placehold.co/800/ffffff/000000?text=404+Not+Found&font=roboto';
            return redirect($path);
        }
        $path = Storage::disk($folder)->path($filename);

        $file = File::get($path);
        $mimeType = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header('Content-Type', $mimeType);

        return $response;
    }
}
