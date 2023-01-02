<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\IgnoreEmailRequest;
use App\Models\IgnoreEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class IgnoreEmailController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = IgnoreEmail::query();

        if ($request->has('search')) {

            if ($request->has('start') and $request->has('end')) {

                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }

            if ($request->has('email')) {
                $query->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }

        }
        $data = $query->latest()->paginate(15);

        return View('admin.ignore-email.index')
            ->with('data', $data);
    }

    public function postDelete(IgnoreEmailRequest $request)
    {
        if (IgnoreEmail::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\IgnoreEmailController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }
}
