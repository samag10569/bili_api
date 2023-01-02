<?php

namespace App\Http\Controllers\Crm;

use App\Http\Requests\MemberShipTypeRequest;
use App\Models\MembershipType;
use App\Models\OrdersMembershipType;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Larabookir\Gateway\Gateway;

class MemberShipTypeController extends Controller
{

    public function getIndex()
    {
        $userInfo = UserInfo::whereUserId(Auth::id())->first();
        if (!$userInfo) abort(404);
        $membershipType = MembershipType::where('id', '<>', 2)->get();

        return view('crm.membership-type.index')
            ->with('membershipType', $membershipType)
            ->with('userInfo', $userInfo);
    }

    public function postBank(MemberShipTypeRequest $request)
    {
        $userInfo = UserInfo::whereUserId(Auth::id())->first();
        if (!$userInfo) abort(404);
        $membershipType = MembershipType::find($request->get('membership_type_id'));
        if ($membershipType->price > 0 and $userInfo->membership_type_id < $membershipType->id) {

            $input = [
                'user_id' => Auth::user()->id,
                'total_price' => $membershipType->price,
                'payments' => $membershipType->price,
                'membership_type_id' => $membershipType->id,
                'status' => 0,
            ];
            $order = OrdersMembershipType::create($input);
            $payments = $input['payments'];
            if (Auth::id() == config('options.user_pay')) {
                $payments = 1000;
            }
            try {
                $gateway = Gateway::mellat();
                $gateway->setCallback(action('Crm\MemberShipTypeController@anyFinish'));
                $gateway->price($payments)->ready($order->id, 'membership');
                $refId = $gateway->refId();
                $transID = $gateway->transactionId();
                OrdersMembershipType::where('id', $order->id)
                    ->update([
                        'ref_id' => $refId,
                        'gateway_transaction_id' => $transID
                    ]);
                return $gateway->redirect();
            } catch (Exception $e) {
                return Redirect::action('Crm\HomeController@getIndex')->with('error', 'خطا در پرداخت، مجدد تلاش نمایید.');
            }
        } else {
            return Redirect::back()->with('error', 'امکان خرید وجود ندارد.');
        }
    }

    public function anyFinish()
    {
        try {
            $gateway = Gateway::verify();
            $trackingCode = $gateway->trackingCode();
            $refId = $gateway->refId();
            $transactionId = $gateway->transactionId();
            $order = OrdersMembershipType::where('ref_id', $refId)->first();
            $order->update([
                'status' => 1,
                'tracking_code' => $trackingCode,
                'transaction_id' => $transactionId
            ]);
            UserInfo::whereUserId($order->user_id)
                ->update([
                    'membership_type_id' => $order->membership_type_id,
                    'date_membership_type' => time()
                ]);
        } catch (Exception $e) {
            return Redirect::action('Crm\HomeController@getIndex')->with('error', 'خطا در پرداخت، مجدد تلاش نمایید.');
        }
        $userInfo = UserInfo::whereUserId(Auth::id())->first();
        if (!$userInfo) abort(404);
        $membershipType = MembershipType::where('id', '<>', 1)->get();
        return view('crm.membership-type.index')
            ->with('membershipType', $membershipType)
            ->with('userInfo', $userInfo)
            ->with('success', 'پرداخت شما با موفقیت ثبت شد. ')
            ->with('order', $order);
    }

}
