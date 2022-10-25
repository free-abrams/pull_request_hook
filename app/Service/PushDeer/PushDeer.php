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

    public function push($event, $param, $driver)
    {
        $param = (new Message)->driver($driver)->handel($event, $param);

        $keys = Config('pushDeer.keys');
        $key = implode(',', $keys);
        return $this->request($key, $param['title'], $desp = $param['desp']);
    }
}
