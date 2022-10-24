<?php

namespace App\Service;

use App\Service\PushDeer\PushDeer;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Hook
{
    private $config;

    private $provider;

    private $driver;

    public function __construct()
    {
        $this->config = Config('hook.default');
    }

    public function driver($name = null)
    {
        if ($name === null) {
            $this->driver = Config('hook.drivers.'.$name);
        } else {
            $this->driver = Config('hook.drivers.'.$name, null);
        }

        if ($this->driver === null) {
            throw new \Exception('driver of '.$name.' undefined');
        }
        $this->config = $this->driver;
        $this->provider = $this->driver['driver'];

        return $this;
    }

    public function handel($event, $param)
    {
        $method = Str::camel($event);
        // 这里可以加推送
        (new PushDeer())->push($method, $param);

        return $this->{$method}($param);
    }

    public function __call($name, $arguments)
    {
        if ($this->provider === null) {
            $this->driver();
        }

        return (new $this->provider($this->config))->{$name}(...$arguments);
    }
}
