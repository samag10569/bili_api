<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\UserRequest;
use App\Models\AllotmentCategory;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\UserTransaction;
use App\User;
use Classes\Resizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = UserTransaction::query();

        if ($request->has('search')) {

            if ($request->has('start') and $request->has('end')) {

                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }


        }

        if ($request->has('user')) {
            $query->where('user_id',$request->get('user'));
        }

        $data = $query->paginate(15);
        //dd($data);

        return view('admin.transaction.index')
            ->with('data', $data);
    }


}
