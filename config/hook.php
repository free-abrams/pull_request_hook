<?php
use Illuminate\Support\Str;

return [

    'default' => [
            'driver' => env('HOOK_DRIVER', 'gitee'),
            'path' => env('HOOK_PATH', 'path'),
        ],

    'token' => env('HOOK_TOKEN', ''),

    'drivers' => [
        'gitee' => [
            'driver' => \App\Service\Gitee\GiteeService::class,
            'method' => 'POST',
            'path' => '/data/wwwroot/gitee_hook_test',
        ],
        'github' => [
            'driver' => \App\Service\Github\GithubService::class,
            'method' => 'POST',
            'path' => '/data/wwwroot/hook_test',
        ],
    ],


    'actions' => [
        'pullRequest' => [
                'pull',
                'pullRequest'
        ],
    ],
];
