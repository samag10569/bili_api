<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SkillsRequest;
use App\Models\Skills;
use Classes\Resizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class SkillsController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Skills::query();

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

        }

        if (!$request->has('sort')) {
            $query->orderBy('skills.id', 'DESC');
        }

        $data = $query->paginate(15);

        return View('admin.skills.index')
            ->with('data', $data);
    }

    public function getAdd()
    {
        return View('admin.skills.add');
    }

    public function postAdd(SkillsRequest $request)
    {
        $input = $request->all();

        Skills::create($input);

        return Redirect::action('Admin\SkillsController@getIndex')
            ->with('success', 'مهارت جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Skills::find($id);

        return View('admin.skills.edit')
             ->with('data', $data);

    }


    public function postEdit($id, SkillsRequest $request)
    {

        $input = $request->except('_token');

        $services = Skills::find($id);

        $services->where('id', $id)->update($input);


        return Redirect::action('Admin\SkillsController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(SkillsRequest $request)
    {
        if (Skills::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\SkillsController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }
}
