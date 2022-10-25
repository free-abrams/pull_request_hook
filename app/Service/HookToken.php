<?php

namespace App\Service;

use App\Service\Gitee\GiteeValidate;

class HookToken
{
    private static $providers = [
        'gitee' => GiteeValidate::class,
    ];

    private $provider;

    public function driver($name): HookToken
    {
        if (!array_key_exists($name, self::$providers)) {
            throw new \Exception('call undefined provider '.$name);
        }

        $this->provider = new self::$providers[$name];

        return $this;
    }

    public function handel($key, $param)
    {
        return $this->provider->checkToken($key, $param);
    }

    public static function __callStatic($name, $arguments)
    {
        $ref = new \ReflectionClass(self::$providers['gitee']);
        $fuc = $ref->getMethod($name);
        $class = $ref->newInstance();
        return $fuc->invoke($class, ...$arguments);
    }
}
