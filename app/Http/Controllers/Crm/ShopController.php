<?php

namespace App\Http\Controllers\Crm;

use App\Http\Requests\ShopRequest;
use App\Models\Allotment;
use App\Models\AllotmentUser;
use App\Models\OrderItem;
use App\Models\Orders;
use App\Models\UserInfo;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Larabookir\Gateway\Gateway;

class ShopController extends Controller
{
    public function getCart()
    {
        $count = Cart::count();
        if ($count) {
            $cart = Cart::content();
            $total_price = 0;
            foreach ($cart as $item) {
                $total_price += $item->options->price_orginal;
            }
            return View('crm.shop.index')
                ->with('cart', $cart)
                ->with('total_price', $total_price)
                ->with('count', $count);
        } else {
            return Redirect::back()->with('error', 'سبد خرید خالی می باشد.');
        }
    }

    public function postRemoveCart(Request $request)
    {
        $inputs = $request->all();
        $allotment_id = $inputs['allotment_id'];

        $existingItem = Cart::search(function ($cartItem, $rowId) use ($allotment_id) {
            return $cartItem->id === $allotment_id;
        });

        if ($existingItem->count() > 0) {
            Cart::remove($existingItem->first()->rowId);
            return Redirect::back()->with('success', 'سبد خرید به روز رسانی شد.');
        }
        return Redirect::back()->with('error', 'آیتم انتخاب شده موجود نمی باشد.');
    }


    public function postRemoveAllCart()
    {
        Cart::destroy();
        return Redirect::action('Crm\HomeController@getIndex')->with('success', 'سبد خرید حذف شد.');
    }

    public function postAddCart(ShopRequest $request)
    {
        $inputs = $request->all();
        $allotment = Allotment::where('id', $inputs['allotment_id'])
            ->first(['id', 'title', 'price', 'gold_price', 'image', 'content']);

        if ($allotment->price != 0) {
            $allotment_id = $inputs['allotment_id'];

            $user_info = UserInfo::whereUserId(Auth::id())->first();
            if (!$user_info) abort(404);

            if ($user_info->membership_type_id == 3 || $user_info->membership_type_id == 4) {
                if ($allotment->gold_price == 0)
                    $finalPrice = $allotment->price;
                else
                    $finalPrice = $allotment->gold_price;
            } else {
                $finalPrice = $allotment->price;
            }

            $existingItem = Cart::search(function ($cartItem, $rowId) use ($allotment_id) {
                return $cartItem->id === $allotment_id;
            });

            $cartItem = null;
            if ($allotment->price > 0) {
                if ($existingItem->count() == 0) {
                    Cart::add(['id' => $allotment_id, 'name' => $allotment->title,
                        'qty' => 1, 'price' => $finalPrice, 'options' => [
                            'price_orginal' => $allotment->price,
                            'gold_price' => $allotment->gold_price,
                            'content' => $allotment->content,
                            'image' => $allotment->image,
                        ]
                    ]);
                    return Redirect::back()->with('success', 'سبد خرید به روز رسانی شد.');
                } else {
                    return Redirect::back()->with('error', 'خدمت انتخابی قبلا به سبد خرید اضافه شده است.');
                }
            } else {
                return Redirect::back()->with('error', 'خدمت انتخابی به صورت رایگان تخصیص می یابد.');
            }
        } else {
            $input = [
                'user_id' => Auth::user()->id,
                'allotment_id' => $allotment->id,
                'status' => 1,
            ];
            AllotmentUser::create($input);
            return Redirect::back()->with('success', 'خدمت انتخابی برای شما ثبت شد، پس از تایید مدیر به شما تخصیص می یابد.');
        }

    }

    public function postBank()
    {
        $count = Cart::count();
        if ($count) {
            $cart = Cart::content();
            $total_price = 0;
            foreach ($cart as $item) {
                $total_price += $item->options->price_orginal;
            }
            $payments = Cart::subtotal(0, '', '');
            if (Auth::id() == config('options.user_pay')) {
                $payments = 1000;
            }

            $input = [
                'user_id' => Auth::user()->id,
                'total_price' => $total_price,
                'payments' => $payments,
                'quantity' => $count,
                'status' => 0,
            ];
            $order = Orders::create($input);
            foreach ($cart as $item) {
                $input_item = [
                    'order_id' => $order->id,
                    'allotment_id' => $item->id,
                    'price' => $item->options->price_orginal,
                    'gold_price' => $item->options->gold_price,
                    'quantity' => $item->qty,
                    'total_price' => $item->price,
                ];
                OrderItem::create($input_item);
            }
            try {
                $gateway = Gateway::mellat();
                $gateway->setCallback(action('Crm\ShopController@anyFinish'));
                $gateway->price($payments)->ready($order->id, 'allotment');
                $refId = $gateway->refId();
                $transID = $gateway->transactionId();
                Orders::where('id', $order->id)
                    ->update([
                        'ref_id' => $refId,
                        'gateway_transaction_id' => $transID
                    ]);
                return $gateway->redirect();
            } catch (Exception $e) {
                return Redirect::action('Crm\HomeController@getIndex')->with('error', 'خطا در پرداخت، مجدد تلاش نمایید.');
            }
        } else {
            return Redirect::back()->with('error', 'سبد خرید خالی می باشد.');
        }
    }

    public function anyFinish(Request $request)
    {
        try {
            $gateway = Gateway::verify();
            $trackingCode = $gateway->trackingCode();
            $refId = $gateway->refId();
            $transactionId = $gateway->transactionId();
            $order = Orders::where('ref_id', $refId)
                ->update([
                    'status' => 1,
                    'tracking_code' => $trackingCode,
                    'transaction_id' => $transactionId
                ]);
            $items = OrderItem::whereOrderId($order->id)->get();
            foreach ($items as $item) {
                $input = [
                    'user_id' => $order->user_id,
                    'allotment_id' => $item->allotment_id,
                    'status' => 1,
                ];
                AllotmentUser::create($input);
            }
        } catch (Exception $e) {
            return Redirect::action('Crm\HomeController@getIndex')->with('error', 'خطا در پرداخت، مجدد تلاش نمایید.');
        }
        $order = Orders::where('ref_id', $refId)->first();
        return view('crm.shop.finish')->with('success', 'پرداخت شما با موفقیت ثبت شد. ')->with('order', $order);
    }

}
