<?php

namespace App\Service\Gitee;

use Illuminate\Support\Facades\Request;

class GiteeService
{
    private $cmd = 'git pull --rebase 2>&1';

    public function pushHooks($param)
    {
        $res = $this->checkToken('123456', $param);
        if ($res === false) {
            throw new \Exception('unknow token get');
        }

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

    private function checkToken($token, $param): bool
    {
        $sign = $param['sign'];
        $timestamp = $param['timestamp'];

        $secret_str = "{$timestamp}\n{$token}";
        $compute_token = base64_encode(hash_hmac('sha256', $secret_str, $token, true));
        if ($sign !== $compute_token) {
            return false;
        }

        return true;
    }
}
