<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\PrivateMessagesReportsRequest;
use App\Models\PrivateMessagesReports;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class PrivateMessagesReportsController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = PrivateMessagesReports::select('*','private_messages_reports.created_at as created_at');
        $query->join('users', 'private_messages_reports.user_id', '=', 'users.id');
        $query->with('sender','msg');
        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('private_messages_reports.created_at', array($s, $e));
            }
            if ($request->has('name')) {
                $query->where('users.name', 'LIKE', '%' . $request->get('name') . '%');
            }
            if ($request->has('family')) {
                $query->where('users.family', 'LIKE', '%' . $request->get('family') . '%');
            }
        }
        $data = $query->orderBy('private_messages_reports.created_at', 'DESC')->paginate(15);


        return View('admin.private-message-report.index')
            ->with('data', $data);
    }

    public function postDelete(PrivateMessagesReportsRequest $request)
    {
        if (PrivateMessagesReports::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\PrivateMessagesReportsController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }



}
