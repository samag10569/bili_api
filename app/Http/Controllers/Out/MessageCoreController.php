<?php

namespace App\Http\Controllers\Out;

use App\Http\Requests\MessageCoreRequest;
use App\Models\MessageCore;
use App\Models\MessageCoreReply;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Auth;
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
                $query->where('status',$request->get('status'));
            }


        }

        $data = $query->paginate(15);
        $status = array(
            ""=>"همه",
            "0"=>"در انتظار پاسخ ",
            "1"=>"پاسخ داده شده",
            "2"=>"بسته شده"
        );

        return View('out.message-core.index')
            ->with('data', $data)->with('status', $status);
    }

    public function getClose($id)
    {
        $msg = MessageCore::find($id);
        $msg->status = 2;
        $msg->save();
        return Redirect::back()->with('success', 'آیتم مورد نظر با موفقیت بسته شد.');

    }


    public function getView($id)
    {
        $data = MessageCore::find($id);


            $msg_reply = MessageCoreReply::where('message_core_id', $id)->orderBy('created_at','ASC')->get();

            return View('out.message-core.view')
                ->with('data', $data)->with('msg_reply', $msg_reply);

    }


    public function postView($id, MessageCoreRequest $request)
    {

        $msg = MessageCore::find($id);

        if ($msg->status != 2) {
        $msg->status = 1;
        $msg->save();


        $input = $request->except('_token');
        $reply =  new MessageCoreReply();
        $reply->content = $input['reply'];
        $reply->message_core_id = $id;
        $reply->admin_id = Auth::user()->id;
        $reply->save();



        return Redirect::back()->with('success', 'با موفقیت پاسخ داده شد.');

            }
        else
        {
            return Redirect::back()->with('error', 'این پیام بسته شده بود .');
        }
    }

    public function postDelete(MessageCoreRequest $request)
    {
        if (MessageCore::destroy($request->get('deleteId'))) {
            return Redirect::action('Out\MessageCoreController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }
}
