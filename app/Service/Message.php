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

    private static $event = [
        'pushHook' => GiteeMessageService::class,
        'mergeRequestHook' => GiteeMessageService::class,
        'github' => GithubMessageService::class,
    ];

    public static function driver($name)
    {
        if (!array_key_exists($name, self::$providers)) {
            throw new \Exception('call undefined provider '.$name);
        }
        return new self::$providers[$name];
    }

    public static function __callStatic($name, $arguments)
    {
        if (!array_key_exists($arguments[0], self::$event)) {
            throw new \Exception('call undefined event '.$arguments[0]);
        }
        $ref = new \ReflectionClass(self::$event[$arguments[0]]);
        $fuc = $ref->getMethod($name);
        $class = $ref->newInstance();
        return $fuc->invoke($class, ...$arguments);
        // TODO: Implement __callStatic() method.
    }
}
