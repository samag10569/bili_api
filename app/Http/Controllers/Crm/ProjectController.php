<?php

namespace App\Http\Controllers\Crm;

use App\Http\Requests\ProjectRequiredRequest;
use App\Models\FactualyList;
use App\Models\ProjectRequired;
use App\Models\ProjectRequiredType;
use Classes\UploadImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function getIndex()
    {
        $user = Auth::user();
        if ($user->core_scientific) {
            $data = ProjectRequired::where('supervisor', $user->id)
                ->with('projectRequiredStatus', 'user', 'projectRequiredType')
                ->latest()
                ->paginate(10);
            return View('crm.project.core-scientific')
                ->with('data', $data);
        } else {
            $type = ProjectRequiredType::all();
            $groups = FactualyList::whereType(2)->whereVersion(1)->select(['title', 'id'])->with('user')->get();
            $data = ProjectRequired::where('user_id', $user->id)
                ->with('projectRequiredStatus', 'projectRequiredType', 'supervisorInfo')
                ->latest()
                ->get();
            return View('crm.project.index')
                ->with('groups', $groups)
                ->with('type', $type)
                ->with('data', $data);
        }
    }

    public function postAdd(ProjectRequiredRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('file')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadFile($request->file('file'), 'assets/uploads/required/');
            if ($fileName) {
                $input['file'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'فایل ارسالی صحیح نیست.');
            }
        }

        $input['user_id'] = Auth::id();
        $input['status_id'] = 2;
        ProjectRequired::create($input);
        return Redirect::back()
            ->with('success', 'پروژه با موفقیت ثبت شد.');
    }

    public function postUserAjax(Request $request)
    {
        $input = $request->all();
        $returnValue['value'] = "";
        $returnValue['count'] = 0;
        $factualy = FactualyList::find($input['key']);
        if ($factualy) {
            $users = $factualy->user;
            $returnValue['count'] = count($users);
            foreach ($users as $row) {
                $returnValue['value'] .= "<option value='$row->id'>" . $row->name . ' ' . $row->family . "</option>";
            }
            $returnValue['status'] = true;
        }
        return json_encode($returnValue);
    }

    public function getView($id)
    {
        $data = ProjectRequired::whereId($id)
            ->whereSupervisor(Auth::id())
            ->with('projectRequiredStatus', 'projectRequiredType')
            ->first();
        if (!$data)
            abort(404);
        return View('crm.project.view')
            ->with('data', $data);
    }

    public function getEdit($id)
    {
        $data = ProjectRequired::whereId($id)
            ->whereSupervisor(Auth::id())
            ->with('projectRequiredStatus', 'projectRequiredType')
            ->first();
        if (!$data)
            abort(404);
        $data->status_id = 3;
        $data->save();
        return Redirect::back()->with('success', 'پروژه تایید شد.');

    }

}
