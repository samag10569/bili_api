<?php

namespace App\Http\Controllers\Admin;

use App\Models\Logs;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LogsController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Logs::query();
        $query->with('user');

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
            if ($request->has('admin_id')) {
                $query->where('admin_id', $request->get('admin_id'));
            }

        }

        if (!$request->has('sort')) {
            $query->orderBy('logs.id', 'DESC');
        }

        $data = $query->paginate(15);
        $admins = User::select(DB::raw("CONCAT(name,' ',family) AS title"), 'id')->where('admin', 1)->pluck('title', 'id')->all();
        $admins = ['' => 'همه'] + (array)$admins;
        $titles = [];
//        $titles = Logs::select('title')->groupby('title')->pluck('title', 'title')->all();
//        $titles = ['' => 'همه'] + (array)$titles;
//

        return View('admin.logs.index')
            ->with('data', $data)
            ->with('admins', $admins)
            ->with('titles', $titles);//Must be Dynamic - Predefine
    }

}
