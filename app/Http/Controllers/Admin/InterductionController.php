<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\InterductionRequest;
use App\Models\Interduction;
use App\Models\InterductionType;
use App\User;
use Classes\Resizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use mPDF;

//FIX by namespace
require_once(app_path() . '/../Classes/pdf/mpdf.php');

class InterductionController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Interduction::with('type', 'user');


        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {

                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('company_name')) {
                $query->where('company_name', 'LIKE', '%' . $request->get('company_name') . '%');
            }
            if ($request->has('letter_id')) {
                $query->where('letter_id', 'LIKE', '%' . $request->get('letter_id') . '%');
            }
            if ($request->has('type_id')) {
                $query->where('type_id', '=', $request->get('type_id'));
            }

        }

        if (!$request->has('sort')) {
            $query->orderBy('interduction.id', 'DESC');
        }

        $data = $query->paginate(15);

        $type_id = InterductionType::where('status', 1)->pluck('title', 'id')->all();
        $type_id = ['' => 'همه'] + (array)$type_id;

        return View('admin.interduction.index')
            ->with('data', $data)
            ->with('type_id', $type_id);
    }

    public function getAdd()
    {
        $type_id = InterductionType::where('status', 1)->pluck('title', 'id')->all();
        return View('admin.interduction.add')
            ->with('type_id', $type_id);
    }

    public function postAdd(InterductionRequest $request)
    {

        $input = $request->all();
        $input['admin_id'] = Auth::User()->id;
        $interduction = Interduction::create($input);
        event(new LogUserEvent($interduction->id, 'add', Auth::user()->id));

        $user = User::find($interduction->user_id);
        $html = view('admin.interduction.pdf')
            ->with('letter_id', $interduction->letter_id)
            ->with('date', jdate('y/m/d', $interduction->created_at->timestamp, '', '', 'en'))
            ->with('name_company', $interduction->company_name)
            ->with('name', $user->name)
            ->with('family', $user->family)
            ->with('address', $interduction->address)
            ->render();

        $pathToFile = public_path() . '/assets/uploads/interduction/';
        $mpdf = new mPDF('ar');
        $mpdf->SetDirectionality('rtl');
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pathToFile . $interduction->id . ".pdf");

        if ($mpdf) {
            $pathToFile = public_path('assets/uploads/interduction/' . $interduction->id . '.pdf');
            try {
                Mail::send('admin.interduction.email', ['user' => $user], function ($m) use ($user, $pathToFile) {
                    $m->attach($pathToFile);
                    $m->to($user->email, $user->name . ' ' . $user->family)
                        ->subject('معرفی نامه شبکه رشد علم جوان');
                });
                File::delete($pathToFile);
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }

        return Redirect::action('Admin\InterductionController@getIndex')
            ->with('success', 'معرفی نامه جدید با موفقیت ثبت شد.');
    }

    public function postUser(InterductionRequest $request)
    {
        $data = User::where('id', $request->get('code'))->first();
        if ($data)
            return response()->json(['status' => 'success', 'data' => $data['name'] . ' ' . $data->family]);
        else
            return response()->json(['status' => 'error']);
    }


    public function getEdit($id)
    {
        $data = Interduction::find($id);
        $type_id = InterductionType::where('status', 1)->pluck('title', 'id')->all();
        $users = User::select(DB::raw("CONCAT(name,' ',family) AS title"), 'id')->where('status', 1)->pluck('title', 'id')->all();

        return View('admin.interduction.edit')
            ->with('data', $data)
            ->with('type_id', $type_id)
            ->with('users', $users);

    }


    public function postEdit($id, InterductionRequest $request)
    {
        $input = $request->except('_token');

        $interduction = Interduction::find($id);

        $interduction->where('id', $id)->update($input);
        event(new LogUserEvent($interduction->id, 'edit', Auth::user()->id));


        return Redirect::action('Admin\InterductionController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(InterductionRequest $request)
    {
        if (Interduction::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\InterductionController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }
}
