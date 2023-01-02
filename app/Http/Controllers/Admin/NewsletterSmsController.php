<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\NewsletterSmsRequest;
use App\Models\NewsletterSms;
use App\Models\NewsletterSmsSent;
use App\Models\NewsletterUsers;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class NewsletterSmsController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = NewsletterSms::query();
        $query->with('phoneUserSuccess','phoneUser');
        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('subject')) {
                $query->where('subject', '<', $request->get('subject'));
            }
        }
        $data = $query->orderBy('created_at', 'DESC')->paginate(15);

        return View('admin.newsletter-sms.index')
            ->with('data', $data);
    }

    public function getAdd()
    {


        return view('admin.newsletter-sms.add');

    }

    public function postAdd(NewsletterSmsRequest $request)
    {
        $input = $request->all();
        $newsletter = NewsletterSms::create($input);

        NewsletterSmsSent::insert(NewsletterUsers::select(
            'id as user_id',
            DB::raw('0 as status'),
            DB::raw($newsletter->id.' as newsletter_id'),
            DB::raw('UNIX_TIMESTAMP() as created_at'),
            DB::raw('UNIX_TIMESTAMP() as updated_at')
        )->where('status',1)->get()->toArray());

        event(new LogUserEvent($newsletter->id, 'add', Auth::user()->id));
        return Redirect::action('Admin\NewsletterSmsController@getIndex')->with('success', 'آیتم جدید اضافه شد.');
    }

    public function postDelete(NewsletterSmsRequest $request)
    {
        if (NewsletterSms::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\NewsletterSmsController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

}
