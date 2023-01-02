<?php

namespace App\Http\Controllers\Crm;

use App\Http\Requests\CoreMessageRequest;
use App\Models\CoreMessage;
use App\Models\FactualyList;
use App\Models\MessageCoreReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CoreMessageController extends Controller
{
    public function getIndex(Request $request)
    {
        $user = Auth::user();
        if ($user->core_scientific) {
            $access = $user->factualyList->pluck('id');

            $query = CoreMessage::query();
            $query->whereIn('factualy_id', $access)
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

            $data = $query->latest()->paginate(15);
            $status = array(
                "0" => "در انتظار پاسخ ",
                "1" => "پاسخ داده شده",
                "2" => "بسته شده"
            );

            return View('crm.core-message.index-core')
                ->with('data', $data)
                ->with('status', $status);

        } else {
            $query = CoreMessage::query();
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

            $flist = FactualyList::where('version', 1)->pluck('title', 'id')->all();
            $flist = ['' => 'انتخاب کنید . . .'] + $flist;

            return View('crm.core-message.index')
                ->with('data', $data)
                ->with('status', $status)
                ->with('flist', $flist);
        }
    }

    public function getClose($id)
    {
        $user = Auth::user();
        if ($user->core_scientific) {
            $access = $user->factualyList->pluck('id');
            $msg = CoreMessage::whereIn('factualy_id', $access)->find($id);
            if (!$msg)
                abort(404);
        } else {
            $msg = CoreMessage::where('user_id', $user->id)->find($id);
            if (!$msg)
                abort(404);
        }
        $msg->update(['status' => 2]);
        return Redirect::back()->with('success', 'آیتم مورد نظر با موفقیت بسته شد.');

    }

    public function getView($id)
    {

        $user = Auth::user();
        if ($user->core_scientific) {
            $access = $user->factualyList->pluck('id');
            $data = CoreMessage::whereIn('factualy_id', $access)->find($id);
            if (!$data)
                abort(404);
            $msg_reply = MessageCoreReply::where('message_core_id', $id)->latest()->get();

            return View('crm.core-message.view-core')
                ->with('data', $data)
                ->with('msg_reply', $msg_reply);
        } else {
            $data = CoreMessage::where('user_id', $user->id)->find($id);
            if (!$data)
                abort(404);
            $msg_reply = MessageCoreReply::where('message_core_id', $id)->latest()->get();

            return View('crm.core-message.view')
                ->with('data', $data)
                ->with('msg_reply', $msg_reply);
        }
    }


    public function postView($id, CoreMessageRequest $request)
    {
        $user = Auth::user();
        $input = $request->except('_token');
        if ($user->core_scientific) {
            $access = $user->factualyList->pluck('id');
            $msg = CoreMessage::whereIn('factualy_id', $access)
                ->where('status', '<>', 2)
                ->find($id);
            if (!$msg) abort(404);
            $msg->update(['status' => 1]);
            $input['admin_id'] = $user->id;
        } else {
            $msg = CoreMessage::where('user_id', $user->id)
                ->where('status', '<>', 2)
                ->find($id);
            if (!$msg) abort(404);
            $msg->update(['status' => 0]);
            $input['user_id'] = $user->id;
        }
        $input['message_core_id'] = $id;
        MessageCoreReply::create($input);

        return Redirect::back()->with('success', 'با موفقیت پاسخ داده شد.');
    }

    public function postTicket(CoreMessageRequest $request)
    {
        $input = $request->except('_token');
        $input['file'] = 0;
        $input['user_id'] = Auth::id();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $ext = ['doc', 'docx', 'pdf']; // other
            $path = 'assets/uploads/core-message/';
            if (in_array($extension, $ext)) {
                $fileName = str_random(12) . md5(microtime()) . ".$extension";
                $file->move($path, $fileName);
                $input['file'] = $fileName;
            } else {
                return Redirect::back()->withInput()->with('error', 'فایل ارسالی صحیح نیست.');
            }
        }
        CoreMessage::create($input);
        return Redirect::back()->with('success', 'با موفقیت ثبت شد.');
    }
}
