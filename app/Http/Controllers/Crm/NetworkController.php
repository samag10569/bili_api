<?php

namespace App\Http\Controllers\Crm;

use App\Http\Requests\NetworkRequest;
use App\Models\ContactsList;
use App\User;
use Classes\UserCheck;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class NetworkController extends Controller
{
    public function getIndex()
    {
        $user = Auth::user();
        $friends = $user->getFriends($perPage = 20);
        $friend_count = $user->getFriendsCount();
        if ($friend_count == 0)
            Session::put('info', 'متاسفانه اطلاعاتی یافت نشد.');
        return view('crm.network.index')
            ->with('friends', $friends)
            ->with('friend_count', $friend_count);
    }

    public function getSearch(Request $request)
    {
        $searchUser = [];
        if ($request->has('search')) {
            $query = User::query()
                ->whereMember(1)
                ->with('category', 'branchInfo', 'info');
            if ($request->has('name')) {
                $query->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }
            if ($request->has('family')) {
                $query->where('family', 'LIKE', '%' . $request->get('family') . '%');
            }
            if ($request->has('branch')) {
                $query->join('user_info', 'users.id', '=', 'user_info.user_id')
                    ->where('user_info.branch', 'LIKE', '%' . $request->get('branch') . '%');
            }
            $searchUser = $query->select([
                'users.id as id',
                'users.name as name',
                'users.family as family',
                'users.user_code as user_code',
                'users.email as email',
                'users.image as image',
                'users.category_id as category_id',
                'users.branch_id as branch_id',
            ])->paginate(15);
        }
        return view('crm.network.search')
            ->with('searchUser', $searchUser);
    }

    public function getSendFriendRequest($user_id)
    {
        $user = Auth::user();
        $recipient = User::find($user_id);
        $user->befriend($recipient);
        return Redirect::back()
            ->with('success', 'درخواست اتصال به کاربر ارسال شد.');
    }

    public function getRemoveFriendRequest($user_id)
    {
        $user = Auth::user();
        $friend = User::find($user_id);
        $user->unfriend($friend);
        return Redirect::back()
            ->with('success', 'درخواست اتصال به کاربر حذف شد.');
    }

    public function getAcceptFriendRequest($user_id)
    {
        $user = Auth::user();
        $friend = User::find($user_id);
        $user->acceptFriendRequest($friend);
        return Redirect::back()
            ->with('success', 'درخواست اتصال پذیرفته شد.');
    }

    public function getFriendRequest()
    {
        //TODO: change query important

        $user = Auth::user();
        $friendsId = $user->getPendingFriendships()->pluck('recipient_id')->all();
        $friendsIdMin = $user->getFriendRequests()->pluck('recipient_id')->all();
        $friendsId = array_diff($friendsId, $friendsIdMin);
        $friends = User::whereIn('id', $friendsId)
            ->with('category', 'branchInfo', 'info')
            ->paginate(15);
        if (count($friends) == 0)
            Session::put('info', 'متاسفانه اطلاعاتی یافت نشد.');
        return view('crm.network.friend-request')
            ->with('friends', $friends);
    }

    public function getFriendRequestOther()
    {
        //TODO: change query important

        $user = Auth::user();
        $friendsId = $user->getFriendRequests()->pluck('sender_id')->all();
        $friends = User::whereIn('id', $friendsId)
            ->with('category', 'branchInfo', 'info')
            ->paginate(15);
        if (count($friends) == 0)
            Session::put('info', 'متاسفانه اطلاعاتی یافت نشد.');
        return view('crm.network.friend-request-other')
            ->with('friends', $friends);
    }

    public function getIntroduction()
    {
        return view('crm.network.introduction');
    }

    public function postIntroduction(NetworkRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        if (ContactsList::whereEmail($input['email'])->exists()) {
            return Redirect::back()->with('success', 'دعوت نامه در صف ارسال قرار گرفت.');
        } else {
            $introduction = ContactsList::create($input);
            $checker = new UserCheck();
            $checker->emailIntroduction($introduction->id);
            return Redirect::back()->with('success', 'دعوت نامه با موفقیت ارسال شد.');
        }
    }
}
