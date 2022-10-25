<?php

namespace App\Service\Gitee;

class GiteeValidate
{
    public function checkToken($token, $param): bool
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
