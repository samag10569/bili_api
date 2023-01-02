<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\NewsletterUsersRequest;
use App\Models\NewsletterUsers;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class NewsletterUsersController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = NewsletterUsers::query();
        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('email')) {
                $query->where('email', 'LIKE','%'. $request->get('email').'%');
            }
        }
        $data = $query->orderBy('created_at', 'DESC')->paginate(15);

        return View('admin.newsletter-users.index')
            ->with('data', $data);
    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return view('admin.newsletter-users.add')
            ->with('status', $status);
    }

    public function postAdd(NewsletterUsersRequest $request)
    {
        $input = $request->all();
        NewsletterUsers::create($input);

        return Redirect::action('Admin\NewsletterUsersController@getIndex')->with('success', 'آیتم جدید اضافه شد.');
    }

    public function postDelete(NewsletterUsersRequest $request)
    {
        if (NewsletterUsers::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\NewsletterUsersController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

}
