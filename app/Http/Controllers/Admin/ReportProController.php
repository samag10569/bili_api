<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Models\ReportPro;
use App\Models\Allotment;
use App\Models\AllotmentUser;
use App\Models\Shop;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class ReportProController extends Controller
{
    public function getIndex()
    {
        $users_active = User::where('status', 1)->count();
        $users_notactive = User::where('status', 0)->count();
        $users_notregister = User::where('verified', 0)->count();
        $shops_active=Shop::where('status',1)->count();
        $shops_notactive=Shop::where('status',0)->count();

        $i=strtotime("-30 days");
        $users=[];
        for($i=0;$i<=30;$i++){
            $begin=strtotime(date('Y-m-d 23:59:59'))-$i*86400;
            $end=strtotime(date('Y-m-d 23:59:59'))-$i*86400;
            $date=jdate('Y-m-d',strtotime(date('Y-m-d 12:12:59'))-$i*86400);
            $users[$date]=User::where('created_at','>=',$begin)->where('created_at','<=',$end)->count();
            $ads_video_hits[$date]=DB::table('ads_video_hits')->where('hits_at','>=',$begin)->where('hits_at','<=',$end)->count();
            $ads_image_hits[$date]=DB::table('ads_image_hits')->where('hits_at','>=',$begin)->where('hits_at','<=',$end)->count();
            $ads_billboard_hits[$date]=DB::table('ads_billboard_hits')->where('hits_at','>=',$begin)->where('hits_at','<=',$end)->count();
            $ads_text_hits[$date]=DB::table('ads_text_hits')->where('hits_at','>=',$begin)->where('hits_at','<=',$end)->count();
            $ads_apps_hits[$date]=DB::table('ads_apps_hits')->where('hits_at','>=',$begin)->where('hits_at','<=',$end)->count();
        }
        $this_month_start=time()-30*2592000;
        $before_month_start=time()-60*2592000;
        $one_year_start=time()-365*2592000;

        $counts=[];
        $counts['one_year_ads_video_hits']=DB::table('ads_video_hits')->where('hits_at','>=',$one_year_start)->where('hits_at','<=',time())->count();
        $counts['one_year_ads_image_hits']=DB::table('ads_image_hits')->where('hits_at','>=',$one_year_start)->where('hits_at','<=',time())->count();
        $counts['one_year_ads_billboard_hits']=DB::table('ads_billboard_hits')->where('hits_at','>=',$one_year_start)->where('hits_at','<=',time())->count();
        $counts['one_year_ads_text_hits']=DB::table('ads_text_hits')->where('hits_at','>=',$one_year_start)->where('hits_at','<=',time())->count();
        $counts['one_year_ads_apps_hits']=DB::table('ads_apps_hits')->where('hits_at','>=',$one_year_start)->where('hits_at','<=',time())->count();


        $counts['this_month_ads_video_hits']=DB::table('ads_video_hits')->where('hits_at','>=',$this_month_start)->where('hits_at','<=',time())->count();
        $counts['this_month_ads_image_hits']=DB::table('ads_image_hits')->where('hits_at','>=',$this_month_start)->where('hits_at','<=',time())->count();
        $counts['this_month_ads_billboard_hits']=DB::table('ads_billboard_hits')->where('hits_at','>=',$this_month_start)->where('hits_at','<=',time())->count();
        $counts['this_month_ads_text_hits']=DB::table('ads_text_hits')->where('hits_at','>=',$this_month_start)->where('hits_at','<=',time())->count();
        $counts['this_month_ads_apps_hits']=DB::table('ads_apps_hits')->where('hits_at','>=',$this_month_start)->where('hits_at','<=',time())->count();

        $counts['before_month_ads_video_hits']=DB::table('ads_video_hits')->where('hits_at','>=',$before_month_start)->where('hits_at','<',$this_month_start)->count();
        $counts['before_month_ads_image_hits']=DB::table('ads_image_hits')->where('hits_at','>=',$before_month_start)->where('hits_at','<',$this_month_start)->count();
        $counts['before_month_ads_billboard_hits']=DB::table('ads_billboard_hits')->where('hits_at','>=',$before_month_start)->where('hits_at','<',$this_month_start)->count();
        $counts['before_month_ads_text_hits']=DB::table('ads_text_hits')->where('hits_at','>=',$before_month_start)->where('hits_at','<',$this_month_start)->count();
        $counts['before_month_ads_apps_hits']=DB::table('ads_apps_hits')->where('hits_at','>=',$before_month_start)->where('hits_at','<',$this_month_start)->count();

        //dd($users);

        return view('admin.reportpro.index')
            ->with('users_active',$users_active)
            ->with('users_notactive',$users_notactive)
            ->with('users_notregister',$users_notregister)
            ->with('shops_active',$shops_active)
            ->with('shops_notactive',$shops_notactive)
            ->with('ads_video_hits',$ads_video_hits)
            ->with('ads_image_hits',$ads_image_hits)
            ->with('ads_billboard_hits',$ads_billboard_hits)
            ->with('ads_text_hits',$ads_text_hits)
            ->with('ads_apps_hits',$ads_apps_hits)
            ->with('counts',$counts)
            ->with('users',$users);

    }
    public function getIndex2()
    {
        $admins = User::select(DB::raw("CONCAT(name,' ',family) AS title"), 'id')->where('admin', 1)->pluck('title', 'id');

        $allotments=Allotment::select(DB::raw("CONCAT(title,' (',content,')') AS title"), 'id')->pluck('title', 'id');

        return View('admin.reportpro.index')
            ->with('admins',$admins)
            ->with('allotments',$allotments);

    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $option = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];


        return View('admin.ReportPro.add')->with('status', $status)
            ->with('option', $option);
    }

    public function postTask1(Request $request)
    {
        $rules = [
            'date' => 'required|regex:/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json(['status'=>0,'error'=>$validator->errors()]);
        }
        // DB - Jalaali fields
        $start = explode('/', $request->get('date'));
        $s = jmktime(0, 0, 0, $start[1], $start[2], $start[0]);
        $e = jmktime(23, 59, 59, $start[1], $start[2], $start[0]);

        $users=User::whereBetween('date_interview', array($s, $e))->where('member',1)->count();
        return response()->json(['status'=>1,'data'=>$users]);
    }
    public function postTask2(Request $request)
    {
        $rules = [
            'start' => 'required|regex:/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/',
            'end' => 'required|regex:/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->errors());
        }


        $start = explode('/', $request->get('start'));
        $end = explode('/', $request->get('end'));


        $sd = jmktime(0, 0, 0, $start[1], $start[2], $start[0]);
        $ed = jmktime(0, 0, 0, $end[1], $end[2], $end[0]);

        if($sd>$ed){
            return Redirect::back()->withInput()->withErrors('تاریخ ابتدا بزرگتر است');
        }

        $e = $sd+86399;
        $data=[];
        // DB - Jalaali fields
        while($sd<$ed){

            $users=User::whereBetween('date_interview', array($sd, $e))->where('member',1)->count();
            $new= new \stdClass();
            $new->date=jdate('Y/m/d',$sd);
            $new->count=$users;
            $data[]=$new;
            $sd += 86400;
            $e = $sd+86399;
        }
        return view('admin.reportpro.task2')->with('data',$data)->render();
    }
    public function postTask3(Request $request)
    {
        $rules = [
            'start' => 'required|regex:/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/',
            'end' => 'required|regex:/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/',
            'admin' =>'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->errors());
        }
        $admin=User::where('admin',1)->where('id',$request->get('admin'))->first();
        if(!$admin){
            return Redirect::back()->withInput()->withErrors('مدیر یافت نشد.');
        }

        $start = explode('/', $request->get('start'));
        $end = explode('/', $request->get('end'));

        $sd = jmktime(0, 0, 0, $start[1], $start[2], $start[0]);
        $ed = jmktime(0, 0, 0, $end[1], $end[2], $end[0]);

        if($sd>$ed){
            return Redirect::back()->withInput()->withErrors('تاریخ ابتدا بزرگتر است');
        }

        $e = $sd+86399;
        $data=[];
        // DB - Jalaali fields
        while($sd<$ed){
            $users=User::whereBetween('date_interview', array($sd, $e))->where('admin_id',$request->get('admin'))->where('member',1)->count();
            $new= new \stdClass();
            $new->date=jdate('Y/m/d',$sd);
            $new->count=$users;
            $data[]=$new;
            $sd += 86400;
            $e = $sd+86399;
        }
        return view('admin.reportpro.task3')->with('data',$data)
            ->with('admin',$admin)
            ->render();
    }
    public function postTask4(Request $request)
    {
        $rules = [
            'date' => 'required|regex:/^[0-9]{4}\/[0-9]{2}$/',

        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $start = explode('/', $request->get('date'));

        $s =(int) jmktime(0, 0, 0, $start[1], 1, $start[0]);
        $endyear=$start[0];
        if($start[1]==12){
            $endyear=$start[0]+1;
            $start[1]=1;
        }else{
            $start[1]+=1;
        }
        $e =(int) jmktime(0, 0, 0, $start[1], 1, $endyear)-1;
        // DB - Jalaali fields
        $users=DB::select(DB::raw('SELECT u.name,u.family,u.id,IFNULL(m.c,0) count from `users` u
 LEFT JOIN ( SELECT admin_id,count(*) c FROM `users` WHERE admin_id!="" AND member=1 AND (date_interview BETWEEN '.$s.' AND '.$e.') group by admin_id ) as m on m.admin_id=u.id
  WHERE u.admin=1
'));


        return view('admin.reportpro.task4')->with('data',$users)
            ->render();
    }

    public function postTask5(Request $request)
    {
        $rules = [
            'date' => 'required|regex:/^[0-9]{4}\/[0-9]{2}$/',

        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $start = explode('/', $request->get('date'));

        $s =(int) jmktime(0, 0, 0, $start[1], 1, $start[0]);
        $endyear=$start[0];
        if($start[1]==12){
            $endyear=$start[0]+1;
            $start[1]=1;
        }else{
            $start[1]+=1;
        }
        $e =(int) jmktime(0, 0, 0, $start[1], 1, $endyear)-1;

        $data=DB::select(DB::raw('SELECT a.title,a.id,IFNULL(m.c,0) count from `allotment` a
 LEFT JOIN ( SELECT allotment_id,count(*) c FROM `allotment_user` WHERE (date_confirm BETWEEN '.$s.' AND '.$e.') group by allotment_id ) as m on m.allotment_id=a.id
'));

        return view('admin.reportpro.task5')->with('data',$data)
            ->render();
    }


    public function postTask7(Request $request)
    {
        $rules = [
            'date' => 'required|regex:/^[0-9]{4}\/[0-9]{2}$/',
            'allotment' => 'required|exists:allotment,id'

        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $start = explode('/', $request->get('date'));

        $sd = jmktime(0, 0, 0, $start[1], 1, $start[0]);
        $endyear=$start[0];
        if($start[1]==12){
            $endyear=$start[0]+1;
            $start[1]=1;
        }else{
            $start[1]+=1;
        }
        $ed = jmktime(0, 0, 0, $start[1], 1, $endyear)-1;
        $e = $sd+86399;
        $data=[];
        // DB - Jalali fields
        while($sd<$ed){
            $users=AllotmentUser::whereBetween('date_confirm', array($sd, $e))->where('allotment_id',$request->get('allotment'))->count();
            $new= new \stdClass();
            $new->date=jdate('Y/m/d',$sd);
            $new->count=$users;
            $data[]=$new;
            $sd += 86400;
            $e = $sd+86399;
        }

        return view('admin.reportpro.task7')->with('data',$data)
            ->render();
    }

    public function postTask8(Request $request)
    {
        $rules = [
            'date' => 'required|regex:/^[0-9]{4}$/',
            'allotment' => 'required|exists:allotment,id'

        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $start = explode('/', $request->get('date'));

        $data=[];
        // DB - Jalali fields
        for($i=1;$i<=12;$i++){
            $sd = jmktime(0, 0, 0, $i, 1, $start[0]);
            if($i!=12)
                $e = jmktime(0, 0, 0, $i+1, 1, $start[0])-1;
            else
                $e = jmktime(0, 0, 0, 1, 1, $start[0]+1)-1;
            $users=AllotmentUser::whereBetween('date_confirm', array($sd, $e))->where('allotment_id',$request->get('allotment'))->count();
            $new= new \stdClass();
            $new->date=jdate('Y/m',$sd);
            $new->count=$users;
            $data[]=$new;
        }


        return view('admin.reportpro.task8')->with('data',$data)
            ->render();
    }

    public function postTask9(Request $request)
    {
        $data=DB::select(DB::raw('SELECT a.title,a.id,IFNULL(m.c,0) count from `user_status` a
 LEFT JOIN ( SELECT status_id,count(*) c FROM `user_status_date` group by status_id ) as m on m.status_id=a.id
'));

        return view('admin.reportpro.task9')->with('data',$data)
            ->render();
    }

}
