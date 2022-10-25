<?php

namespace App\Service\Gitee;

use Illuminate\Support\Facades\Request;

class GiteeService
{
    private $cmd = 'git pull --rebase 2>&1';

    public function pushHooks($param, string $path)
    {
        $cmd = [];
        $cmd[] = 'cd '.$path;
        $cmd[] = $this->cmd;

        $exe = implode(' && ', $cmd);

        return shell_exec($exe);
    }

    public function tagPushHooks($param, string $path)
    {
        $cmd = [];
        $cmd[] = 'cd '.$path;
        $cmd[] = $this->cmd;

        $exe = implode(' && ', $cmd);

        return shell_exec($exe);
    }

    public function mergeRequestHooks($param, string $path)
    {
        $cmd = [];
        $cmd[] = 'cd '.$path;
        $cmd[] = $this->cmd;

        $exe = implode(' && ', $cmd);

        return shell_exec($exe);
    }


}
