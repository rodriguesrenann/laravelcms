<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;

class FallBackController extends Controller
{
    public function index($slug) {
        $page = Page::where('slug', $slug)->first();

        if(!$page) {
            abort(404);
        }

        return view('site.page', [
            'page' => $page
        ]);
    }
}
