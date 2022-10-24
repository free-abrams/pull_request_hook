<?php

namespace App\Service\Gitee;

use Illuminate\Support\Facades\Request;

class GiteeService
{
    private $config;

    private $cmd = 'git pull --rebase 2>&1';

    public function __construct($config)
    {
        $this->config = $config;
        if (Request::method() !== $this->config['method']) {
            throw new \Exception('unsupported method '.Request::method());
        }
    }

    public function pushHook($param)
    {
        $cmd = [];
        $cmd[] = 'cd '.$this->config['path'];
        $cmd[] = $this->cmd;

        $exe = implode(' && ', $cmd);

        return shell_exec($exe);
    }

    public function mergeRequestHook($param)
    {
        $cmd = [];
        $cmd[] = 'cd '.$this->config['path'];
        $cmd[] = $this->cmd;

        $exe = implode(' && ', $cmd);

        return shell_exec($exe);
    }
}
