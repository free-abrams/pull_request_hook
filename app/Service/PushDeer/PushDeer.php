<?php

namespace App\Service\PushDeer;

use Illuminate\Support\Facades\Http;

class PushDeer
{
    private $url = 'https://api2.pushdeer.com/message/push';

    public function push(string $text,string $desp = '', $type='text', $key = '[PUSHKEY]')
    {
        $postdata = http_build_query(array( 'text' => $text, 'desp' => $desp, 'type' => $type , 'pushkey' => $key ));
        $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata));

        $context  = stream_context_create($opts);
        return $result = file_get_contents('https://api2.pushdeer.com/message/push', false, $context);
    }

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
