<?php

namespace App\Http\Controllers\Crm;

use App\Events\LogUserEvent;
use App\Http\Requests\CrmPrivateMessagesRequest;
use App\Models\PrivateMessages;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class PrivateMessagesController extends Controller
{
    public function getInbox(Request $request)
    {
        $query = PrivateMessages::select('*', 'private_messages.created_at as created_at', 'private_messages.status as status', 'private_messages.id as id');
        $query->Join('users', 'private_messages.user_id_from', '=', 'users.id');
        $query->with('sender');
        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('private_messages.created_at', array($s, $e));
            }
            if ($request->has('name')) {
                $query->where('users.name', 'LIKE', '%' . $request->get('name') . '%');
            }
            if ($request->has('family')) {
                $query->where('users.family', 'LIKE', '%' . $request->get('family') . '%');
            }
        }
        $query->where('user_id_to', Auth::User()->id)->where('to_status', '>', 0);
        $data = $query->orderBy('private_messages.created_at', 'DESC')->paginate(15);

        return View('crm.private-message.inbox')
            ->with('data', $data);
    }

    public function getOutbox(Request $request)
    {
        $query = PrivateMessages::select('*', 'private_messages.created_at as created_at', 'private_messages.status as status', 'private_messages.id as id');
        $query->join('users', 'private_messages.user_id_to', '=', 'users.id');
        $query->with('receiver');
        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('private_messages.created_at', array($s, $e));
            }
            if ($request->has('name')) {
                $query->where('users.name', 'LIKE', '%' . $request->get('name') . '%');
            }
            if ($request->has('family')) {
                $query->where('users.family', 'LIKE', '%' . $request->get('family') . '%');
            }
        }
        $query->where('user_id_from', Auth::id())
            ->where('from_status', '>', 0);
        $data = $query->orderBy('private_messages.created_at', 'DESC')->paginate(15);

        return View('crm.private-message.outbox')
            ->with('data', $data);
    }

    public function getSend($user_id = null)
    {
        return view('crm.private-message.send')->with('user_id', $user_id);
    }

    public function getReplay($type, $id)
    {
        $query = PrivateMessages::query();
        $query->whereId($id);
        if ($type == 'from') {
            $query->where('user_id_from', Auth::id());
        } else {
            $query->where('user_id_to', Auth::id());
        }
        $msg = $query->first();
        if (!$msg) abort(404);
        if (Auth::id() == $msg->user_id_to)
            $msg->update(['status' => 1]);
        return view('crm.private-message.replay')
            ->with('type', $type)
            ->with('msg', $msg);
    }

    public function postReplay(CrmPrivateMessagesRequest $request, $id)
    {
        $input = $request->except('_token');
        $type = $input['type'];
        $query = PrivateMessages::query();
        $query->whereId($id);
        if ($type == 'from') {
            $query->where('user_id_from', Auth::id());
        } else {
            $query->where('user_id_to', Auth::id());
        }
        $pm = $query->first();
        if (!$pm) abort(404);


        if ($type == 'from') {
            $user_id_to = $pm->user_id_to;
        } else {
            $user_id_to = $pm->user_id_from;
        }

        PrivateMessages::create([
            'user_id_from' => Auth::id(),
            'user_id_to' => $user_id_to,
            'subject' => $request->get('subject'),
            'message' => $request->get('message'),
        ]);

        return Redirect::action('Crm\PrivateMessagesController@getOutbox')->with('success', 'پیام با موفقیت ارسال شد.');
    }

    public function postSend(CrmPrivateMessagesRequest $request)
    {
        PrivateMessages::create([
            'user_id_from' => Auth::id(),
            'user_id_to' => $request->get('user_id_to'),
            'subject' => $request->get('subject'),
            'message' => $request->get('message'),
        ]);

        return Redirect::action('Crm\PrivateMessagesController@getOutbox')->with('success', 'پیام با موفقیت ارسال شد.');
    }

    public function postDelete(CrmPrivateMessagesRequest $request)
    {
        if ($request->get('type') == 'out') {
            if (PrivateMessages::where('user_id_from', Auth::User()->id)->whereIn('id', $request->get('deleteId'))->update(['from_status' => 0])) {
                return Redirect::action('Crm\PrivateMessagesController@getOutbox')
                    ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
            }
        } else {
            if (PrivateMessages::where('user_id_to', Auth::User()->id)->whereIn('id', $request->get('deleteId'))->update(['to_status' => 0])) {
                return Redirect::action('Crm\PrivateMessagesController@getIndex')
                    ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
            }
        }
    }

    public function getUser($user_id = null)
    {
        $data = User::where('id', $user_id)->whereMember(1)->first();

        if ($data) {
            return json_encode(array('status' => true, 'text' => $data->name . ' ' . $data->family));
        } else {
            return json_encode(array('status' => false, 'text' => 'کد وارد شده نامعتبر می باشد.'));
        }
    }

}
