<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $pages = Page::paginate(10);

        return view('admin.pages.index', [
            'pages' => $pages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'title',
            'body'
        ]);
        $data['slug'] = Str::slug($data['title'], '-');

        $rules = [
            'title' => 'string|required|max:100',
            'body' => 'string|required|',
            'slug' => 'unique:pages|'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
           return redirect()->route('pages.create')->withErrors($validator)->withInput();
        }

            $newPage = new Page();
            $newPage->title = $data['title'];
            $newPage->body = $data['body'];
            $newPage->slug = $data['slug'];
            $newPage->save();

            return redirect()->route('pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::find($id);

        if($page) {
            return view('admin.pages.edit', [
                'page' => $page
            ]);
        }
        
        return redirect()->route('pages.index')->with('error', 'Página inexistente!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::find($id);

        if($page) {
            $data = $request->only([
                'title',
                'body'
            ]);

            if($page->title != $data['title']) {
                $data['slug'] = Str::slug($data['title'], '-');

                $validator = Validator::make($data, [
                    'title' => 'required|string|max:100',
                    'body' => 'required|string',
                    'slug' => 'required|unique:pages|string'
                ]);
            }else{
                $validator = Validator::make($data, [
                    'title' => 'required|string|max:100',
                    'body' => 'required|string'
                ]);
            }

            if(!$validator->fails()) {
                if(!empty($data['slug'])) {
                    $page->slug = $data['slug'];
                }
                $page->title = $data['title'];
                $page->body = $data['body'];
                $page->save();

                return redirect()->route('pages.index')->with('success', 'Página editada com sucesso!');
            }
            return redirect()->route('pages.edit', ['page' => $page->id])->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);

        if($page) {
            $page->delete();
        }

        return redirect()->route('pages.index')->with('success', 'Página excluída!');
    }
    
}
