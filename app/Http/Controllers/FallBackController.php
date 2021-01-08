<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;
use App\Models\Visitor;

class FallBackController extends Controller
{
    public function index($slug) {
        $page = Page::where('slug', $slug)->first();

        if($page) {
            $slugNew = str_replace('-', '', $slug);
            $ip = $_SERVER['REMOTE_ADDR'];
            $date = date('Y-m-d H:i:s', strtotime('-3 hours'));

            Visitor::insert([
                'ip' => $ip,
                'date_access' => $date,
                'page' => $slugNew
            ]);


            return view('site.page',[
                'page' => $page
            ]);
        }else{
            abort(404);
        }
    }
}
