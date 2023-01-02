<?php

namespace App\Http\Controllers\Out;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function getIndex()
    {
        return view('out.index');
    }
}
