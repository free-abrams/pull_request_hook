<?php

namespace App\Service\Gitee;

use Carbon\Carbon;
class GiteeMessageService
{
    public function getAuth($event, $param)
    {
        if ($event === 'pushHook') {
            return $param['pusher']['name'];
        }
        if ($event === 'mergeRequestHook') {
            return $param['pusher']['name'];
        }
        return '';
    }

    public function getRef($event, $param)
    {
        if ($event === 'pushHook') {
            return $param['ref'];
        }
        if ($event === 'mergeRequestHook') {
            return $param['pusher']['name'];
        }
        return '';
    }

    public function getCreatedAt($event, $param): string
    {
        $time = '';
        if ($event === 'pushHook') {
            $time =  $param['repository']['created_at'];
        }
        if ($event === 'mergeRequestHook') {
            $time = $param['repository']['created_at'];
        }

        $time = new Carbon($time);
        return $time->diffForHumans();
    }
}
