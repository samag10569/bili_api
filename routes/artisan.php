<?php

//echo 'artisan';exit;

use App\Models\Allotment;
use App\Models\AllotmentUser;
use App\Models\ContactsList;
use App\Models\Degree;
use Illuminate\Support\Facades\Artisan;
use App\Models\UserInfo;
use App\User;

Route::group(array('prefix' => 'artisan', 'middleware' => 'ArtisanPermission'), function () {


//-------------------------------------Route Fix-------------------------------------------

    Route::get('user_info_up', function () {
        $checker = new \Classes\UserCheck();
        $user = User::where('id', '>', 12247)->whereMember(1)->get();
        foreach ($user as $item) {
            $info = UserInfo::whereUserId($item->id)->first();
            if (!$info) {
                $input['postal_code'] = 1111111111;
                $input['user_id'] = $item->id;
                UserInfo::create($input);
                echo $item->id . '</br>';
                User::where('id', $input['user_id'])->update(['user_code' => $checker->user_code($input['user_id'])]);

            }
        }
        dd();
    });


    Route::get('user_membership', function () {
        $user = UserInfo::where('membership_type_id', 2)->get();
        foreach ($user as $item) {
            $info = UserInfo::whereUserId($item->user_id)->update(['membership_type_id' => 1]);
            echo $item->id . '</br>';
        }
        dd();
    });

    Route::get('job_status', function () {
        $user = UserInfo::whereNull('job_status')->get();
        foreach ($user as $item) {
            $info = UserInfo::whereUserId($item->user_id)->update(['job_status' => 0]);
            echo $item->id . '</br>';
        }
        dd();
    });

    Route::get('score_up/{min}/{max}', function ($min, $max) {

        UserInfo::where('id', '>', $min)->where('id', '<', $max)->chunk(200, function ($data) {
            foreach ($data as $item) {

                $allotment_score = 0;

                if (AllotmentUser::whereUserId($item->user_id)->whereStatus(2)->exists()) {
                    $allotmentList = AllotmentUser::whereUserId($item->user_id)->whereStatus(2)->get();
                    foreach ($allotmentList as $row) {
						$xx = Allotment::find($row->allotment_id);
						if($xx){
							$allotment_score += $xx->score;
						}
                    }
                    $allotment = Degree::where('min', '<=', $allotment_score)
                        ->where('max', '>', $allotment_score)
                        ->firstorfail()->title;

                    UserInfo::whereId($item->id)->update([
                        'allotment_score' => $allotment_score,
                        'allotment' => $allotment
                    ]);
                }

                $score = $allotment_score + $item->grade_score;
                $score_id = Degree::where('min', '<=', $score)
                    ->where('max', '>', $score)
                    ->firstorfail()->title;

                UserInfo::whereId($item->id)->update([
                    'score' => $score,
                    'score_id' => $score_id
                ]);

                echo 'id = ' . $item->id . ' | score = ' . $score . ' | score_id = ' . $score_id . '</br>';
            }
        });
        dd();
    });


//-------------------------------------Artisan----------------------------------------------

    Route::get('/migrate', function () {
        Artisan::call('migrate');
        return 'Migrate Done!';
    });

    Route::get('/migrate:rollback', function () {
        Artisan::call('migrate:rollback');
        return 'migrate Rollback Done!';
    });

    Route::get('/db:seed', function () {
        Artisan::call('db:seed');
        return 'db seed Done!';
    });

    Route::get('/view:clear', function () {
        Artisan::call('view:clear');
        return 'View Clear Done!';
    });

    Route::get('/debugbar:clear', function () {
        Artisan::call('debugbar:clear');
        return 'Debugbar Clear Done!';
    });

    Route::get('/cache:clear', function () {
        Artisan::call('cache:clear');
        return 'Cache Clear Done!';
    });

    Route::get('/config:clear', function () {
        Artisan::call('config:clear');
        return 'Config Clear Done!';
    });

    Route::get('/down', function () {
        Artisan::call('down');
        return 'Down Done!';
    });

    Route::get('/up', function () {
        Artisan::call('up');
        return 'Up Done!';
    });

    Route::get('/check:telegram', function () {
        Artisan::call('check:telegram');
        return 'Telegram Check!';
    });

});

