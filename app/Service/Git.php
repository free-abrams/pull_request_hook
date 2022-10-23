<?php

namespace App\Service;

interface Git
{
    public function getDefaultDriver();

    public function pullEvent();

    public function pullRequestEvent();
}
