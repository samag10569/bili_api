<?php

namespace App\Http\Controllers\Admin;

use App\Models\Logs;
use App\Models\OnlineUser;
use App\Models\Tracker;
use App\User;
use Classes\DateUtils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function getIndex()
    {
        $date = new DateUtils() ;
        $current_month = $date->getCurrentMonth() ;
        $current_day = $date->current_date() ;
        $tomorrow_day = $date->current_date(-1) ;
        $yesterday_day = $date->current_date(1) ;

        $user_month = User::whereMember('1')
            ->whereBetween('created_at', [$current_month['start_date'], $current_month['end_date']])
            ->count() ;
        $user_day = User::whereMember('1')
            ->whereBetween('date_interview', [$current_day['start_date'], $current_day['end_date']])
            ->count() ;
        $user_first = User::whereMember('1')
            ->whereBetween('date_interview', [$current_day['start_date'], $current_day['end_date']])
            ->where('status_id', '>', '2')
            ->count() ;
        $user_tomorrow = User::whereMember('1')
            ->whereBetween('date_interview', [$tomorrow_day['start_date'], $tomorrow_day['end_date']])
            ->count() ;

        $user_register_current_day = User::whereMember('1')
            ->whereBetween('created_at', [$current_day['start_date'], $current_day['end_date']])
            ->count() ;

        $user_register_yesterday_day = User::whereMember('1')
            ->whereBetween('created_at', [$yesterday_day['start_date'], $yesterday_day['end_date']])
            ->count() ;

        $user_all = User::whereMember('1')->count() ;

        $tracker_yesterday = Tracker::where('date', $yesterday_day['start_date'])->first() ;
        $tracker_current_day = Tracker::where('date', $current_day['start_date'])->first() ;
        $online_user = OnlineUser::where('date', $current_day['start_date'])->whereStatus(1)->count() ;

        $log_user = Logs::whereVariableId(Auth::user()->id)
            ->whereType('login')
            ->take(2)
            ->latest()
            ->get() ;

        return view('admin.index')
            ->with('user_register_yesterday_day', $user_register_yesterday_day)
            ->with('user_register_current_day', $user_register_current_day)
            ->with('user_all', $user_all)
            ->with('tracker_yesterday', $tracker_yesterday)
            ->with('tracker_current_day', $tracker_current_day)
            ->with('online_user', $online_user)
            ->with('log_user', $log_user)
            ->with('user_day', $user_day)
            ->with('user_first', $user_first)
            ->with('user_tomorrow', $user_tomorrow)
            ->with('user_month', $user_month) ;
    }
}
