<?php

namespace App\Http\Controllers\Site;

use App\Events\LogUserEvent;
use App\Http\Requests\UnSubscribeRequest;
use App\Models\Banner;
use App\Models\ContactsList;
use App\Models\EmailExcel;
use App\Models\IgnoreEmail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Mews\Captcha\Facades\Captcha;

class PayController extends Controller
{
    public function getForm($id){
        echo $id;
        echo 'OK';
        die;
    }
}
