<?php

namespace App\Http\Controllers\Crm;

use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\FactualyList;
use App\Models\MessageReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SupportController extends Controller
{
    public function getIndex(Request $request)
    {
        $user = Auth::user();
        $query = Message::query();
        $query->where('user_id', $user->id)
            ->with('factualy');
        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {

                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('title')) {
                $query->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }
            if ($request->has('status')) {
                $query->where('status', $request->get('status'));
            }
        }

        $data = $query->orderby('created_at', 'desc')
            ->paginate(15);
        $status = array(
            "0" => "در انتظار پاسخ ",
            "1" => "پاسخ داده شده",
            "2" => "بسته شده"
        );

        $flist = FactualyList::where('version', 2)->pluck('title', 'id')->all();
        $flist = ['' => 'انتخاب کنید . . .'] + $flist;

        return View('crm.support.index')
            ->with('data', $data)->with('status', $status)
            ->with('flist', $flist);
        
    }

    public function getClose($id)
    {
        $msg = Message::where('user_id', Auth::user()->id)->find($id);
        if (!$msg)
            abort(404);
        $msg->status = 2;
        $msg->save();
        return Redirect::back()->with('success', 'آیتم مورد نظر با موفقیت بسته شد.');

    }

    public function getView($id)
    {
        $data = Message::where('user_id', Auth::user()->id)->find($id);
        if (!$data)
            abort(404);
        $msg_reply = MessageReply::where('message_id', $id)->latest()->get();

        return View('crm.support.view')
            ->with('data', $data)
            ->with('msg_reply', $msg_reply);
    }


    public function postView($id, MessageRequest $request)
    {
        $user_id = Auth::id();
        $msg = Message::where('user_id', $user_id)
            ->where('status', '<>', 2)
            ->find($id);
        if (!$msg) abort(404);
        $msg->update(['status' => 1]);

        $input = $request->except('_token');
        $input['user_id'] = $user_id;
        $input['message_id'] = $id;
        MessageReply::create($input);

        return Redirect::back()->with('success', 'با موفقیت پاسخ داده شد.');
    }

    public function postTicket(MessageRequest $request)
    {
        $input = $request->except('_token');
        $input['file'] = 0;
        $input['user_id'] = Auth::id();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $ext = ['doc', 'docx', 'pdf']; // other
            $path = 'assets/uploads/support/';
            if (in_array($extension, $ext)) {
                $fileName = str_random(12) . md5(microtime()) . ".$extension";
                $file->move($path, $fileName);
                $input['file'] = $fileName;
            } else {
                return Redirect::back()->withInput()->with('error', 'فایل ارسالی صحیح نیست.');
            }
        }
        Message::create($input);
        return Redirect::back()->with('success', 'با موفقیت ثبت شد.');
    }
}
