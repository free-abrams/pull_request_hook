<?php

namespace App\Service\Gitee;

use App\Service\Git;

class GiteeService implements Git
{

    private $app;

    private $dirver;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function driver($name = null)
    {
        if ($name === null) {
            $name = $this->getDefaultDriver();
        }

        $this->dirver = $name;
    }

    public function getDefaultDriver()
    {
        return config('hook.driver.default');
    }

    public function pullEvent()
    {
        // TODO: Implement pullEvent() method.
    }

    public function pullRequestEvent()
    {
        // TODO: Implement pullRequestEvent() method.
    }
}
