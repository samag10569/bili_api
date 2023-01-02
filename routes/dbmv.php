<?php
//echo 'dbmw';exit;

use App\Models\Allotment;
use App\Models\AllotmentMessage;
use App\Models\AllotmentOption;
use App\Models\AllotmentUser;
use App\Models\Banner;
use App\Models\Branch;
use App\Models\Capacity;
use App\Models\Category;
use App\Models\Credibility;
use App\Models\Degree;
use App\Models\FactualyList;
use App\Models\Grade;
use App\Models\Help;
use App\Models\Interduction;
use App\Models\Logo;
use App\Models\Message;
use App\Models\MessageCore;
use App\Models\MessageCoreReply;
use App\Models\MessageReply;
use App\Models\News;
use App\Models\Pages;
use App\Models\ProjectRequired;
use App\Models\Scientific;
use App\Models\Services;
use App\Models\State;
use App\Models\Tab;
use App\Models\UnderMenu;
use App\Models\UserContent;
use App\Models\UserInfo;
use App\User;
use Classes\Helper;
use Illuminate\Support\Facades\DB;


//TODO: Admin -> User
Route::get('move-admin-user', function () {
    $connect2 = DB::connection('mysql2');
    $connect2->table('admin')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [];
            $helper = new Helper();

            $input['password'] = bcrypt($helper->deCrypte($item->password));

            $array_date_old = explode('/', $item->date);
            $array_date_new = [];
            foreach ($array_date_old as $row) {
                $array_date_new[] = $helper->persian2LatinDigit($row);
            }
            $input['created_at'] = jmktime(0, 0, 0, $array_date_new[1], $array_date_new[2], $array_date_new[0]);

            if ($item->delete_admin == 2) {
                $input['deleted_at'] = time();
            }
            $input['id'] = $item->id;
            $input['name'] = $item->name;
            $input['family'] = $item->family;
            if (User::where('email', $item->email)->where('id', '<>', $item->id)->exists()) {
                $input['email'] = 'admin' . $item->id . '@ejavan.net';
            } else {
                $input['email'] = $item->email;
            }
            $input['image'] = $item->image;
            $input['admin'] = 1;

            if (User::where('id', $item->id)->exists()) {
                User::where('id', $item->id)->update($input);
                echo 'Update Admin: ' . $item->id . '</br>';
            } else {
                User::create($input);
                echo 'Create Admin: ' . $item->id . '</br>';
            }
        }
    });

    return 'end';

});

//TODO: Member -> User , userInfo
Route::get('move-member-user/{min}/{max}', function ($min, $max) {
    ini_set('max_execution_time', 1000);
    $connect2 = DB::connection('mysql2');
    $connect2->table('member')->where('id', '>', $min)->where('id', '<', $max)->chunk(200, function ($data) {
        foreach ($data as $item) {

            //_________________Users____________________

            $input = [];
            $helper = new Helper();

            $array_date_old = explode('/', $item->date);
            $array_date_new = [];
            foreach ($array_date_old as $row) {
                $array_date_new[] = $helper->persian2LatinDigit($row);
            }

            $input['created_at'] = jmktime(0, 0, 0, $array_date_new[1], $array_date_new[0], $array_date_new[2]);


            $interview_date_old = explode('/', $item->date_m);
            $interview_date_new = [];
            foreach ($interview_date_old as $row) {
                $interview_date_new[] = $helper->persian2LatinDigit($row);
            }

            $interview_time_new = [];
            if ($item->time_m == null) {
                $interview_time_new = [0, 0];
            } else {
                $interview_time_old = explode(':', $item->time_m);
                foreach ($interview_time_old as $row) {
                    if (is_numeric($row)) {
                        $interview_time_new[] = $helper->persian2LatinDigit($row);
                    } else {
                        $interview_time_new = [0, 0];
                    }
                }
                if (count($interview_time_new) != 2) {
                    $interview_time_new[] = 0;
                }
            }
            $input['date_interview'] = jmktime($interview_time_new[0], $interview_time_new[1], 0, $interview_date_new[1], $interview_date_new[0], $interview_date_new[2]);

            if ($item->delete_m == 1) {
                $input['delete_temp'] = time();
            }

            $input['id'] = $item->id;
            $input['name'] = $item->name;
            $input['family'] = $item->family;
            if (User::where('email', $item->email)->where('id', '<>', $item->id)->exists()) {
                $input['email'] = $item->email . 'ejavan' . $item->id;
            } else {
                $input['email'] = $item->email;
            }
            if (User::where('mobile', $item->tel)->where('id', '<>', $item->id)->exists()) {
                $input['mobile'] = $item->tel . 'ejavan' . $item->id;
            } else {
                $input['mobile'] = $item->tel;
            }
            $input['image'] = $item->image;
            $input['user_code'] = $item->unique_code;
            if ($item->member_status_id == 8) {
                $input['status_id'] = 5;
            } else {
                $input['status_id'] = $item->member_status_id;
            }
            $input['rejection'] = $item->rejection;
            $input['reason_rejection'] = $item->reason_rejection;
            if ($item->branch_id != '-1') {
                $input['branch_id'] = $item->branch_id;
            }
            if ($item->category_id != '-1') {
                $input['category_id'] = $item->category_id;
            }
            $input['cv'] = $item->content;
            $input['admin_id'] = $item->admin_id;
            $input['register_id'] = $item->register_id;
            $input['phone_call'] = $item->phone_call;
            $input['phone_wing'] = $item->phone_call_wing;
            $input['time_interview'] = $item->time_m;
            $input['member'] = 1;

            if ($item->set_password == 1 and $item->password != null) {
                $input['password'] = bcrypt($helper->deCrypte($item->password));
            } else {
                $input['password'] = bcrypt($input['email']);
            }

            if (User::where('id', $item->id)->exists()) {
                User::where('id', $item->id)->update($input);
                echo 'Update Member: ' . $item->id . '</br>';
            } else {
                User::create($input);
                echo 'Create Member: ' . $item->id . '</br>';
            }

            //_________________UserInfo____________________

            $input_info = [];
            $input_info['user_id'] = $item->id;
            if ($item->article != '2') {
                $input_info['article'] = $item->article;
            }
            if ($item->invention != '2') {
                $input_info['invention'] = $item->invention;
            }
            if ($item->ideas != '2') {
                $input_info['ideas'] = $item->ideas;
            }
            if ($item->expertise != '2') {
                $input_info['expertise'] = $item->expertise;
            }
            $input_info['article_title'] = $item->article_title;
            $input_info['invention_title'] = $item->invention_title;
            $input_info['ideas_title'] = $item->ideas_title;
            $input_info['expertise_title'] = $item->expertise_title;
            $input_info['interview_type_id'] = $item->type_d;
            $input_info['agent_send'] = $item->agent_send;
            if ($item->membership_id == 2) {
                $input_info['membership_id'] = 1;
            } elseif ($item->membership_id == 3) {
                $input_info['membership_id'] = 2;
            }

            $input_info['state_id'] = $item->state_id;
            if ($item->membership_type_id != '-1') {
                $input_info['membership_type_id'] = $item->membership_type_id;
            }
            if ($item->credibility_id != '-1') {
                $input_info['credibility_id'] = $item->credibility_id;
            }
            if ($item->degree_id != '-1') {
                $input_info['degree_id'] = $item->degree_id;
            }
            $input_info['city'] = $item->city;
            $input_info['branch'] = $item->branch;
            $input_info['postal_code'] = $item->postal_code;
            $input_info['father_name'] = $item->father_name;
            $input_info['national_id'] = $item->national_id;
            $input_info['employment_status'] = $item->employment_status;
            $input_info['number_ledger'] = $item->number_ledger;
            $input_info['grade_score'] = $item->grade_score;
            $input_info['grade'] = $item->grade;

            if ($item->birth != null) {
                $array_birth_old = explode('/', $item->birth);
                if (count($array_birth_old) > 1) {
                    $array_birth_new = [];
                    foreach ($array_birth_old as $row) {
                        $array_birth_new[] = $helper->persian2LatinDigit($row);
                    }
                    if (isset($array_birth_new[2])) {
                        $input['birth'] = jmktime(0, 0, 0, $array_birth_new[1], $array_birth_new[0], $array_birth_new[2]);
                    }
                }
            }

            if (UserInfo::where('user_id', $item->id)->exists()) {
                UserInfo::where('user_id', $item->id)->update($input_info);
                echo 'Update UserInfo: ' . $item->id . '</br>';
            } else {
                UserInfo::create($input_info);
                echo 'Create UserInfo: ' . $item->id . '</br>';
            }
            //_________________ProjectRequired____________________

            if ($item->project_required != null and $item->project_required != '') {
                $input_project = [];
                $input_project['user_id'] = $item->id;
                $input_project['title'] = $item->project_required;
                $input_project['file'] = $item->file_core_education;
                $input_project['abstract'] = $item->core_education;
                $input_project['content'] = $item->content_required;
                $input_project['source'] = $item->source_required;
                $input_project['status_id'] = 2;
                if ($item->required_change != '2') {
                    $input_project['change'] = $item->required_change;
                }

                if (ProjectRequired::where('user_id', $item->id)->where('title', $item->project_required)->exists()) {
                    ProjectRequired::where('user_id', $item->id)
                        ->where('title', $item->project_required)
                        ->update($input_project);
                    echo 'Update ProjectRequired: ' . $item->id . '</br>';
                } else {
                    ProjectRequired::create($input_project);
                    echo 'Create ProjectRequired: ' . $item->id . '</br>';
                }

            }

            if ($item->project_required2 != null and $item->project_required2 != '') {
                $input_project = [];
                $input_project['user_id'] = $item->id;
                $input_project['title'] = $item->project_required2;
                $input_project['file'] = $item->file_core_education2;
                $input_project['abstract'] = $item->core_education2;
                $input_project['content'] = $item->content_required2;
                $input_project['source'] = $item->source_required2;
                $input_project['status_id'] = 2;
                if ($item->required_change2 != '2') {
                    $input_project['change'] = $item->required_change2;
                }

                if (ProjectRequired::where('user_id', $item->id)->where('title', $item->project_required2)->exists()) {
                    ProjectRequired::where('user_id', $item->id)
                        ->where('title', $item->project_required2)
                        ->update($input_project);
                    echo 'Update ProjectRequired 2: ' . $item->id . '</br>';
                } else {
                    ProjectRequired::create($input_project);
                    echo 'Create ProjectRequired 2: ' . $item->id . '</br>';
                }

            }


            if ($item->project_required3 != null and $item->project_required3 != '') {
                $input_project = [];
                $input_project['user_id'] = $item->id;
                $input_project['title'] = $item->project_required3;
                $input_project['file'] = $item->file_core_education3;
                $input_project['abstract'] = $item->core_education3;
                $input_project['content'] = $item->content_required3;
                $input_project['source'] = $item->source_required3;
                $input_project['status_id'] = 2;
                if ($item->required_change3 != '2') {
                    $input_project['change'] = $item->required_change3;
                }

                if (ProjectRequired::where('user_id', $item->id)->where('title', $item->project_required3)->exists()) {
                    ProjectRequired::where('user_id', $item->id)
                        ->where('title', $item->project_required3)
                        ->update($input_project);
                    echo 'Update ProjectRequired 3: ' . $item->id . '</br>';
                } else {
                    ProjectRequired::create($input_project);
                    echo 'Create ProjectRequired 3: ' . $item->id . '</br>';
                }

            }


            if ($item->project_required4 != null and $item->project_required4 != '') {
                $input_project = [];
                $input_project['user_id'] = $item->id;
                $input_project['title'] = $item->project_required4;
                $input_project['file'] = $item->file_core_education4;
                $input_project['abstract'] = $item->core_education4;
                $input_project['content'] = $item->content_required4;
                $input_project['source'] = $item->source_required4;
                $input_project['status_id'] = 2;
                if ($item->required_change4 != '2') {
                    $input_project['change'] = $item->required_change4;
                }

                if (ProjectRequired::where('user_id', $item->id)->where('title', $item->project_required4)->exists()) {
                    ProjectRequired::where('user_id', $item->id)
                        ->where('title', $item->project_required4)
                        ->update($input_project);
                    echo 'Update ProjectRequired 4: ' . $item->id . '</br>';
                } else {
                    ProjectRequired::create($input_project);
                    echo 'Create ProjectRequired 4: ' . $item->id . '</br>';
                }

            }
        }
    });

    return 'end';
});

//TODO: Factualy -> User
Route::get('move-factualy-user', function () {
    $connect2 = DB::connection('mysql2');
    $idCount = 39;
    $connect2->table('faculty')->chunk(200, function ($data) use ($idCount) {
        foreach ($data as $item) {
            if ($item->member_id != null) {
                $user = User::find($item->member_id);
                if ($user) {
                    $input = [
                        'station' => $item->station,
                        'core_scientific' => 1,
                    ];
                    $user->update($input);
                    echo 'Update Member core_scientific: ' . $item->member_id . '</br>';
                }
            } else {
                $array = explode(' ', $item->name);
                $input = [
                    'id' => $idCount,
                    'name' => $array[0],
                    'family' => $array[1],
                    'cv' => $item->cv,
                    'image' => $item->image,
                    'station' => $item->station,
                    'core_scientific' => 1,
                    'password' => bcrypt($item->email)
                ];

                if (User::where('email', $item->email)->where('id', '<>', $idCount)->exists()) {
                    $input['email'] = $item->email . 'ejavan' . $idCount;
                } else {
                    $input['email'] = $item->email;
                }
                if (User::where('mobile', $item->mobile)->where('id', '<>', $idCount)->exists()) {
                    $input['mobile'] = $item->mobile . 'ejavan' . $idCount;
                } else {
                    $input['mobile'] = $item->mobile;
                }

                if (User::where('id', $idCount)->exists()) {
                    User::where('id', $idCount)->update($input);
                    echo 'Update User core_scientific: ' . $idCount . '</br>';
                } else {
                    User::create($input);
                    echo 'Create User core_scientific: ' . $idCount . '</br>';
                }
                $idCount++;
            }
        }

    });

});

//TODO: AllotmentList -> Allotment, Banner, News, ...
Route::get('move-allotment-list-other', function () {
    $connect3 = DB::connection('mysql3');
    $connect2 = DB::connection('mysql2');

    $connect3->table('allotment_list')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'title' => $item->title,
                'content' => $item->content,
                'value' => $item->value,
                'perm' => $item->perm,
                'status' => $item->status
            ];
            if (Allotment::where('id', $item->id)->exists()) {
                Allotment::where('id', $item->id)->update($input);
                echo 'Update Allotment: ' . $item->id . '</br>';
            } else {
                Allotment::create($input);
                echo 'Create Allotment: ' . $item->id . '</br>';
            }
        }
    });


    $connect2->table('banner')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'content' => $item->content,
                'image' => $item->image,
                'link' => $item->link,
                'status' => $item->status
            ];
            if (Banner::where('id', $item->id)->exists()) {
                Banner::where('id', $item->id)->update($input);
                echo 'Update Banner: ' . $item->id . '</br>';
            } else {
                Banner::create($input);
                echo 'Create Banner: ' . $item->id . '</br>';
            }
        }
    });

    $connect2->table('logo')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'image' => $item->image,
                'link' => $item->link,
                'status' => $item->status
            ];
            if (Logo::where('id', $item->id)->exists()) {
                Logo::where('id', $item->id)->update($input);
                echo 'Update Logo: ' . $item->id . '</br>';
            } else {
                Logo::create($input);
                echo 'Create Logo: ' . $item->id . '</br>';
            }
        }
    });

    $connect2->table('news')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'content' => $item->content,
                'image' => $item->image,
                'content_short' => $item->content_short,
                'status' => $item->status
            ];
            if (News::where('id', $item->id)->exists()) {
                News::where('id', $item->id)->update($input);
                echo 'Update News: ' . $item->id . '</br>';
            } else {
                News::create($input);
                echo 'Create News: ' . $item->id . '</br>';
            }
        }
    });


    $connect2->table('help')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'content' => $item->content,
                'image' => $item->image,
                'content_short' => $item->content_short,
                'status' => $item->status
            ];
            if (Help::where('id', $item->id)->exists()) {
                Help::where('id', $item->id)->update($input);
                echo 'Update Help: ' . $item->id . '</br>';
            } else {
                Help::create($input);
                echo 'Create Help: ' . $item->id . '</br>';
            }
        }
    });

    $connect2->table('services')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'content' => $item->content,
                'image' => $item->image,
                'content_short' => $item->content_short,
                'status' => $item->status
            ];
            if (Services::where('id', $item->id)->exists()) {
                Services::where('id', $item->id)->update($input);
                echo 'Update Services: ' . $item->id . '</br>';
            } else {
                Services::create($input);
                echo 'Create Services: ' . $item->id . '</br>';
            }
        }
    });

    $connect2->table('scientific')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'content' => $item->content,
                'image' => $item->image,
                'content_short' => $item->content_short,
                'isadmin' => 1,
                'status' => $item->status
            ];
            if (Scientific::where('id', $item->id)->exists()) {
                Scientific::where('id', $item->id)->update($input);
                echo 'Update Scientific: ' . $item->id . '</br>';
            } else {
                Scientific::create($input);
                echo 'Create Scientific: ' . $item->id . '</br>';
            }
        }
    });

    $connect2->table('ista')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'content' => $item->content,
                'image' => $item->image,
                'link' => $item->link,
                'status' => $item->status
            ];
            if (Pages::where('id', $item->id)->exists()) {
                Pages::where('id', $item->id)->update($input);
                echo 'Update Pages: ' . $item->id . '</br>';
            } else {
                Pages::create($input);
                echo 'Create Pages: ' . $item->id . '</br>';
            }
        }
    });

    $connect2->table('tab')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'link' => $item->link,
                'status' => $item->status
            ];
            if (Tab::where('id', $item->id)->exists()) {
                Tab::where('id', $item->id)->update($input);
                echo 'Update Tab: ' . $item->id . '</br>';
            } else {
                Tab::create($input);
                echo 'Create Tab: ' . $item->id . '</br>';
            }
        }
    });
    $connect2->table('under_menu')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'link' => $item->link,
                'tab_id' => $item->tab_id,
                'status' => $item->status
            ];
            if (UnderMenu::where('id', $item->id)->exists()) {
                UnderMenu::where('id', $item->id)->update($input);
                echo 'Update UnderMenu: ' . $item->id . '</br>';
            } else {
                UnderMenu::create($input);
                echo 'Create UnderMenu: ' . $item->id . '</br>';
            }
        }
    });

});

//TODO: Allotment User
Route::get('move-allotment-user/{min}/{max}', function ($min, $max) {
    ini_set('max_execution_time', 1000);
    $connect2 = DB::connection('mysql2');

    $connect2->table('allotment')->where('id', '>', $min)->where('id', '<', $max)->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [];
            $item = json_decode(json_encode($item), true);
            $input ['user_id'] = $item['member_id'];

            $member = User::select(['id', 'date_interview'])->find($item['member_id']);
            if ($member) {
                $input['date_confirm'] = $member->date_interview;
                if ($item['faculty_title_id'] != 0 and $item['faculty_id'] != 0)
                    $member->update(['supervisor' => $item['faculty_id'], 'factualy_id' => $item['faculty_title_id']]);
            }

            $allotments = Allotment::all();
            foreach ($allotments as $allotment) {
                $connect3 = DB::connection('mysql2');
                $input['allotment_id'] = $allotment->id;
                if ($item[$allotment->value] != 0) {
                    $input['status'] = $item[$allotment->value];
                    $allotment_content = $connect3->table('allotment_content')
                        ->where('member_id', $item['member_id'])
                        ->where('type', 0)
                        ->where('allotment', $allotment->value)
                        ->first();
                    if ($allotment_content) {
                        $input['amount'] = $allotment_content->amount;
                        $input['admin_id'] = $allotment_content->admin_id;
                        $input['inspector_amount'] = $allotment_content->inspector_amount;
                    }

                    if (AllotmentUser::where('user_id', $item['member_id'])->where('allotment_id', $allotment->id)->exists()) {
                        AllotmentUser::where('user_id', $item['member_id'])->where('allotment_id', $allotment->id)->update($input);
                        echo 'Update AllotmentUser: ' . $item['member_id'] . '</br>';
                    } else {
                        AllotmentUser::create($input);
                        echo 'Create AllotmentUser: ' . $item['member_id'] . '</br>';
                    }
                }
            }
        }
    });
});

//TODO: Factualy
Route::get('move-faculty', function () {
    $connect2 = DB::connection('mysql2');

    $connect2->table('faculty_title')->chunk(200, function ($data) {
        $helper = new Helper();
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'type' => $item->type,
                'version' => $item->version,
            ];

            if (FactualyList::where('id', $item->id)->exists()) {
                FactualyList::where('id', $item->id)->update($input);
                echo 'Update FactualyList: ' . $item->id . '</br>';
            } else {
                FactualyList::create($input);
                echo 'Create FactualyList: ' . $item->id . '</br>';
            }
        }
    });

    return 'end';
});

//TODO: AllotmentOption18
Route::get('move-allotment-option18/{min}/{max}', function ($min, $max) {
    ini_set('max_execution_time', 1000);

    $connect2 = DB::connection('mysql2');

    $connect2->table('allotment_title')->where('id', '>', $min)->where('id', '<', $max)->orderby('id', 'ASC')->chunk(200, function ($data) {
        $helper = new Helper();
        foreach ($data as $item) {
            $input = [
                'user_id' => $item->member_id,
                'allotment_id' => 18,
                'admin_id' => $item->admin_id,
                'content' => $item->content,
            ];


            $d_t_old = explode(' ', $item->date);

            $array_time_old = explode(':', $d_t_old[1]);
            $array_time_new = [];
            foreach ($array_time_old as $row) {
                $array_time_new[] = $helper->persian2LatinDigit($row);
            }

            $array_date_old = explode('/', $d_t_old[0]);
            $array_date_new = [];
            foreach ($array_date_old as $row) {
                $array_date_new[] = $helper->persian2LatinDigit($row);
            }

            $input['created_at'] = jmktime($array_time_new[0], $array_time_new[1], $array_time_new[2], $array_date_new[1], $array_date_new[0], $array_date_new[2]);

            AllotmentOption::create($input);
            echo 'Create AllotmentOption: ' . $item->id . '</br>';

        }
    });

    return 'end';
});

//TODO: AllotmentOption45
Route::get('move-allotment-option45/{min}/{max}', function ($min, $max) {
    ini_set('max_execution_time', 1000);

    $connect2 = DB::connection('mysql2');

    $connect2->table('industry_title')->where('id', '>', $min)->where('id', '<', $max)->orderby('id', 'ASC')->chunk(200, function ($data) {
        $helper = new Helper();
        foreach ($data as $item) {
            $input = [
                'user_id' => $item->member_id,
                'allotment_id' => 45,
                'admin_id' => $item->admin_id,
                'content' => $item->content,
            ];

            $d_t_old = explode(' ', $item->date);

            $array_time_old = explode(':', $d_t_old[1]);
            $array_time_new = [];
            foreach ($array_time_old as $row) {
                $array_time_new[] = $helper->persian2LatinDigit($row);
            }

            $array_date_old = explode('/', $d_t_old[0]);
            $array_date_new = [];
            foreach ($array_date_old as $row) {
                $array_date_new[] = $helper->persian2LatinDigit($row);
            }

            $input['created_at'] = jmktime($array_time_new[0], $array_time_new[1], $array_time_new[2], $array_date_new[1], $array_date_new[0], $array_date_new[2]);

            AllotmentOption::create($input);
            echo 'Create AllotmentOption: ' . $item->id . '</br>';

        }
    });

    return 'end';
});

//TODO: AllotmentMessage
Route::get('move-allotment-content', function () {
    $connect2 = DB::connection('mysql2');

    $connect2->table('allotment_content')->where('type', 1)->chunk(200, function ($data) {
        $helper = new Helper();
        foreach ($data as $item) {

            $input = [
                'status' => $item->status,
                'admin_id' => $item->admin_id,
                'user_id' => $item->member_id,
                'content' => $item->content
            ];

            if ($item->allotment != null) {
                $allotment = Allotment::where('value', $item->allotment)->first();
                if ($allotment) {
                    $input['allotment_id'] = $allotment->id;
                }
            }


            $d_t_old = explode(' ', $item->date);

            $array_time_old = explode(':', $d_t_old[1]);
            $array_time_new = [];
            foreach ($array_time_old as $row) {
                $array_time_new[] = $helper->persian2LatinDigit($row);
            }

            $array_date_old = explode('/', $d_t_old[0]);
            $array_date_new = [];
            foreach ($array_date_old as $row) {
                $array_date_new[] = $helper->persian2LatinDigit($row);
            }

            $input['created_at'] = jmktime($array_time_new[0], $array_time_new[1], $array_time_new[2], $array_date_new[1], $array_date_new[0], $array_date_new[2]);

            AllotmentMessage::create($input);
            echo 'Create UserContent: ' . $item->id . '</br>';

        }
    });

    return 'end';
});

//TODO: Capacity, Interduction
Route::get('move-ci', function () {
    ini_set('max_execution_time', 1000);
    $connect2 = DB::connection('mysql2');

    $connect2->table('register')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'capacity' => $item->capacity
            ];

            $helper = new Helper();

            $array_date_old = explode('/', $item->date);
            $array_date_new = [];
            foreach ($array_date_old as $row) {
                $array_date_new[] = $helper->persian2LatinDigit($row);
            }
            $input['date'] = jmktime(0, 0, 0, $array_date_new[1], $array_date_new[0], $array_date_new[2]);

            if (Capacity::where('id', $item->id)->exists()) {
                Capacity::where('id', $item->id)->update($input);
                echo 'Update Capacity: ' . $item->id . '</br>';
            } else {
                Capacity::create($input);
                echo 'Create Capacity: ' . $item->id . '</br>';
            }
        }
    });


    $connect2->table('introduction')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'letter_id' => $item->letter_id,
                'company_name' => $item->name_company,
                'address' => $item->address_lookup,
                'type_id' => $item->type_id
            ];

            $member = User::where('name', $item->name)->where('family', $item->family)->first();
            if ($member)
                $input['user_id'] = $member->id;

            $helper = new Helper();

            $array_date_old = explode('/', $item->date);
            $array_date_new = [];
            foreach ($array_date_old as $row) {
                $array_date_new[] = $helper->persian2LatinDigit($row);
            }
            $input['created_at'] = jmktime(0, 0, 0, $array_date_new[1], $array_date_new[0], $array_date_new[2]);

            if (Interduction::where('id', $item->id)->exists()) {
                Interduction::where('id', $item->id)->update($input);
                echo 'Update Interduction: ' . $item->id . '</br>';
            } else {
                Interduction::create($input);
                echo 'Create Interduction: ' . $item->id . '</br>';
            }
        }
    });

});

//TODO: Branch, Category , ...
Route::get('move-bccds', function () {
    $connect2 = DB::connection('mysql2');

    $connect2->table('branch')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'listorder' => $item->order1,
                'status' => $item->status
            ];
            if (Branch::where('id', $item->id)->exists()) {
                Branch::where('id', $item->id)->update($input);
                echo 'Update Branch: ' . $item->id . '</br>';
            } else {
                Branch::create($input);
                echo 'Create Branch: ' . $item->id . '</br>';
            }
        }
    });


    $connect2->table('category')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'listorder' => $item->order1,
                'status' => $item->status
            ];
            if (Category::where('id', $item->id)->exists()) {
                Category::where('id', $item->id)->update($input);
                echo 'Update Category: ' . $item->id . '</br>';
            } else {
                Category::create($input);
                echo 'Create Category: ' . $item->id . '</br>';
            }
        }
    });


    $connect2->table('credibility')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'listorder' => $item->order1,
                'status' => $item->status
            ];
            if (Credibility::where('id', $item->id)->exists()) {
                Credibility::where('id', $item->id)->update($input);
                echo 'Update Credibility: ' . $item->id . '</br>';
            } else {
                Credibility::create($input);
                echo 'Create Credibility: ' . $item->id . '</br>';
            }
        }
    });


    $connect2->table('degree')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'min' => $item->min,
                'max' => $item->max,
                'status' => $item->status
            ];
            if (Degree::where('id', $item->id)->exists()) {
                Degree::where('id', $item->id)->update($input);
                echo 'Update Degree: ' . $item->id . '</br>';
            } else {
                Degree::create($input);
                echo 'Create Degree: ' . $item->id . '</br>';
            }
        }
    });


    $connect2->table('state')->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'title' => $item->title,
                'listorder' => $item->order1,
                'status' => $item->status
            ];
            if (State::where('id', $item->id)->exists()) {
                State::where('id', $item->id)->update($input);
                echo 'Update State: ' . $item->id . '</br>';
            } else {
                State::create($input);
                echo 'Create State: ' . $item->id . '</br>';
            }
        }
    });

});

//TODO: UserContent
Route::get('move-content/{min}/{max}', function ($min, $max) {
    ini_set('max_execution_time', 1000);
    $connect2 = DB::connection('mysql2');

    $connect2->table('content')->where('id', '>', $min)->where('id', '<', $max)->chunk(200, function ($data) {
        $helper = new Helper();
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'admin_id' => $item->admin_id,
                'user_id' => $item->member_id,
                'content' => $item->content
            ];

            $d_t_old = explode(' ', $item->date);

            $array_time_old = explode(':', $d_t_old[1]);
            $array_time_new = [];
            foreach ($array_time_old as $row) {
                $array_time_new[] = $helper->persian2LatinDigit($row);
            }

            $array_date_old = explode('/', $d_t_old[0]);
            $array_date_new = [];
            foreach ($array_date_old as $row) {
                $array_date_new[] = $helper->persian2LatinDigit($row);
            }

            $input['created_at'] = jmktime($array_time_new[0], $array_time_new[1], $array_time_new[2], $array_date_new[1], $array_date_new[0], $array_date_new[2]);

            if (UserContent::where('id', $item->id)->exists()) {
                UserContent::where('id', $item->id)->update($input);
                echo 'Update UserContent: ' . $item->id . '</br>';
            } else {
                UserContent::create($input);
                echo 'Create UserContent: ' . $item->id . '</br>';
            }
        }
    });

    return 'end';
});

//TODO: Grade
Route::get('move-grade/{min}/{max}', function ($min, $max) {
    ini_set('max_execution_time', 1000);
    $connect2 = DB::connection('mysql2');

    $connect2->table('grade')->where('id', '>', $min)->where('id', '<', $max)->chunk(200, function ($data) {
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'user_id' => $item->member_id,
                'education' => $item->education,
                'prizes' => $item->prizes,
                'membership' => $item->membership,
                'project_required1' => $item->project_required1,
                'project_required2' => $item->project_required2,
                'project_required3' => $item->project_required3,
                'project_required4' => $item->project_required4,
                'project_required5' => $item->project_required5,
                'writing' => $item->writing,
                'invention1' => $item->invention1,
                'invention2' => $item->invention2,
                'invention3' => $item->invention3,
                'invention4' => $item->invention4,
                'invention5' => $item->invention5,
                'activity' => $item->activity,
                'education_courses' => $item->education_courses,
                'research_projects' => $item->research_projects,
                'use_of_services1' => $item->use_of_services1,
                'use_of_services2' => $item->use_of_services2,
                'use_of_services3' => $item->use_of_services3,
                'use_of_services4' => $item->use_of_services4,
                'use_of_services5' => $item->use_of_services5,
                'services_caribbean' => $item->services_caribbean
            ];

            $connect3 = DB::connection('mysql2');
            $member = $connect3->table('member')->where('id', $item->member_id)->first();
            if ($member) {
                if ($member->scientific_certification_persian == 1) $input['scientific_certification_persian'] = 1;
                else $input['scientific_certification_persian'] = 0;

                if ($member->scientific_certification_english == 1) $input['scientific_certification_english'] = 1;
                else $input['scientific_certification_english'] = 0;
            }

            if (Grade::where('id', $item->id)->exists()) {
                Grade::where('id', $item->id)->update($input);
                echo 'Update Grade: ' . $item->id . '</br>';
            } else {
                Grade::create($input);
                echo 'Create Grade: ' . $item->id . '</br>';
            }
        }
    });
    return 'end';
});

//TODO: Message, MessageCore
Route::get('move-message', function () {
    $connect2 = DB::connection('mysql2');

    $connect2->table('message')->chunk(200, function ($data) {
        $helper = new Helper();
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'user_id' => $item->member_id,
                'title' => $item->title,
                'file' => $item->file,
                'factualy_id' => $item->faculty_title_id,
                'content' => $item->content
            ];

            if ($item->status == 1) {
                $status = 1;
            } elseif ($item->status == 3) {
                $status = 2;
            } else {
                $status = 0;
            }
            $input['status'] = $status;

            $d_t_old = explode(' ', $item->date);
            $array_time_old = explode(':', $d_t_old[1]);
            $array_time_new = [];
            foreach ($array_time_old as $row) {
                $array_time_new[] = $helper->persian2LatinDigit($row);
            }
            $array_date_old = explode('/', $d_t_old[0]);
            $array_date_new = [];
            foreach ($array_date_old as $row) {
                $array_date_new[] = $helper->persian2LatinDigit($row);
            }
            $input['created_at'] = jmktime($array_time_new[0], $array_time_new[1], 0, $array_date_new[1], $array_date_new[2], $array_date_new[0]);

            if (Message::where('id', $item->id)->exists()) {
                Message::where('id', $item->id)->update($input);
                echo 'Update Message: ' . $item->id . '</br>';
            } else {
                Message::create($input);
                echo 'Create Message: ' . $item->id . '</br>';
            }

        }
    });

    $connect2->table('message_core')->chunk(200, function ($data) {
        $helper = new Helper();
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'user_id' => $item->member_id,
                'title' => $item->title,
                'file' => $item->file,
                'factualy_id' => $item->faculty_title_id,
                'content' => $item->content
            ];

            if ($item->status == 1) {
                $status = 1;
            } elseif ($item->status == 3) {
                $status = 2;
            } else {
                $status = 0;
            }
            $input['status'] = $status;

            $d_t_old = explode(' ', $item->date);
            if (count($d_t_old) > 4) {
                $array_time_old = explode(':', $d_t_old[5]);
                $array_time_new = [];
                foreach ($array_time_old as $row) {
                    $array_time_new[] = $helper->persian2LatinDigit($row);
                }
                $array_date_new[1] = $helper->persian2LatinDigit($d_t_old[2]);
                $array_date_new[2] = $helper->persian2LatinDigit($d_t_old[4]);
                $array_date_new[0] = $helper->persian2LatinDigit($d_t_old[0]);
                $input['created_at'] = jmktime($array_time_new[0], $array_time_new[1], 0, $array_date_new[1], $array_date_new[2], $array_date_new[0]);

            } else {
                $array_time_old = explode(':', $d_t_old[1]);
                $array_time_new = [];
                foreach ($array_time_old as $row) {
                    $array_time_new[] = $helper->persian2LatinDigit($row);
                }
                $array_date_old = explode('/', $d_t_old[0]);
                $array_date_new = [];
                foreach ($array_date_old as $row) {
                    $array_date_new[] = $helper->persian2LatinDigit($row);
                }
                $input['created_at'] = jmktime($array_time_new[0], $array_time_new[1], 0, $array_date_new[1], $array_date_new[2], $array_date_new[0]);

            }

            if (MessageCore::where('id', $item->id)->exists()) {
                MessageCore::where('id', $item->id)->update($input);
                echo 'Update MessageCore: ' . $item->id . '</br>';
            } else {
                MessageCore::create($input);
                echo 'Create MessageCore: ' . $item->id . '</br>';
            }

        }
    });

    $connect2->table('reply')->chunk(200, function ($data) {
        $helper = new Helper();
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'message_id' => $item->message_id,
                'content' => $item->content
            ];

            $message = Message::find($item->message_id);

            if ($item->admin_id != '-1') {
                $input['admin_id'] = $item->admin_id;
            } else {
                if ($message)
                    $input['user_id'] = $message->member_id;
            }


            $d_t_old = explode(' ', $item->date);
            $array_time_old = explode(':', $d_t_old[1]);
            $array_time_new = [];
            foreach ($array_time_old as $row) {
                $array_time_new[] = $helper->persian2LatinDigit($row);
            }
            $array_date_old = explode('/', $d_t_old[0]);
            $array_date_new = [];
            foreach ($array_date_old as $row) {
                $array_date_new[] = $helper->persian2LatinDigit($row);
            }
            $input['created_at'] = jmktime($array_time_new[0], $array_time_new[1], 0, $array_date_new[1], $array_date_new[2], $array_date_new[0]);


            if (MessageReply::where('id', $item->id)->exists()) {
                MessageReply::where('id', $item->id)->update($input);
                echo 'Update MessageReply: ' . $item->id . '</br>';
            } else {
                MessageReply::create($input);
                echo 'Create MessageReply: ' . $item->id . '</br>';
            }

        }
    });


    $connect2->table('reply_core')->chunk(200, function ($data) {
        $helper = new Helper();
        foreach ($data as $item) {
            $input = [
                'id' => $item->id,
                'message_core_id' => $item->message_id,
                'content' => $item->content
            ];


            $message = MessageCore::find($item->message_id);

            if ($item->admin_id != '-1') {
                $input['admin_id'] = $item->admin_id;
            } else {
                if ($message)
                    $input['user_id'] = $message->member_id;
            }


            $d_t_old = explode(' ', $item->date);
            if (count($d_t_old) > 4) {
                $array_time_old = explode(':', $d_t_old[5]);
                $array_time_new = [];
                foreach ($array_time_old as $row) {
                    $array_time_new[] = $helper->persian2LatinDigit($row);
                }
                $array_date_new[1] = $helper->persian2LatinDigit($d_t_old[2]);
                $array_date_new[2] = $helper->persian2LatinDigit($d_t_old[4]);
                $array_date_new[0] = $helper->persian2LatinDigit($d_t_old[0]);
                $input['created_at'] = jmktime($array_time_new[0], $array_time_new[1], 0, $array_date_new[1], $array_date_new[2], $array_date_new[0]);

            } else {
                $array_time_old = explode(':', $d_t_old[1]);
                $array_time_new = [];
                foreach ($array_time_old as $row) {
                    $array_time_new[] = $helper->persian2LatinDigit($row);
                }
                $array_date_old = explode('/', $d_t_old[0]);
                $array_date_new = [];
                foreach ($array_date_old as $row) {
                    $array_date_new[] = $helper->persian2LatinDigit($row);
                }
                $input['created_at'] = jmktime($array_time_new[0], $array_time_new[1], 0, $array_date_new[1], $array_date_new[2], $array_date_new[0]);

            }

            if (MessageCoreReply::where('id', $item->id)->exists()) {
                MessageCoreReply::where('id', $item->id)->update($input);
                echo 'Update MessageCoreReply: ' . $item->id . '</br>';
            } else {
                MessageCoreReply::create($input);
                echo 'Create MessageCoreReply: ' . $item->id . '</br>';
            }

        }
    });

    return 'end';
});


