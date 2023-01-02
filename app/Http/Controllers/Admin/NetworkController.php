<?php

namespace App\Http\Controllers\Admin;

use App\Models\State;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class NetworkController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = User::query();

        $query->whereMember(1)
            ->with('admin', 'info', 'register', 'userStatus')
            ->join('friendships', 'users.id', 'friendships.sender_id')
            ->where('friendships.status',1);

        if ($request->has('search')) {

            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('start_interview') and $request->has('end_interview')) {
                $start = explode('/', $request->get('start_interview'));
                $end = explode('/', $request->get('end_interview'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('date_interview', array($s, $e));
            }
            if ($request->has('name')) {
                $query->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }
            if ($request->has('family')) {
                $query->where('family', 'LIKE', '%' . $request->get('family') . '%');
            }
            if ($request->has('email')) {
                $query->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }
            if ($request->has('user_code')) {
                $query->where('user_code', $request->get('user_code'));
            }
            if ($request->has('id')) {
                $query->where('id', $request->get('id'));
            }
            if ($request->has('state_id')) {
                $query->join('user_info', 'users.id', '=', 'user_info.user_id')
                    ->where('user_info.state_id', $request->get('state_id'));
            }
            if ($request->get('sort') == 'date_interview') {
                $query->orderBy('users.date_interview', 'DESC');
            } else {
                $query->orderBy('users.id', 'DESC');
            }
        }

        if (!$request->has('sort')) {
            $query->orderBy('users.id', 'DESC');
        }

        $data = $query->select([
            'users.id as id',
            'users.name as name',
            'users.family as family',
            'users.user_code as user_code',
            'users.admin_id as admin_id',
            'users.register_id as register_id',
            'users.mobile as mobile',
            'users.status_id as status_id',
            'users.email as email',
            'users.created_at as created_at',
            'users.date_interview as date_interview',
        ])->distinct()->paginate(15);

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'همه'] + $state_id;

        $sort = [
            'id' => 'کد یکتا',
            'date_interview' => 'تاریخ مصاحبه',
        ];

        $countFriend = [];
        foreach ($data as $item) {
            $countFriend[$item->id] = $item->getFriendsCount();
        }

        return view('admin.network.index')
            ->with('state_id', $state_id)
            ->with('sort', $sort)
            ->with('data', $data)
            ->with('countFriend', $countFriend);
    }

    public function getFriend($user_id)
    {
        $user = User::whereMember(1)
            ->whereId($user_id)
            ->first();
        $data = $user->getFriends($perPage = 20);
        $countFriend = [];
        foreach ($data as $item) {
            $countFriend[$item->id] = $item->getFriendsCount();
        }

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'همه'] + $state_id;

        $sort = [
            'id' => 'کد یکتا',
            'date_interview' => 'تاریخ مصاحبه',
        ];

        return view('admin.network.friend')
            ->with('state_id', $state_id)
            ->with('sort', $sort)
            ->with('user', $user)
            ->with('data', $data)
            ->with('countFriend', $countFriend);
    }
    
    public function getRemoveFriendRequest($sender, $recipient)
    {
        $user = User::find($sender);
        $friend = User::find($recipient);
        $user->unfriend($friend);
        return Redirect::back()
            ->with('success', 'درخواست اتصال به کاربر حذف شد.');
    }

}
