<?php

use App\Models\Allotment;
use App\Models\AllotmentCategory;
use App\Models\Banner;
use App\Models\Help;
use App\Models\News;
use App\Models\Scientific;
use App\Models\ScientificCategory;
use App\Models\Setting;
use App\Models\Logo;
use App\Models\FooterTab;
use App\Models\Tab;
use App\Models\UserInfo;
use App\User;
use Classes\DateUtils;
use Classes\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

$setting = [];
if (Schema::hasTable('setting'))
    $setting = Setting::first();

View::composer('layouts.out.blocks.sidebar', function ($view) {
    $allotment_category_m = AllotmentCategory::whereStatus(1)
        ->orderby('listorder', 'ASC')
        ->with('allotment')
        ->get();
    $view->with('allotment_category_m', $allotment_category_m);
});

View::composer('layouts.crm.blocks.sidebar', function ($view) {
    $userInfo = UserInfo::whereUserId(Auth::id())->first();
    $userDetails = User::with('category', 'branchInfo')->find(Auth::id());

    $name = Helper::seo(Auth::user()->name) . '-' . Helper::seo(Auth::user()->family);

    $view->with('userInfo', $userInfo)
        ->with('name', $name)
        ->with('userDetails', $userDetails);
});

View::composer('layouts.site.blocks.footer', function ($view) {
    $logos = Logo::where('status', 1)->get();
    $ftab = FooterTab::where('status', 1)->with('footerUnderMenu')->orderby('listorder', 'ASC')->get();
    $view->with('logos', $logos)->with('ftab', $ftab);
});

View::composer('layouts.site.blocks.header', function ($view) {
    $tab = Tab::where('status', 1)->with('underMenu')->orderby('listorder', 'ASC')->get();
    if (Auth::check())
        $name = Helper::seo(Auth::user()->name) . '-' . Helper::seo(Auth::user()->family);
    else
        $name = '';
    $view->with('tab', $tab)
        ->with('name', $name);
});

View::composer('layouts.site.blocks.news', function ($view) {
    $lastNews = News::whereStatus(1)
        ->deleteTemp()
        ->latest()->take(1)->first();
    $view->with('lastNews', $lastNews);
});

View::composer('layouts.crm.blocks.scientific', function ($view) {
    $scientific = Scientific::whereStatus(1)->deleteTemp()->latest()->take(5)->get();
    $view->with('scientific', $scientific);
});

View::composer('layouts.site.blocks.sidebar', function ($view) {
    $category = ScientificCategory::whereStatus(1)
        ->deleteTemp()
        ->whereParentId(0)
        ->orderby('listorder', 'ASC')
        ->get();
    $scientific = Scientific::whereStatus(1)
        ->deleteTemp()
        ->latest()->take(4)->get();

    $date = new DateUtils();
    $current_day = $date->current_date();
    $collection = Scientific::whereStatus(1)->deleteTemp();
    $count['all'] = $collection->count();
    $count['current_day'] = $collection->whereBetween('created_at', [$current_day['start_date'], $current_day['end_date']])
        ->count();
    $view->with('category', $category)
        ->with('count', $count)
        ->with('scientific', $scientific);
});


View::composer('layouts.site.blocks.sidebar-allotment', function ($view) {
    $category = AllotmentCategory::whereStatus(1)
    	->whereParentId(0)
        ->orderby('listorder', 'ASC')
        ->get();

    $count['all_category'] = AllotmentCategory::whereStatus(1)->count();
    $allotment = Allotment::whereStatus(1)
        ->latest()->take(4)->get();

    $date = new DateUtils();
    $current_day = $date->current_date();
    $collection = Allotment::whereStatus(1);
    $count['all'] = $collection->count();
    $count['current_day'] = $collection->whereBetween('created_at', [$current_day['start_date'], $current_day['end_date']])
        ->count();
    $view->with('category', $category)
        ->with('count', $count)
        ->with('allotment', $allotment);
});

View::composer('layouts.crm.blocks.slider_inner', function ($view) {
    $segment = Request::segments();
    $count = count($segment);
    $section = '*';
    if ($count == 1) {
        $section = $segment[0];
    } elseif ($count >= 2) {
        $section = $segment[1];
    }
    $banner_inner = Banner::whereStatus(1)
        ->where(function ($query) use ($section) {
            $query->where('section', '*')
                ->orWhere('section', $section);
        })
        ->orderBy('id', 'ASC')
        ->get();
    $view->with('banner_inner', $banner_inner);
});


View::composer('layouts.site.blocks.help', function ($view) {
    $segment = Request::segments();
    $count = count($segment);
    $section = '*';
    if ($count == 1) {
        $section = $segment[0];
    } elseif ($count >= 2) {
        $section = $segment[1];
    }
    $help = Help::whereStatus(1)
        ->deleteTemp()
        ->where(function ($query) use ($section) {
            $query->where('section', '*')
                ->orWhere('section', $section);
        })
        ->orderBy('id', 'ASC')
        ->get();
    $view->with('help', $help);
});

//View::composer('*', function ($view) {
//    $view->with('viewName', $view->getName());
//});

View::share([
    'setting' => $setting,
]);
