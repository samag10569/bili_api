<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\ContactsListRequest;
use App\Models\ContactsList;
use App\Http\Controllers\Controller;
use App\Models\EmailSend;
use App\Models\EmailSendUser;
use Classes\UserCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ContactsListController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = ContactsList::query();
        $query->with('user');
        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('user_id')) {
                $query->where('user_id', $request->get('user_id'));
            }
            if ($request->has('email')) {
                $query->where('email', $request->get('email'));
            }
            if ($request->has('name')) {
                $query->where('name', $request->get('name'));
            }
            if ($request->has('status')) {
                $query->where('status', $request->get('status'));
            }
            if ($request->has('send_email')) {
                $query->where('send_email', $request->get('send_email'));
            }
        }
        $data = $query->orderBy('created_at', 'DESC')->paginate(15);

        $status = [
            '' => 'همه',
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $send_email = [
            '' => 'همه',
            '1' => 'ارسال شده',
            '0' => 'ارسال نشده',
        ];

        return View('admin.contacts-list.index')
            ->with('status', $status)
            ->with('send_email', $send_email)
            ->with('data', $data);
    }

    public function getEmail(Request $request)
    {
        $query = EmailSend::query();
        $query->whereType('introduction')
            ->with('emailUser', 'emailUserSuccess');
        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('subject')) {
                $query->where('subject', $request->get('subject'));
            }
        }
        $data = $query->latest()->paginate(15);

        return View('admin.contacts-list.email-list')
            ->with('data', $data);
    }

    public function getSetting($id)
    {
        $emailSend = EmailSend::find($id);
        $emailSend->status = !$emailSend->status;
        $emailSend->save();
        return Redirect::back()->with('success', 'عملیات با موفقیت انجام شد.');
    }

    public function getAdd()
    {
        $send_email = [
            '' => 'همه',
            '1' => 'ارسال شده',
            '0' => 'ارسال نشده',
        ];
        return view('admin.contacts-list.add')
            ->with('send_email', $send_email);
    }

    public function postAdd(ContactsListRequest $request)
    {
        $input = $request->all();
        $input['type'] = 'introduction';
        $email_send = EmailSend::create($input);

        $query = ContactsList::query();
        $query->whereStatus(0);

        if ($request->has('start') and $request->has('end')) {
            $start = explode('/', $request->get('start'));
            $end = explode('/', $request->get('end'));

            $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
            $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

            $query->whereBetween('created_at', array($s, $e));
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        if ($request->has('send_email')) {
            $query->where('send_email', $request->get('send_email'));
        }

        $data = $query->select(['id', 'name', 'email'])->get();

        foreach ($data as $item) {
            $input_user = [
                'email_send_id' => $email_send->id,
                'user_id' => $item->id,
                'status' => 0,
                'type' => $email_send->type,
            ];
            EmailSendUser::create($input_user);
        }
        event(new LogUserEvent($email_send->id, 'add', Auth::user()->id));
        return Redirect::action('Admin\ContactsListController@getEmail')->with('success', 'آیتم جدید اضافه شد.');
    }

    public function getEdit($id)
    {
        $data = EmailSend::find($id);
        return View('admin.contacts-list.edit')
            ->with('data', $data);

    }

    public function postEdit($id, ContactsListRequest $request)
    {

        $input = $request->except('_token');

        $data = EmailSend::find($id);
        $data->update($input);

        return Redirect::action('Admin\ContactsListController@getEmail')
            ->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(ContactsListRequest $request)
    {
        EmailSendUser::whereIn('email_send_id', $request->get('deleteId'))->delete();
        if (EmailSend::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\ContactsListController@getEmail')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }


    public function postDeleteError(ContactsListRequest $request)
    {
        EmailSendUser::whereIn('user_id', $request->get('deleteId'))
            ->whereType('introduction')
            ->whereStatus(0)
            ->delete();
        if (ContactsList::destroy($request->get('deleteId'))) {
            return Redirect::back()
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

    public function getEmailTest()
    {
        $checker = new UserCheck();
        $checker->emailContactQueue(1, [], true);
        return Redirect::back()->with('success', config('options.email') . ' ایمیل تست با موفقیت ارسال شد. ');
    }

}
