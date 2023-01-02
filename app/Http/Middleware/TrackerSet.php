<?php

namespace App\Http\Middleware;

use App\Models\OnlineUser;
use App\Models\Tracker;
use Classes\DateUtils;
use Closure;
use Illuminate\Support\Facades\Session;
use Request;

class TrackerSet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Request::segment(1) != config('site.admin') and Request::segment(1) != config('site.out')) {
            $date = new DateUtils();
            $current_day = $date->current_date();

            //--------------------------Tracker---------------------------------------------------

            if (Tracker::where('date', $current_day['start_date'])->exists()) {
                $tracker = Tracker::where('date', $current_day['start_date'])->first();
                $tracker->count++;
                $tracker->save();
            } else {
                $input = [
                    'count' => 1,
                    'date' => $current_day['start_date'],
                ];
                Tracker::create($input);
            }

            //--------------------------Online User---------------------------------------------------

            $session_id = Session::getId();
            if (OnlineUser::where('session', $session_id)->where('date', $current_day['start_date'])->exists()) {
                OnlineUser::where('session', $session_id)->where('date', $current_day['start_date'])
                    ->update(['time_s' => time(), 'status' => 1]);
            } else {
                $input = [
                    'session' => $session_id,
                    'time_s' => time(),
                    'status' => 1,
                    'date' => $current_day['start_date'],
                ];
                OnlineUser::create($input);
            }

            $time_check = time() - 300;
            OnlineUser::where('time_s', '<', $time_check)
                ->update(['status' => 0]);

            $old_day = $date->current_date(2);
            OnlineUser::where('date', '<', $old_day['start_date'])->delete();

        }
        return $next($request);
    }
}
