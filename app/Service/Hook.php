<?php

namespace App\Service;

use App\Service\Gitee\GiteeService;
use App\Service\Github\GithubService;
use App\Service\PushDeer\PushDeer;
use Illuminate\Support\Str;

class Hook
{
    private $provider;

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
        //验证config有没有这个库
        $key = 'hook.'.$param['project']['path_with_namespace'];
        $config = config($key, null);
        if (!$config) {
            throw new \Exception('undefined ref');
        }
        //验证密钥
        $res = (new HookToken())->driver(array_search($this->provider, self::$providers))->handel($config['token'], $param);
        if (!$res) {
            throw new \Exception('undefined token');
        }

        $res = $this->{$method}($param, '/wwww/sss');

        // 这里可以加推送
        $presp = (new PushDeer())->push($method, $param, array_search($this->provider, self::$providers));
        return $res;
    }
}
