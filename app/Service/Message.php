<?php

namespace App\Service;

use App\Service\Gitee\GiteeMessageService;
use App\Service\Github\GithubMessageService;

class Message
{
    private static $providers = [
        'gitee' => GiteeMessageService::class,
        'github' => GithubMessageService::class,
    ];

    private $provider;

    public function driver($name): Message
    {
        if (!array_key_exists($name, self::$providers)) {
            throw new \Exception('call undefined provider '.$name);
        }

        $this->provider = new self::$providers[$name];

        return $this;
    }

    public function handel($event, $param)
    {
        return $this->provider->{$event}($param);
    }
}
