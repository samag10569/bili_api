<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MemberShipTypeRequest;
use App\Models\MembershipType;
use Classes\UploadImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class MembershipTypeController extends Controller
{
    public function getIndex()
    {
        $data = MembershipType::paginate(15);
        return View('admin.membership-type.index')
            ->with('data', $data);
    }

    public function getEdit($id)
    {
        $data = MembershipType::find($id);

        return View('admin.membership-type.edit')
            ->with('data', $data);

    }


    public function postEdit($id, MemberShipTypeRequest $request)
    {
        $input = Input::except(['_token']);
        $membershipType = MembershipType::find($id);
        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/membership-type/');
            $pathBig = 'assets/uploads/membership-type/big/';
            $pathMedium = 'assets/uploads/membership-type/medium/';
            File::delete($pathBig . $membershipType->image);
            File::delete($pathMedium . $membershipType->image);
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        $membershipType->where('id', $id)->update($input);
        return Redirect::action('Admin\MembershipTypeController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }
}
