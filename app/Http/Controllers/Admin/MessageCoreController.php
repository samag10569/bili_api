<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MessageCoreRequest;
use App\Models\MessageCore;
use App\Models\MessageCoreReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class MessageCoreController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = MessageCore::query();
        $query->with('factualy');
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

        $data = $query->paginate(15);
        $status = array(
            "" => "همه",
            "0" => "در انتظار پاسخ ",
            "1" => "پاسخ داده شده",
            "2" => "بسته شده"
        );

        return View('admin.message-core.index')
            ->with('data', $data)->with('status', $status);
    }

    public function getClose($id)
    {
        MessageCore::whereId($id)->update(['status'=> 2]);
        return Redirect::back()->with('success', 'آیتم مورد نظر با موفقیت بسته شد.');

    }


    public function getView($id)
    {
        $data = MessageCore::find($id);
        return View('admin.message-core.view')
            ->with('data', $data);
    }


    public function postView($id, MessageCoreRequest $request)
    {
        $input = $request->except('_token');
        $msg = MessageCore::find($id);

        $reply = new MessageCoreReply();
        $reply->content = $input['reply'];
        $reply->message_core_id = $id;
        $reply->admin_id = Auth::user()->id;
        $reply->save();

        $msg->update(['status'=> 1]);

        return Redirect::back()->with('success', 'با موفقیت پاسخ داده شد.');
    }

    public function postDelete(MessageCoreRequest $request)
    {
        $images = MessageCore::whereIn('id', $request->get('deleteId'))->pluck('file')->all();
        foreach ($images as $item) {
            File::delete('assets/uploads/core-message/' . $item);
        }
        if (MessageCore::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\MessageCoreController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }
}
