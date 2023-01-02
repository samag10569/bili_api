<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\EmailPresentedRequest;
use App\Models\EmailPresented;
use App\Models\EmailPresentedSent;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class EmailPresentedController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = EmailPresented::query();
        $query->with('emailUserSuccess','emailUser');
        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('subject')) {
                $query->where('subject', 'LIKE', '%'.$request->get('subject').'%');
            }
        }
        $data = $query->orderBy('created_at', 'DESC')->paginate(15);

        return View('admin.email-presented.index')
            ->with('data', $data);
    }

    public function getAdd()
    {


        return view('admin.email-presented.add');

    }

    public function postAdd(EmailPresentedRequest $request)
    {
        $input = $request->all();
        $newsletter = EmailPresented::create($input);

        $emails=
            DB::table('contacts_list')->select(
            'email'
        )->union(
            User::select(
                'email'
            )->where('register_id','<>',-1)
                ->whereNotNull('register_id')
        )->pluck('email')->toArray();


        foreach($emails as $email){
            EmailPresentedSent::create([
                'email'=>$email,
                'status'=>0,
                'newsletter_id'=>$newsletter->id,

            ]);
        }

        event(new LogUserEvent($newsletter->id, 'add', Auth::user()->id));
        return Redirect::action('Admin\EmailPresentedController@getIndex')->with('success', 'آیتم جدید اضافه شد.');
    }

    public function postDelete(EmailPresentedRequest $request)
    {
        if (EmailPresented::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\EmailPresentedController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

}
