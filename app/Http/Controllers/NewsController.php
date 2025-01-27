<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy("created_at","desc")->paginate(10);
        return view("news.index",compact("news"));
    }

    public function create()
    {
        return view("news.create");
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('news.show', compact('news'));
    }



}
