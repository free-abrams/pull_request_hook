<?php

namespace App\Service\Github;

use App\Service\Git;

class GithubService
{
    private $config;

    private $cmd = 'git pull';

    public function __construct($config)
    {
        $this->config = $config;
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
