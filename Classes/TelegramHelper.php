<?php

namespace Classes;


use App\Models\News;
use App\Models\TelegramInbound;


class TelegramHelper
{
    private $command;


    public function __construct($command)
    {
        $this->command = $command;
    }


    public function getMessage()
    {
        // ini_set('max_execution_time', 1800);

        $cmd = $this->command;
        $rsp = [];

        if ($cmd == '/start') {

            $rsp['msg'] = 'لطفا یکی از گزینه ها را انتخاب نمایید';

            $rsp['keyboard'] = array(
                'keyboard' => array(
                    array('لینک ثبت نام', 'آدرس سایت'),
                    array('اخبار سایت')
                ),
            );

        } else if ($cmd == 'شروع مجدد') {
            $rsp['msg'] = 'لطفا یکی از گزینه ها را انتخاب نمایید';

            $rsp['keyboard'] = array(
                'keyboard' => array(
                    array('لینک ثبت نام', 'آدرس سایت'),
                    array('اخبار سایت')
                ),
            );
        } else if ($cmd == '/site') {
            $rsp['msg'] = 'https://www.ejavan.net';

            $rsp['keyboard'] = array(
                'keyboard' => array(
                    array('شروع مجدد')
                ),
            );
        } else if ($cmd == 'لینک ثبت نام') {
            $rsp['msg'] = 'https://www.ejavan.net/register/step1';

            $rsp['keyboard'] = array(
                'keyboard' => array(
                    array('شروع مجدد')
                ),
            );
        } else if ($cmd == '/register') {
            $rsp['msg'] = 'https://www.ejavan.net/register/step1';

            $rsp['keyboard'] = array(
                'keyboard' => array(
                    array('شروع مجدد')
                ),
            );
        } else if ($cmd == 'آدرس سایت') {
            $rsp['msg'] = 'https://www.ejavan.net';

            $rsp['keyboard'] = array(
                'keyboard' => array(
                    array('شروع مجدد')
                ),
            );
        } else if ($cmd == 'اخبار سایت') {
            $key = News::where('status', 1)->pluck('title');
            $rsp['msg'] = 'لطفا یکی از گزینه ها را انتخاب نمایید';

            $rsp['keyboard'] = array(
                'keyboard' => array(
                    $key,
                    array('شروع مجدد')
                ),
            );
        } else if (News::where('title', $cmd)->where('status', 1)->exists()) {
            $result = News::where('title', $cmd)->where('status', 1)->first();
            $rsp['msg'] = $result->content;
            $rsp['keyboard'] = array(
                'keyboard' => array(
                    array('شروع مجدد')
                ),
            );
        } else if (News::where('content', 'LIKE', '%' . $cmd . '%')->where('status', 1)->exists()) {
            $result = News::where('content', 'LIKE', '%' . $cmd . '%')->where('status', 1)->first();
            $rsp['msg'] = $result->content;
            $rsp['keyboard'] = array(
                'keyboard' => array(
                    array('شروع مجدد')
                ),
            );
        } else {
            $rsp['msg'] = 'پیام ارسالی نامعتبر است.';

            $rsp['keyboard'] = array(
                'keyboard' => array(
                    array('لینک ثبت نام', 'آدرس سایت'),
                    array('اخبار سایت')
                ),
            );
        }

        return $rsp;
    }

}