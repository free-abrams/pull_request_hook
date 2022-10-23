<?php

namespace App\Service\Github;

use App\Service\Git;
use Illuminate\Support\Facades\Request;

class GithubService
{
    private $config;

    private $cmd = 'git pull';

    public function __construct($config)
    {
        $this->config = $config;
        if (Request::method() !== $this->config['method']) {
            throw new \Exception('unSupport method '.Request::method());
        }
    }

    public function pullEvent()
    {
        $cmd = [];
        $cmd[] = 'cd '.$this->config['path'];
        $cmd[] = $this->cmd;

        $exe = implode(' && ', $cmd);

        return shell_exec($exe);
    }

    public function pullRequestEvent()
    {
        $cmd = [];
        $cmd[] = 'cd '.$this->config['path'];
        $cmd[] = $this->cmd;

        $exe = implode('&&', $cmd);

        return shell_exec($exe);
    }
}
