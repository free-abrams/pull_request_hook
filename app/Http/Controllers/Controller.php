<?php

namespace App\Http\Controllers;

use App\Service\Hook;
use App\Service\Message;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function hook(Request $request)
    {
        $param = $request->all();
        $param['event'] = $request->header('X-GitHub-Event');

        $validate = Validator::make($param, [
            'event' => Rule::in(['push', 'pull_request']),
            'action' => ['nullable', Rule::in(['closed', 'opened'])]
        ]);

        if ($validate->fails()) {
            return Response::json([
                'code' => 401,
                'msg' => $validate->errors()->first(),
                'data' => []
            ]);
        }

        try {
            $res = (new Hook())->driver('github')->handel($param['event'], $param);
            return Response::json(['code' => 400, 'msg' => 'SUCCESS', 'data' => $res]);
        } catch (\Exception $e) {
            return Response::json(['code' => 400, 'msg' => $e->getMessage(), 'data' => []]);
        }
    }

    public function gitee(Request $request)
    {
        $param = $request->all();
        $param['heads'] = $request->headers->all();
        $validate = Validator::make($param, [
            'hook_name' => Rule::in(['push_hooks', 'merge_request_hooks']),
            'heads.x-gitee-timestamp' => 'required',
        ]);

        if ($validate->fails()) {
            return Response::json([
                'code' => 401,
                'msg' => $validate->errors()->first(),
                'data' => []
            ]);
        }

        try {
            //$res = (new Hook())->driver('gitee')->handel($param['hook_name'], $param);
            $cmd = 'sudo -u www /data/bash/git.sh';
            $res = shell_exec($cmd);
            return Response::json(['code' => 200, 'msg' => 'SUCCESS', 'data' => $res]);
        } catch (\Exception $e) {
            return Response::json(['code' => 400, 'msg' => $e->getMessage(), 'data' => []]);
        }
    }

    public function testStatic()
    {
        $param = \Illuminate\Support\Facades\Request::all();
        return Message::gitee()->generatePushHook($param);
    }
}
