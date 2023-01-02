<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Credibility;
use App\Models\Degree;
use App\Models\State;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExcelMemberController extends Controller
{
    public function getIndex()
    {
        $branch_id = Branch::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $branch_id = ['' => 'همه'] + $branch_id;

        $category_id = Category::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $category_id = ['' => 'همه'] + $category_id;

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'همه'] + $state_id;

        $degree_id = Degree::Orderby('listorder', 'ASC')->pluck('title', 'title')->all();
        $degree_id = ['' => 'همه'] + $degree_id;

        $credibility_id = Credibility::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $credibility_id = ['' => 'همه'] + $credibility_id;

        $admins = User::whereAdmin(1)->Orderby('family', 'ASC')->select(['name', 'family', 'id'])->get();
        $admin_id = ['' => 'همه'];
        foreach ($admins as $admin) {
            $admin_id[$admin->id] = $admin->name . ' ' . $admin->family;
        }

        $sort = [
            'id' => 'کد یکتا',
            'date_interview' => 'تاریخ مصاحبه',
        ];

        $core_scientific = [
            '' => 'همه',
            '0' => 'ندارد',
            '1' => 'دارد',
        ];

        $interview_type_id = [
            '' => 'همه',
            '0' => 'غیر حضوری',
            '1' => 'حضوری',
        ];

        return view('admin.excel-member.index')
            ->with('state_id', $state_id)
            ->with('degree_id', $degree_id)
            ->with('credibility_id', $credibility_id)
            ->with('sort', $sort)
            ->with('admin_id', $admin_id)
            ->with('branch_id', $branch_id)
            ->with('core_scientific', $core_scientific)
            ->with('interview_type_id', $interview_type_id)
            ->with('category_id', $category_id);

    }

    public function getResualt(Request $request)
    {
        $query = User::query();
        $query->whereMember(1)
            ->whereNull('delete_temp')
            ->with('admin', 'register', 'userStatus', 'userContent', 'category', 'branchInfo', 'info', 'info.credibility', 'info.state')
            ->join('user_info', 'users.id', '=', 'user_info.user_id');

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


        if (!$request->has('status_id_1') and !$request->has('status_id_2') and !$request->has('status_id_3') and !$request->has('status_id_4') and !$request->has('status_id_5')) {

        } else {
            $status = [];
            if ($request->has('status_id_1')) $status[] = $request->get('status_id_1');

            if ($request->has('status_id_2')) $status[] = $request->get('status_id_2');

            if ($request->has('status_id_3')) $status[] = $request->get('status_id_3');

            if ($request->has('status_id_4')) $status[] = $request->get('status_id_4');

            if ($request->has('status_id_5')) $status[] = $request->get('status_id_5');

            $query->whereIn('status_id', $status);
        }

        if ($request->has('rejection')) {
            $query->where('rejection', $request->get('rejection'));
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
        if ($request->has('admin_id')) {
            $query->where('admin_id', $request->get('admin_id'));
        }
        if ($request->has('state_id')) {
            $query->where('user_info.state_id', $request->get('state_id'));
        }
        if ($request->has('degree_id')) {
            $query->where('user_info.grade', $request->get('degree_id'));
        }
        if ($request->has('credibility_id')) {
            $query->where('user_info.credibility_id', $request->get('credibility_id'));
        }
        if ($request->has('interview_type_id')) {
            $query->where('user_info.interview_type_id', $request->get('interview_type_id'));
        }
        if ($request->has('branch')) {
            $query->where('user_info.branch', 'LIKE', '%' . $request->get('branch') . '%');
        }
        if ($request->has('employment_status')) {
            $query->where('user_info.employment_status', 'LIKE', '%' . $request->get('employment_status') . '%');
        }
        if ($request->has('article_title')) {
            $query->where('user_info.article_title', 'LIKE', '%' . $request->get('article_title') . '%');
        }
        if ($request->has('ideas_title')) {
            $query->where('user_info.ideas_title', 'LIKE', '%' . $request->get('ideas_title') . '%');
        }
        if ($request->has('expertise_title')) {
            $query->where('user_info.expertise_title', 'LIKE', '%' . $request->get('expertise_title') . '%');
        }
        if ($request->has('invention_title')) {
            $query->where('user_info.invention_title', 'LIKE', '%' . $request->get('invention_title') . '%');
        }
        if ($request->has('article')) {
            $query->where('user_info.article', $request->get('article'));
        }
        if ($request->has('ideas')) {
            $query->where('user_info.ideas', $request->get('ideas'));
        }
        if ($request->has('expertise')) {
            $query->where('user_info.expertise', $request->get('expertise'));
        }
        if ($request->has('invention')) {
            $query->where('user_info.invention', $request->get('invention'));
        }
        if ($request->has('city')) {
            $query->where('user_info.city', 'LIKE', '%' . $request->get('city') . '%');
        }
        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->get('branch_id'));
        }
        if ($request->has('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }
        if ($request->has('core_scientific')) {
            $query->where('core_scientific', $request->get('core_scientific'));
        }

        if ($request->has('project_required')) {
            $query->join('project_required', 'users.id', '=', 'project_required.user_id');
            $query->where('project_required.title', 'LIKE', '%' . $request->get('project_required') . '%');
        }

        if ($request->has('content')) {
            $query->join('user_content', 'users.id', '=', 'user_content.user_id');
            $query->where('user_content.content', 'LIKE', '%' . $request->get('content') . '%');
        }
        if ($request->get('sort') == 'date_interview') {
            $query->orderBy('users.date_interview', 'DESC');
        } else {
            $query->orderBy('users.id', 'DESC');
        }

        $query->select([
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
            'users.branch_id as branch_id',
            'users.category_id as category_id',
            'user_info.father_name as father_name',
            'user_info.birth as birth',
            'user_info.national_id as national_id',
            'user_info.branch as branch',
            'user_info.state_id as state_id',
            'user_info.city as city',
            'user_info.grade as grade',
            'user_info.credibility_id as credibility_id',
        ]);

        $export = [];

        $query->chunk(200, function ($query) use (&$export) {

            foreach ($query as $row) {
                $admin = @$row->admin->name . ' ' . @$row->admin->family;
                if ($row->register_id == '-1') $admin .= ' - عضویت آنلاین ';
                elseif ($row->register_id != '-1' and $row->register_id != null) $admin .= ' معرفی شده توسط ' . @$row->register->name . ' ' . @$row->register->family;

                $export[] = array(
                    'نام' => $row->name . ' ' . $row->family,
                    'نام پدر' => $row->father_name,
                    'تاریخ تولد' => jdate('Y/m/d', $row->birth),
                    'ایمیل' => $row->email,
                    'شناسه کاربری' => $row->user_code,
                    'کد ملی' => $row->national_id,
                    'شماره تماس' => $row->mobile,
                    'مقطع تحصیلی' => @$row->branchInfo->title,
                    'شاخه تحصیلی' => @$row->category->title,
                    'رشته تحصیلی' => $row->branch,
                    'درجه علمی' => $row->grade,
                    'اعتبار طرح و ایده' => @$row->info->credibility->title,
                    'استان' => @$row->info->state->title,
                    'آدرس' => $row->city,
                    'ثبت کننده' => $admin,
                    'وضعیت' => @$row->userStatus->title,
                    'تاریخ مصاحبه' => jdate('Y/m/d', $row->date_interview),

                );
            }
        });

        Excel::create(jdate('y-m-d H-i'), function ($excel) use ($export) {

            $excel->sheet('data', function ($sheet) use ($export) {

                $sheet->fromArray($export);
            });
        })->
        download('xls');

        return 'Export Success';
    }

}
