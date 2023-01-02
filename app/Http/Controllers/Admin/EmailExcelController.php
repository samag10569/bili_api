<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\EmailExcelRequest;
use App\Http\Controllers\Controller;
use App\Models\EmailExcel;
use App\Models\EmailSend;
use App\Models\EmailSendUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class EmailExcelController extends Controller
{


    public function getIndex(Request $request)
    {
        $query = EmailExcel::query();
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

        return View('admin.email-excel.index')
            ->with('status', $status)
            ->with('send_email', $send_email)
            ->with('data', $data);
    }

    public function getEmail(Request $request)
    {
        //ini_set('memory_limit', '90000000');
        $query = EmailSend::query();
        $query->whereType('excel');
        //$query->with('emailUser', 'emailUserSuccess');
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

        $info = [];
        foreach ($data as $item) {
            $info['emailUser'][$item->id] = EmailSendUser::whereEmailSendId($item->id)->count();
            $info['emailUserFaild'][$item->id] = EmailSendUser::whereEmailSendId($item->id)->whereStatus(0)->count();
            $info['emailUserSuccess'][$item->id] = EmailSendUser::whereEmailSendId($item->id)->whereStatus(1)->count();
        }

        //dd($data);

        return View('admin.email-excel.email-list')
            ->with('info', $info)
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
        return view('admin.email-excel.add')
            ->with('send_email', $send_email);
    }

    public function postAdd(EmailExcelRequest $request)
    {
        $input = $request->all();
        $input['type'] = 'excel';
        $email_send = EmailSend::create($input);

        $query = EmailExcel::query();
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
        return Redirect::action('Admin\EmailExcelController@getEmail')->with('success', 'آیتم جدید اضافه شد.');
    }


    public function getImport()
    {
        return view('admin.email-excel.import');
    }

    public function postImport(EmailExcelRequest $request)
    {
        if ($request->hasFile('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $ext = ['xls'];
            if (in_array($extension, $ext)) {
                $fileName = time() . "." . $extension;
                $request->file('file')->move('assets/uploads/excel/', $fileName);
            } else {
                return Redirect::back()->with('error', 'پسوند فایل xls باید باشد.');
            }
        }

        $excel = Excel::load("assets/uploads/excel/" . $fileName, function ($records) {
        })->get();

        foreach ($excel as $item) {
            if (!EmailExcel::whereEmail($item->email)->exists()) {
                $input_excel = [
                    'user_id' => $item->user_id,
                    'email' => $item->email,
                    'name' => $item->name,
                ];
                EmailExcel::create($input_excel);
            }
        }
        return Redirect::action('Admin\EmailExcelController@getEmail')->with('success', 'آیتم جدید اضافه شد.');
    }

    public function getEdit($id)
    {
        $data = EmailSend::find($id);
        return View('admin.email-excel.edit')
            ->with('data', $data);

    }

    public function postEdit($id, EmailExcelRequest $request)
    {

        $input = $request->except('_token');

        $data = EmailSend::find($id);
        $data->update($input);

        return Redirect::action('Admin\EmailExcelController@getEmail')
            ->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(EmailExcelRequest $request)
    {
        EmailSendUser::whereIn('email_send_id', $request->get('deleteId'))->delete();
        if (EmailSend::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\EmailExcelController@getEmail')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }


    public function postDeleteError(EmailExcelRequest $request)
    {
        EmailSendUser::whereIn('user_id', $request->get('deleteId'))
            ->whereType('excel')
            ->whereStatus(0)
            ->delete();
        if (EmailExcel::destroy($request->get('deleteId'))) {
            return Redirect::back()
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

    public function getSample()
    {
        $export[] = [
            'user_id' => 'کد یکتا معرف',
            'email' => 'ایمیل',
            'name' => 'نام',
        ];

        Excel::create('excel sample', function ($excel) use ($export) {

            $excel->sheet('data', function ($sheet) use ($export) {

                $sheet->fromArray($export);
            });
        })->download('xls');
    }

}
