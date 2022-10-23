<?php
use Illuminate\Support\Str;

return [

    'default' => [
            'driver' => env('HOOK_DRIVER', 'gitee'),
            'path' => env('HOOK_PATH', 'path'),
        ],

    'drivers' => [
        'gitee' => [
            'driver' => \App\Service\Gitee\GiteeService::class,
            'method' => 'POST',
            'actions' => 'pullRequest',
            'path' => '/Users/yangfeng/Desktop/hook/hook_test',
            ''
        ],
        'github' => [
            'driver' => \App\Service\Github\GithubService::class,
            'method' => 'POST',
            'actions' => 'pullRequest',
            'path' => '/Users/yangfeng/Desktop/hook/hook_test'
        ],
    ],


    'actions' => [
        'pullRequest' => [
                'pull',
                'pullRequest'
        ],
    ],
];
