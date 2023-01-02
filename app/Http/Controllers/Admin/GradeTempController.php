<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Models\Degree;
use App\Models\Grade;
use App\Models\GradeFile;
use App\Models\GradeTemp;
use App\Models\State;
use App\Models\UserInfo;
use App\User;
use Classes\UserCheck;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GradeTempController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = User::query();
        $query->join('grade_temp', 'users.id', '=', 'grade_temp.user_id')
            ->with('admin', 'info', 'register', 'userStatus');

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

                $query->whereBetween('date_interview', array($s, $e));
            }
            if ($request->has('name')) {
                $query->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }
            if ($request->has('family')) {
                $query->where('family', 'LIKE', '%' . $request->get('family') . '%');
            }
            if ($request->has('email')) {
                $query->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }
            if ($request->has('user_code')) {
                $query->where('user_code', $request->get('user_code'));
            }
            if ($request->has('id')) {
                $query->where('id', $request->get('id'));
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
            'users.id as id',
            'users.name as name',
            'users.family as family',
            'users.user_code as user_code',
            'users.admin_id as admin_id',
            'users.register_id as register_id',
            'users.mobile as mobile',
            'users.status_id as status_id',
            'users.email as email',
            'users.created_at as created_at',
            'users.date_interview as date_interview',
            'users.phone_call as phone_call',
        ])->paginate(15);

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'همه'] + $state_id;

        $sort = [
            'id' => 'کد یکتا',
            'date_interview' => 'تاریخ مصاحبه',
        ];
        return View('admin.grade-temp.index')
            ->with('state_id', $state_id)
            ->with('sort', $sort)
            ->with('data', $data);
    }

    public function getEdit($user_id)
    {
        $grade_temp = GradeTemp::whereUserId($user_id)->first();
        if (!$grade_temp)
            abort(404);

        $grade_file = GradeFile::whereUserId($user_id)->first();
        $user = User::select('id', 'name', 'family', 'user_code')->find($user_id);
        return View('admin.grade-temp.grade')
            ->with('user', $user)
            ->with('grade_temp', $grade_temp)
            ->with('grade_file', $grade_file);
    }

    public function postEdit($user_id, Request $request)
    {
        $input = $request->all();
        unset($input['_token']);

        $grade_data = [];
        if (Grade::whereUserId($user_id)->exists()) {
            $grade_data = Grade::whereUserId($user_id)->first();
        } else {
            $input_new['user_id'] = $user_id;
            Grade::create($input_new);
        }

        //__________________________________________Check DB______________________________________________________

        if (!$request->has('education')) $input['education'] = $grade_data->education;
        if (!$request->has('prizes')) $input['prizes'] = $grade_data->prizes;
        if (!$request->has('membership')) $input['membership'] = $grade_data->membership;
        if (!$request->has('writing')) $input['writing'] = $grade_data->writing;
        if (!$request->has('activity')) $input['activity'] = $grade_data->activity;
        if (!$request->has('education_courses')) $input['education_courses'] = $grade_data->education_courses;
        if (!$request->has('research_projects')) $input['research_projects'] = $grade_data->research_projects;
        if (!$request->has('services_caribbean')) $input['services_caribbean'] = $grade_data->services_caribbean;


        if (!$request->has('project_required1')) $input['project_required1'] = $grade_data->project_required1;
        if (!$request->has('project_required2')) $input['project_required2'] = $grade_data->project_required2;
        if (!$request->has('project_required3')) $input['project_required3'] = $grade_data->project_required3;
        if (!$request->has('project_required4')) $input['project_required4'] = $grade_data->project_required4;
        if (!$request->has('project_required5')) $input['project_required5'] = $grade_data->project_required5;

        if (!$request->has('invention1')) $input['invention1'] = $grade_data->invention1;
        if (!$request->has('invention2')) $input['invention2'] = $grade_data->invention2;
        if (!$request->has('invention3')) $input['invention3'] = $grade_data->invention3;
        if (!$request->has('invention4')) $input['invention4'] = $grade_data->invention4;
        if (!$request->has('invention5')) $input['invention5'] = $grade_data->invention5;

        if (!$request->has('use_of_services1')) $input['use_of_services1'] = $grade_data->use_of_services1;
        if (!$request->has('use_of_services2')) $input['use_of_services2'] = $grade_data->use_of_services2;
        if (!$request->has('use_of_services3')) $input['use_of_services3'] = $grade_data->use_of_services3;
        if (!$request->has('use_of_services4')) $input['use_of_services4'] = $grade_data->use_of_services4;
        if (!$request->has('use_of_services5')) $input['use_of_services5'] = $grade_data->use_of_services5;


        $checker = new UserCheck();
        $score = $checker->gradeScore($input);

        if (!$request->has('equivalent_persian')) $input['equivalent_persian'] = $grade_data->equivalent_persian;
        if (!$request->has('scientific_certification_persian')) $input['scientific_certification_persian'] = $grade_data->scientific_certification_persian;
        if (!$request->has('scientific_certification_english')) $input['scientific_certification_english'] = $grade_data->scientific_certification_english;

        $input['user_id'] = $user_id;
        $input['admin_id'] = Auth::user()->id;

        $grade = Degree::where('min', '<=', $score)
            ->where('max', '>', $score)
            ->firstorfail();

        if (Grade::whereUserId($user_id)->exists()) {
            Grade::whereUserId($user_id)->update($input);
        } else {
            Grade::create($input);
        }
        $grade_data = Grade::whereUserId($user_id)->first();
        UserInfo::whereUserId($user_id)
            ->update([
                'grade_score' => $score,
                'grade' => $grade->title,
                'degree_id' => $grade->id
            ]);
        $checker->scoreUserGrade($user_id);
        $user = User::select('id', 'name', 'family', 'user_code')->find($user_id);
        GradeTemp::whereUserId($user_id)->delete();
        event(new LogUserEvent($input['user_id'], 'grade_temp', Auth::user()->id));

        return View('admin.grade-temp.grade-print')
            ->with('score', $score)
            ->with('user', $user)
            ->with('grade_data', $grade_data);
    }

}
