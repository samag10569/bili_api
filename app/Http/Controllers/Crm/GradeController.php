<?php

namespace App\Http\Controllers\Crm;

use App\Models\AllotmentUser;
use App\Models\Grade;
use App\Models\GradeFile;
use App\Models\GradeTemp;
use Classes\UploadImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class GradeController extends Controller
{
    public function getIndex()
    {
        $user_id = Auth::id();
        $grade_data = [];
        if (Grade::whereUserId($user_id)->exists()) {
            $grade_data = Grade::whereUserId($user_id)->first();
        }
        $allotment_date = AllotmentUser::whereUserId($user_id)->with('allotment')->get();
        return view('crm.grade.index')
            ->with('allotment_date', $allotment_date)
            ->with('grade_data', $grade_data);
    }

    public function postEdit(Request $request)
    {
        $input = $request->all();
        unset($input['_token']);

        if (!$request->has('project_required1')) $input['project_required1'] = 0;
        if (!$request->has('project_required2')) $input['project_required2'] = 0;
        if (!$request->has('project_required3')) $input['project_required3'] = 0;
        if (!$request->has('project_required4')) $input['project_required4'] = 0;
        if (!$request->has('project_required5')) $input['project_required5'] = 0;

        if (!$request->has('invention1')) $input['invention1'] = 0;
        if (!$request->has('invention2')) $input['invention2'] = 0;
        if (!$request->has('invention3')) $input['invention3'] = 0;
        if (!$request->has('invention4')) $input['invention4'] = 0;
        if (!$request->has('invention5')) $input['invention5'] = 0;

        if (!$request->has('use_of_services1')) $input['use_of_services1'] = 0;
        if (!$request->has('use_of_services2')) $input['use_of_services2'] = 0;
        if (!$request->has('use_of_services3')) $input['use_of_services3'] = 0;
        if (!$request->has('use_of_services4')) $input['use_of_services4'] = 0;
        if (!$request->has('use_of_services5')) $input['use_of_services5'] = 0;

        if (!$request->has('equivalent_persian')) $input['equivalent_persian'] = 0;
        if (!$request->has('scientific_certification_persian')) $input['scientific_certification_persian'] = 0;
        if (!$request->has('scientific_certification_english')) $input['scientific_certification_english'] = 0;

        $grade_data = [];
        $input['user_id'] = Auth::id();
        if (Grade::whereUserId($input['user_id'])->exists()) {
            $grade_data = Grade::whereUserId($input['user_id'])->first();
        } else {
            $input_new['user_id'] = $input['user_id'];
            Grade::create($input_new);
        }

        if ($request->has('education') and (isset($grade_data->education) || $grade_data->education != $input['education']))
            $input_temp['education'] = $input['education'];
        else $input_temp['education'] = -1;
        if ($request->has('prizes') and (isset($grade_data->prizes) || $grade_data->prizes != $input['prizes']))
            $input_temp['prizes'] = $input['prizes'];
        else $input_temp['prizes'] = -1;
        if ($request->has('membership') and (isset($grade_data->membership) || $grade_data->membership != $input['membership']))
            $input_temp['membership'] = $input['membership'];
        else $input_temp['membership'] = -1;

        if (!isset($grade_data->project_required1) || $grade_data->project_required1 != $input['project_required1'])
            $input_temp['project_required1'] = $input['project_required1'];
        else $input_temp['project_required1'] = -1;
        if (!isset($grade_data->project_required2) || $grade_data->project_required2 != $input['project_required2'])
            $input_temp['project_required2'] = $input['project_required2'];
        else $input_temp['project_required2'] = -1;
        if (!isset($grade_data->project_required3) || $grade_data->project_required3 != $input['project_required3'])
            $input_temp['project_required3'] = $input['project_required3'];
        else $input_temp['project_required3'] = -1;
        if (!isset($grade_data->project_required4) || $grade_data->project_required4 != $input['project_required4'])
            $input_temp['project_required4'] = $input['project_required4'];
        else $input_temp['project_required4'] = -1;
        if (!isset($grade_data->project_required5) || $grade_data->project_required5 != $input['project_required5'])
            $input_temp['project_required5'] = $input['project_required5'];
        else $input_temp['project_required5'] = -1;

        if ($request->has('writing') and $grade_data->writing != $input['writing'])
            $input_temp['writing'] = $input['writing'];
        else $input_temp['writing'] = -1;

        if (!isset($grade_data->invention1) || $grade_data->invention1 != $input['invention1'])
            $input_temp['invention1'] = $input['invention1'];
        else $input_temp['invention1'] = -1;
        if (!isset($grade_data->invention2) || $grade_data->invention2 != $input['invention2'])
            $input_temp['invention2'] = $input['invention2'];
        else $input_temp['invention2'] = -1;
        if (!isset($grade_data->invention3) || $grade_data->invention3 != $input['invention3'])
            $input_temp['invention3'] = $input['invention3'];
        else $input_temp['invention3'] = -1;
        if (!isset($grade_data->invention4) || $grade_data->invention4 != $input['invention4'])
            $input_temp['invention4'] = $input['invention4'];
        else $input_temp['invention4'] = -1;
        if (!isset($grade_data->invention5) || $grade_data->invention5 != $input['invention5'])
            $input_temp['invention5'] = $input['invention5'];
        else $input_temp['invention5'] = -1;

        if ($request->has('activity') and $grade_data->activity != $input['activity'])
            $input_temp['activity'] = $input['activity'];
        else $input_temp['activity'] = -1;
        if ($request->has('education_courses') and $grade_data->education_courses != $input['education_courses'])
            $input_temp['education_courses'] = $input['education_courses'];
        else $input_temp['education_courses'] = -1;
        if ($request->has('research_projects') and $grade_data->research_projects != $input['research_projects'])
            $input_temp['research_projects'] = $input['research_projects'];
        else $input_temp['research_projects'] = -1;

        if (!isset($grade_data->use_of_services1) || $grade_data->use_of_services1 != $input['use_of_services1'])
            $input_temp['use_of_services1'] = $input['use_of_services1'];
        else $input_temp['use_of_services1'] = -1;
        if (!isset($grade_data->use_of_services2) || $grade_data->use_of_services2 != $input['use_of_services2'])
            $input_temp['use_of_services2'] = $input['use_of_services2'];
        else $input_temp['use_of_services2'] = -1;
        if (!isset($grade_data->use_of_services3) || $grade_data->use_of_services3 != $input['use_of_services3'])
            $input_temp['use_of_services3'] = $input['use_of_services3'];
        else $input_temp['use_of_services3'] = -1;
        if (!isset($grade_data->use_of_services4) || $grade_data->use_of_services4 != $input['use_of_services4'])
            $input_temp['use_of_services4'] = $input['use_of_services4'];
        else $input_temp['use_of_services4'] = -1;
        if (!isset($grade_data->use_of_services5) || $grade_data->use_of_services5 != $input['use_of_services5'])
            $input_temp['use_of_services5'] = $input['use_of_services5'];
        else $input_temp['use_of_services5'] = -1;

        if (!isset($grade_data->equivalent_persian) || $grade_data->equivalent_persian != $input['equivalent_persian'])
            $input_temp['equivalent_persian'] = $input['equivalent_persian'];
        else $input_temp['equivalent_persian'] = -1;


        if (!isset($grade_data->scientific_certification_persian) || $grade_data->scientific_certification_persian != $input['scientific_certification_persian'])
            $input_temp['scientific_certification_persian'] = $input['scientific_certification_persian'];
        else $input_temp['scientific_certification_persian'] = -1;

        if (!isset($grade_data->scientific_certification_english) || $grade_data->scientific_certification_english != $input['scientific_certification_english'])
            $input_temp['scientific_certification_english'] = $input['scientific_certification_english'];
        else $input_temp['scientific_certification_english'] = -1;

        if ($request->has('services_caribbean') and $grade_data->services_caribbean != $input['services_caribbean'])
            $input_temp['services_caribbean'] = $input['services_caribbean'];
        else $input_temp['services_caribbean'] = -1;

        $input_temp['user_id'] = $input['user_id'];

        if (GradeTemp::whereUserId($input['user_id'])->exists()) {
            GradeTemp::whereUserId($input['user_id'])->update($input_temp);
        } else {
            GradeTemp::create($input_temp);
        }

        $input_file['user_id'] = $input['user_id'];

        $grade_file = [];
        if (GradeFile::whereUserId($input['user_id'])->exists())
            $grade_file = GradeFile::whereUserId($input['user_id'])->first();


        if ($request->hasFile('education_file')) {
            $path = 'assets/uploads/grade/education/';
            if (count($grade_file))
                File::delete($path . $grade_file->education);
            $resualtUp = UploadImg::uploadFile($request->file('education_file'), $path);
            if ($resualtUp) $input_file['education'] = $resualtUp;
            else return Redirect::back()->with('error', 'فایل ارسالی صحیح نمی باشد.');
        }

        if ($request->hasFile('prizes_file')) {
            $path = 'assets/uploads/grade/prizes/';
            File::delete($path . $grade_file->prizes);
            $resualtUp = UploadImg::uploadFile($request->file('prizes_file'), $path);
            if ($resualtUp) $input_file['prizes'] = $resualtUp;
            else return Redirect::back()->with('error', 'فایل ارسالی صحیح نمی باشد.');
        }


        if (GradeFile::whereUserId($input['user_id'])->exists()) {
            GradeFile::whereUserId($input['user_id'])->update($input_file);
        } else {
            GradeFile::create($input_file);
        }

        return Redirect::back()
            ->with('success', 'اطلاعات شما با موفقیت در سیستم ثبت شد، پس از تایید مدیر سطح شما افزایش می یابد.');

    }

}
