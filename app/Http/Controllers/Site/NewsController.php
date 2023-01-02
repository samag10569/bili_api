<?php

namespace App\Http\Controllers\Site;

use App\Models\News;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function getIndex()
    {
        $news = News::whereStatus(1)
            ->deleteTemp()
            ->latest()
            ->paginate(10);

        return view('site.news.index')
            ->with('news', $news);
    }

    public function getDetails($id, $title = null)
    {
        $news = News::whereStatus(1)
            ->deleteTemp()
            ->whereId($id)
            ->first();
        if($news) {
            $news->hits++;
            $news->save();

            $keywords = explode('|', $news->keywords);

            return view('site.news.details')
                ->with('keywords', $keywords)
                ->with('news', $news);
        }else{
            abort(404);
        }
    }

}
