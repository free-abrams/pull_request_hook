<?php

namespace App\Service\PushDeer;

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
}
