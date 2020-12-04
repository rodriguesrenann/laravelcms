<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function upload(Request $request) {
       $request->validate([
        'file' => 'image|required|mimes:jpeg'
       ]);

       $imagename = time().'.'.$request->file->extension();

       $request->file->move(public_path('media/images'), $imagename);

       return [
            'location' => asset('media/images/'.$imagename)
       ];
    }
}
