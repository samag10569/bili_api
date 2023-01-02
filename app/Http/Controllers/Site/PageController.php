<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use Illuminate\Support\Facades\Request;

class PageController extends Controller
{
    public function getDetails()
    {
        $link = Request::segments(1);
        $pages = Pages::whereStatus(1)
            ->whereLink($link)
            ->first();
        return view('site.pages.details')
            ->with('pages', $pages);
    }

}
