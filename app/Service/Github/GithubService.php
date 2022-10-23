<?php

namespace App\Service\Github;

use App\Service\Git;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class GithubService
{
    private $config;

    private $cmd = 'git pull';

    public function __construct($config)
    {
        $this->config = $config;
        if (Request::method() !== $this->config['method']) {
            throw new \Exception('unsupported method '.Request::method());
        }
    }

    public function push($param)
    {
        $cmd = [];
        $cmd[] = 'cd '.$this->config['path'];
        $cmd[] = $this->cmd;

        $exe = implode(' && ', $cmd);
dump($exe);
        return shell_exec($exe);
    }

    public function pullRequest($param)
    {
        if ($param['action'] == 'closed') {
            return $this->closed($param);
        }
        if ($param['action'] == 'opened') {
            return $this->opened($param);
        }

        return false;
    }

    private function closed($param)
    {
        $cmd = [];
        $cmd[] = 'cd '.$this->config['path'];
        $cmd[] = $this->cmd;

        $exe = implode(' && ', $cmd);

        return shell_exec($exe);
    }

    private function opened($param)
    {
        $cmd = [];
        $cmd[] = 'cd '.$this->config['path'];
        $cmd[] = $this->cmd;

        $exe = implode(' && ', $cmd);

        return shell_exec($exe);
    }
}
