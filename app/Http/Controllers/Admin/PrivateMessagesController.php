<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\PrivateMessagesRequest;
use App\Models\PrivateMessages;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class PrivateMessagesController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = PrivateMessages::select('*','private_messages.created_at as created_at');
        $query->Join('users as u1', 'private_messages.user_id_from', '=', 'u1.id');
        $query->Join('users', 'private_messages.user_id_to', '=', 'users.id');
        $query->with('sender','receiver');
        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('private_messages.created_at', array($s, $e));
            }
            if ($request->has('name')) {
                $query->where('u1.name', 'LIKE', '%' . $request->get('name') . '%');
            }
            if ($request->has('family')) {
                $query->where('u1.family', 'LIKE', '%' . $request->get('family') . '%');
            }
            if ($request->has('name2')) {
                $query->where('users.name', 'LIKE', '%' . $request->get('name2') . '%');
            }
            if ($request->has('family2')) {
                $query->where('users.family', 'LIKE', '%' . $request->get('family2') . '%');
            }
        }
        $data = $query->orderBy('private_messages.created_at', 'DESC')->paginate(15);

        return View('admin.private-message.index')
            ->with('data', $data);
    }

    public function getInbox(Request $request)
    {
        $query = PrivateMessages::select('*','private_messages.created_at as created_at');
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
        $query->where('user_id_to',Auth::User()->id)->where('to_status','>',0);
        $data = $query->orderBy('private_messages.created_at', 'DESC')->paginate(15);

        return View('admin.private-message.inbox')
            ->with('data', $data);
    }

    public function getOutbox(Request $request)
    {
        $query = PrivateMessages::select('*','private_messages.created_at as created_at');
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
        $query->where('user_id_from',Auth::User()->id)
            ->where('from_status','>',0);
        $data = $query->orderBy('private_messages.created_at', 'DESC')->paginate(15);

        return View('admin.private-message.outbox')
            ->with('data', $data);
    }

    public function getSend()
    {
        return view('admin.private-message.send');
    }
    public function getReplay($id)
    {
        $msg=PrivateMessages::where('user_id_to',Auth::user()->id)->findOrFail($id);

        return view('admin.private-message.replay')
            ->with('subject','پاسخ: '.$msg->subject)
            ->with('id',$id);
    }
    public function postReplay(PrivateMessagesRequest $request,$id)
    {
        $input = $request->except('_token');
        $pm = PrivateMessages::where('user_id_to',Auth::user()->id)->findOrFail($id);
        PrivateMessages::create([
            'user_id_from'=>Auth::User()->id,
            'user_id_to'=>$pm->user_id_from,
            'subject'=>$request->get('subject'),
            'message'=>$request->get('message'),
        ]);

        return Redirect::action('Admin\PrivateMessagesController@getOutbox')->with('success', 'پیام با موفقیت ارسال شد.');
    }
    public function postSend(PrivateMessagesRequest $request)
    {
        $input = $request->except('_token');

        PrivateMessages::create([
            'user_id_from'=>Auth::User()->id,
            'user_id_to'=>$request->get('user_id_to'),
            'subject'=>$request->get('subject'),
            'message'=>$request->get('message'),
        ]);

        return Redirect::action('Admin\PrivateMessagesController@getOutbox')->with('success', 'پیام با موفقیت ارسال شد.');
    }
    public function getEdit($id)
    {
        $data=PrivateMessages::find($id);
        return view('admin.private-message.edit')
            ->with('data',$data);
    }
    public function postUser(PrivateMessagesRequest $request)
    {
        $data = User::where('id', $request->get('code'))->first();
        if ($data)
            return response()->json(['status' => 'success', 'data' => $data->name . ' ' . $data->family]);
        else
            return response()->json(['status' => 'error']);
    }

    public function postEdit($id, PrivateMessagesRequest $request)
    {
        $input = $request->except('_token');

        $pm = PrivateMessages::find($id);
        $pm->where('id', $id)->update($input);
        event(new LogUserEvent($pm->id, 'edit', Auth::user()->id));


        return Redirect::action('Admin\PrivateMessagesController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');
    }

    public function postAdd(PrivateMessagesRequest $request)
    {
        $input = $request->all();
        $newsletter = PrivateMessages::create($input);

        event(new LogUserEvent($newsletter->id, 'add', Auth::user()->id));
        return Redirect::action('Admin\PrivateMessagesController@getIndex')->with('success', 'پیام با موفقیت ارسال شد.');
    }

    public function postDelete(PrivateMessagesRequest $request)
    {
        if (PrivateMessages::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\PrivateMessagesController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }



}
