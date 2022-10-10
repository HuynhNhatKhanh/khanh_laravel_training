<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        return view('news.index');
    }
    public function create()
    {
        return view('news.create');
    }
    public function update($id)
    {
        return view('news.update', ['id' => $id]);
    }
    public function push(Request $request)
    {
        $request->validate(
            [
                'title' => 'required',
                'content' => 'required',
            ],
            [
                'required' => ':attribute không được rỗng',
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
            ]
        );
        return $request->input();
    }
}
