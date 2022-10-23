<?php

namespace App\Http\Controllers;

use App\Service\Hook;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function hook(Request $request)
    {
        $param = $request->all();

        (new Hook())->driver('github')->pullEvent();
    }
}
