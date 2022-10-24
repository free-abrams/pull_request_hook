<?php

namespace App\Service\PushDeer;

use App\Service\Message;
use Illuminate\Support\Facades\Http;

class PushDeer
{
    private $url = 'https://api2.pushdeer.com/message/push';

    public function request($key, $msg, $desp)
    {
        $request = Http::asForm()->post($this->url, [
            'text' => $msg,
            'desp' => $desp,
            'pushkey' => $key
        ]);
        return $request;
    }

    public function push($event, $param)
    {
        $auth = Message::getAuth($event, $param);
        $branch = Message::getRef($event, $param);
        $time = Message::getCreatedAt($event, $param);

        $txt = $auth.' 推送到了 分支:'.$branch.' 于 '.$time;
        $keys = Config('pushDeer.keys');
        $key = implode(',', $keys);
        return $this->request($key, $txt, $desp = '无');
    }
}
