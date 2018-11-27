<?php

namespace App\Http\Controllers;

use App\Model\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index($id)
    {
        $news = News::findOrFail($id);

        $this->setSeoMeta('Новости | '.$news->name);


        return view('news', compact('news'));
    }
}
