<?php

namespace App\Service;

use App\Service\Gitee\GiteeService;
use App\Service\Github\GithubService;
use App\Service\PushDeer\PushDeer;
use Illuminate\Support\Str;

class Hook
{
    private $config;

    //private $provider;

    private $driver;

    private static $providers = [
        'gitee' => GiteeService::class,
        'github' => GithubService::class,
    ];

    public function __construct()
    {

    }

    public function __call($name, $arguments)
    {
        return (new $this->provider)->{$name}(...$arguments);
    }

    public function driver($name): Hook
    {
        if (!$name) {
            throw new \Exception('driver of '.$name.' undefined');
        }

        $this->provider = self::$providers[$name];

        return $this;
    }

    public function handel($event, $param)
    {
        $method = Str::camel($event);


        $res = $this->{$method}($param);

        // 这里可以加推送
        (new PushDeer())->push($method, $param);

        return $res;
    }


}
