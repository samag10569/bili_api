<?php

namespace App\Http\Controllers\Site;

use App\Models\Scientific;
use App\Models\ScientificComments;
use App\Models\ScientificCategory;
use App\Models\ScientificLike;
use Classes\Multi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ScientificController extends Controller
{
    public function getIndex($id = null)
    {
        $query = Scientific::query();
        if ($id != null)
            $query->whereCategoryId($id);
        $scientific = $query->whereStatus(1)
            ->deleteTemp()
            ->with('user')
            ->latest()
            ->paginate(10);

        $parent = new Multi();
        $categories = [];
        foreach ($scientific as $item) {
            $category[$item->id] = $parent->parentAll($item->category_id);
            $category[$item->id] = array_reverse($category[$item->id]);
            $categories[$item->id] = ScientificCategory::whereIn('id', $category[$item->id])->deleteTemp()->get();
        }
        return view('site.scientific.index')
            ->with('categories', $categories)
            ->with('scientific', $scientific);
    }

    public function getDetails($id, $title = null)
    {
        $scientific = Scientific::with('comments')->whereStatus(1)
            ->deleteTemp()
            ->whereId($id)
            ->first();
        if ($scientific) {
            $scientific->hits++;
            $scientific->save();

            $parent = new Multi();
            $category = $parent->parentAll($scientific->category_id);
            $category = array_reverse($category);
            $categories = ScientificCategory::whereIn('id', $category)->deleteTemp()->get();

            $keywords = explode('|', $scientific->keywords);

            $relation = Scientific::whereStatus(1)
                ->deleteTemp()
                ->where('id', '<>', $id)
                ->whereCategoryId($scientific->category_id)
                ->latest()
                ->take(6)
                ->get();
            return view('site.scientific.details')
                ->with('relation', $relation)
                ->with('keywords', $keywords)
                ->with('scientific', $scientific)
                ->with('categories', $categories);
        } else {
            abort(404);
        }
    }

    public function getRate($scientific_id, Request $request)
    {
        if ($request->has('rate')) {
            $rate = $request->get('rate');
            $ip = $request->ip();
            $input = ['scientific_id' => $scientific_id, 'ip' => $ip];
            $data = ScientificLike::firstOrCreate($input);
            $data->rate = $rate;
            $data->save();
            return response(['info' => $data->id, 'success' => true], 200);
        } else {
            return response(['success' => false], 200);
        }
    }

    public function postComment($id, Request $request)
    {
        $scientific = Scientific::whereStatus(1)
            ->deleteTemp()
            ->whereId($id)
            ->first();
        if ($scientific) {
            $input = $request->all();
            $validator = Validator::make($input, [
                'comment' => 'required|min:2',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            if (Auth::Check()) {
                $data = [
                    'user_id' => Auth::User()->id,
                    'scientific_id' => $id,
                    'comment' => $request->get('comment'),
                    'ip' => $request->ip(),
                ];
                ScientificComments::create($data);
                return Redirect::back()
                    ->with('success', 'نظر با موفقیت ثبت شد.');
            } else {
                return Redirect::back()->withInput()->withErrors('لطفا وارد شوید.');
            }
        }
    }

}
