<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\ProjectRequiredRequest;
use App\Models\ProjectRequired;
use App\Models\ProjectRequiredStatus;
use App\Models\State;
use Classes\UserCheck;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProjectRequiredController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = ProjectRequired::query();
        $query->join('users', 'project_required.user_id', '=', 'users.id')
            ->with('supervisorInfo', 'projectRequiredStatus');

        if ($request->has('search')) {

            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('start_interview') and $request->has('end_interview')) {
                $start = explode('/', $request->get('start_interview'));
                $end = explode('/', $request->get('end_interview'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('users.date_interview', array($s, $e));
            }
            if ($request->has('name')) {
                $query->where('users.name', 'LIKE', '%' . $request->get('name') . '%');
            }
            if ($request->has('family')) {
                $query->where('users.family', 'LIKE', '%' . $request->get('family') . '%');
            }
            if ($request->has('email')) {
                $query->where('users.email', 'LIKE', '%' . $request->get('email') . '%');
            }
            if ($request->has('user_code')) {
                $query->where('users.user_code', $request->get('user_code'));
            }
            if ($request->has('id')) {
                $query->where('users.id', $request->get('id'));
            }
            if ($request->has('state_id')) {
                $query->join('user_info', 'users.id', '=', 'user_info.user_id')
                    ->where('user_info.state_id', $request->get('state_id'));
            }
            if ($request->get('sort') == 'date_interview') {
                $query->orderBy('users.date_interview', 'DESC');
            } else {
                $query->orderBy('users.id', 'DESC');
            }
        }

        if (!$request->has('sort')) {
            $query->orderBy('users.id', 'DESC');
        }

        $data = $query->select([
            'project_required.id as id',
            'users.name as name',
            'users.family as family',
            'users.user_code as user_code',
            'project_required.status_id as status_id',
            'project_required.supervisor as supervisor',
            'project_required.title as title',
        ])->paginate(15);

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'همه'] + $state_id;

        $sort = [
            'id' => 'کد یکتا',
            'date_interview' => 'تاریخ مصاحبه',
        ];
        return View('admin.project-required.index')
            ->with('state_id', $state_id)
            ->with('sort', $sort)
            ->with('data', $data);
    }

    public function getEdit($id)
    {
        $data = ProjectRequired::whereId($id)
            ->first();
        $status = ProjectRequiredStatus::all();
        return View('admin.project-required.edit')
            ->with('status', $status)
            ->with('data', $data);
    }

    public function postEdit($id, ProjectRequiredRequest $request)
    {

        if (Auth::user()->hasPermission('project-required.editProject')) {
            $input['title'] = $request->get('title');
            $input['abstract'] = $request->get('abstract');
            $input['content'] = $request->get('content');
            $input['source'] = $request->get('source');
        }
        $input['description_extra'] = $request->get('description_extra');
        $input['status_id'] = $request->get('status_id');
        ProjectRequired::whereId($id)
            ->update($input);
        event(new LogUserEvent($id, 'edit', Auth::user()->id));
        return Redirect::action('Admin\ProjectRequiredController@getIndex')
            ->with('success', 'کاربر با موفقیت ویرایش شد.');
    }

    public function getPdf($id)
    {
        $data = ProjectRequired::find($id);
        $chcker = new UserCheck();
        $chcker->projectPdf($data);
        return Redirect::back();
    }
}
