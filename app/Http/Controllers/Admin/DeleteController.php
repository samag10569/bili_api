<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DeleteRequest;
use App\Models\News;
use App\User;
use App\Models\Help;
use App\Models\Scientific;
use App\Models\ScientificCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Classes\MakeTree;

class DeleteController extends Controller
{
    public function getIndex()
    {

        $help = Help::whereNotNull('delete_temp')->count();
        $scientific = Scientific::whereNotNull('delete_temp')->count();
        $scientific_category = ScientificCategory::whereNotNull('delete_temp')->count();
        $news = News::whereNotNull('delete_temp')->count();
        $user = User::whereNotNull('delete_temp')->count();


        return View('admin.delete.index')
            ->with('help', $help)->with('scientific', $scientific)
            ->with('scientific_category', $scientific_category)
            ->with('news', $news)->with('user', $user);
    }

    public function getViewUser(Request $request)
    {

        $query = User::query();
        $query->whereStatus(1);

        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('name')) {
                $query->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }
            if ($request->has('family')) {
                $query->where('family', 'LIKE', '%' . $request->get('family') . '%');
            }
        }
        $query->where('delete_temp', '!=', null);
        $data = $query->paginate(15);

        return View('admin.delete.user')
            ->with('data', $data);
    }

    public function getCancelUser($id)
    {
        $data = User::find($id);
        $data->delete_temp = null;
        $data->save();
        return Redirect::back()
            ->with('success', 'کاربر با موفقیت لغو شد.');
    }

    public function postUser(DeleteRequest $request)
    {
        $images = User::whereIn('id', $request->get('deleteId'))->select(['id', 'email', 'mobile', 'image'])->get();
        foreach ($images as $item) {
            File::delete('assets/uploads/user/big/' . $item->image);
            File::delete('assets/uploads/user/medium/' . $item->image);
            $email = 'archive_' . time() . '_' . $item->id . '_' . $item->email;
            $mobile = 'archive_' . time() . '_' . $item->id . '_' . $item->mobile;
            User::whereId($item->id)->update(['email' => $email, 'mobile' => $mobile]);
        }
        if (User::destroy($request->get('deleteId'))) {
            return Redirect::back()
                ->with('success', 'کاربران انتخاب شده با موفقیت حذف شدند.');
        }
    }

    public function getViewHelp(Request $request)
    {


        $query = Help::query();

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
        $query->whereNotNull('delete_temp');
        $data = $query->paginate(15);


        return View('admin.delete.help')->with('data', $data);

    }

    public function getCancelHelp($id)
    {

        $help = Help::find($id);
        $help->delete_temp = null;
        $help->save();
        return Redirect::back()->with('success', 'با موفقیت لغو شد .');
    }

    public function postHelp(DeleteRequest $request)
    {
        $images = Help::whereIn('id', $request->get('deleteId'))->pluck('image')->all();
        foreach ($images as $item) {
            File::delete('assets/uploads/help/big/' . $item);
            File::delete('assets/uploads/help/medium/' . $item);
        }

        if (Help::destroy($request->get('deleteId'))) {
            return Redirect::back()
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

    public function getViewScientificCategory(Request $request)
    {

        $query = ScientificCategory::query();
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
        $query->whereNotNull('delete_temp');
        $data = $query->paginate(15);
        return View('admin.delete.scientific_category')->with('data', $data);

    }

    public function getCancelScientificCategory($id)
    {

        $help = ScientificCategory::find($id);
        $help->delete_temp = null;
        $help->save();
        return Redirect::back()->with('success', 'با موفقیت لغو شد .');
    }

    public function postScientificCategory(DeleteRequest $request)
    {

        if (ScientificCategory::destroy($request->get('deleteId'))) {
            return Redirect::back()
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

    public function getViewScientific(Request $request)
    {

        $query = Scientific::query();
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
            if ($request->has('category_id')) {
                $query->where('category_id', $request->get('category_id'));
            }


        }
        $query->whereNotNull('delete_temp');
        $data = $query->paginate(15);
        $category = ScientificCategory::get()->toArray();
        if (!empty($category)) {
            MakeTree::getData($category);
            $category = MakeTree::GenerateSelect(array('parent_id' => 0, 'separator' => ' -- '));
        }
        $category = ['' => 'همه'] + (array)$category;
        return View('admin.delete.scientific')->with('data', $data)->with('category', $category);

    }

    public function getCancelScientific($id)
    {

        $help = Scientific::find($id);
        $help->delete_temp = null;
        $help->save();
        return Redirect::back()->with('success', 'با موفقیت لغو شد .');
    }

    public function postScientific(DeleteRequest $request)
    {
        $images = Scientific::whereIn('id', $request->get('deleteId'))->pluck('image')->all();
        foreach ($images as $item) {
            File::delete('assets/uploads/scientific/big/' . $item);
            File::delete('assets/uploads/scientific/medium/' . $item);
        }

        if (Scientific::destroy($request->get('deleteId'))) {
            return Redirect::back()
                ->with('success', 'مطالب علمی با موفقیت حذف شدند.');
        }
    }

    public function getViewNews(Request $request)
    {

        $query = News::query();
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
        $query->whereNotNull('delete_temp');
        $data = $query->paginate(15);
        return View('admin.delete.news')->with('data', $data);

    }

    public function getCancelNews($id)
    {

        $help = News::find($id);
        $help->delete_temp = null;
        $help->save();
        return Redirect::back()->with('success', 'با موفقیت لغو شد .');
    }

    public function postNews(DeleteRequest $request)
    {
        $images = News::whereIn('id', $request->get('deleteId'))->pluck('image')->all();
        foreach ($images as $item) {
            File::delete('assets/uploads/news/big/' . $item);
            File::delete('assets/uploads/news/medium/' . $item);
        }

        if (News::destroy($request->get('deleteId'))) {
            return Redirect::back()
                ->with('success', 'اخبار با موفقیت حذف شدند.');
        }
    }

}
