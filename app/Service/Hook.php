<?php

namespace App\Service;

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

    public function __call($name, $arguments)
    {
        if ($this->provider === null) {
            $this->driver();
        }

        (new $this->provider($this->config))->{$name}();
    }
}
