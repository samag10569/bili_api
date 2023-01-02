<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\NewsletterRequest;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Credibility;
use App\Models\Degree;
use App\Models\Newsletter;
use App\Models\NewsletterSent;
use App\Models\NewsletterUsers;
use App\Models\Reshteh;
use App\Models\Skills;
use App\Models\State;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class MsgController extends Controller
{

    public function getIndex(Request $request)
    {
        $query = DB::table('notification');

        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('subject')) {
                $query->where('subject', '<', $request->get('subject'));
            }
        }
        $data = $query->orderBy('created_at', 'DESC')->paginate(15);

        return view('admin.msgs.index')
            ->with('data', $data);
    }

    public function getAdd()
    {

        $gender = [
            '' => 'انتخاب کنید',
            '1' => 'آقا',
            '2' => 'خانم',
        ];
        $branch_id = Branch::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $branch_id = ['' => 'همه'] + $branch_id;

        $shakhe  = Category::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $shakhe = ['' => 'همه'] + $shakhe;

        $reshteh  = Reshteh::pluck('title', 'id')->all();
        $reshteh = ['' => 'همه'] + $reshteh;


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

        $skills = Skills::Orderby('title', 'ASC')->select(['title', 'id'])->get();
        $skillId = [];

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


        return view('admin.msgs.add')
            ->with('gender', $gender)
            ->with('shakhe', $shakhe)
            ->with('reshteh', $reshteh)
            ->with('state_id', $state_id)
            ->with('skills', $skills)
            ->with('skillId', $skillId)
            ->with('degree_id', $degree_id)
            ->with('credibility_id', $credibility_id)
            ->with('sort', $sort)
            ->with('admin_id', $admin_id)
            ->with('branch_id', $branch_id)
            ->with('core_scientific', $core_scientific)
            ->with('interview_type_id', $interview_type_id)
            ->with('category_id', $category_id);

    }

    public function postAdd(Request $request)
    {
        $input = $request->only('title','body');
        $input['created_at']=time();
        $input['updated_at']=time();




        $query = User::query();
        $query->whereNull('delete_temp');

        if ($request->has('start') and $request->has('end')) {
            $start = explode('/', $request->get('start'));
            $end = explode('/', $request->get('end'));

            $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
            $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

            $query->whereBetween('users.created_at', array($s, $e));
        }

        if ($request->has('name')) {
            $query->where('users.name', 'LIKE', '%' . $request->get('name') . '%');
        }
        if ($request->has('family')) {
            $query->where('users.family', 'LIKE', '%' . $request->get('family') . '%');
        }
        if ($request->has('mobile1')) {

            $query->where('users.mobile', '>=', $request->get('mobile1'));
        }
        if ($request->has('mobile2')) {

            $query->where('users.mobile', '<=', $request->get('mobile2'));
        }
        /*if ($request->has('mobile')) {
            $query->where('mobile', 'LIKE', '%' . $request->get('mobile') . '%');
        }
        */
        if ($request->has('email')) {
            $query->where('users.email', 'LIKE', '%' . $request->get('email') . '%');
        }
        if ($request->has('user_code')) {
            $query->where('users.user_code', $request->get('user_code'));
        }
        if ($request->has('gender')) {
            $query->where('users.gender', $request->get('gender'));
        }
        /*if ($request->has('admin_id')) {
            $query->where('admin_id', $request->get('admin_id'));
        }*/
        if ($request->has('state')) {
            $query->where('users.state_id', $request->get('state'));
        }
        if ($request->has('city')) {
            $query->where('users.city', 'LIKE', '%' . $request->get('city') . '%');
        }
        if ($request->has('ncode1')) {

            $query->where('users.ncode', '>=', $request->get('ncode1'));
        }
        if ($request->has('ncode2')) {

            $query->where('users.ncode', '<=', $request->get('ncode2'));
        }
        if ($request->has('postal_code1')) {

            $query->where('users.postal_code', '>=' , $request->get('postal_code1'));
        }
        if ($request->has('postal_code2')) {

            $query->where('users.postal_code', '>=' , $request->get('postal_code2'));
        }
        if ($request->has('branch')) {
            $query->where('users.branch', 'LIKE', '%' . $request->get('branch') . '%');
        }
        if ($request->has('shakhe')) {
            $query->where('users.shakhe', $request->get('shakhe'));
        }
        if ($request->has('reshteh')) {
            $query->where('users.reshteh1', $request->get('reshteh'));
        }

        $data = $query->select([
            'users.id as id',
        ])->get();
        $input2=$input;
        $input['count']=count($data);
        $newsletter = DB::table('notification')->insertGetId($input);

        $input2['not_id']=$newsletter;
        foreach($data as $row){
            $input2['user_id']=$row->id;

             DB::table('notifications')->insert($input2);
        }


        return Redirect::action('Admin\MsgController@getIndex')->with('success', 'آیتم جدید اضافه شد.');
    }

    public function postDelete(NewsletterRequest $request)
    {
        DB::table('notifications')->whereIn('not_id',$request->get('deleteId'))->delete();
        DB::table('notification')->whereIn('id',$request->get('deleteId'))->delete();
            return Redirect::action('Admin\MsgController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');

    }

}
