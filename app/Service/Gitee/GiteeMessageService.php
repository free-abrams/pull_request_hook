<?php

namespace App\Service\Gitee;

use Carbon\Carbon;
class GiteeMessageService
{

    private $p_r_actions = [
        'open' => '新增合并请求',
        'assign' => '等待审查',
        'test' => '等待测试',
        'approved' => '审查通过',
        'tested' => '测试通过',
        'merge' => '合并分支',
    ];

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

    public function handel($event, $param)
    {

    }

    private function push()
    {

    }

    public function tagPush()
    {

    }

    public function mergeRequestHooks($param)
    {
        $action = $this->p_r_actions[$param['action']];

        $project = $param['project']['full_name'];

        $source_branch = $param['source_branch'];
        $target_branch = $param['target_branch'];

        $auth = $param['author']['name'];
        $updated_by = $param['updated_by']['name'];

        $time = Carbon::createFromTimestampMs($param['timestamp']);
        // 新增合并请求[kaiseryf/hook_test]，从[develop]->[master]创建人：author，更新人：于 xxx
        // xxx 在xxx 仓库 合并分支 xxx 分支 与 xxxx xx::xx:xx
        return [
            'title' => "{$action}[{$project}]，从[{$source_branch}]->[{$target_branch}]",
            'desp' => "创建人：{$auth}\n更新人：{$updated_by} \n于".$time->diffForHumans(),
        ];
    }

}
