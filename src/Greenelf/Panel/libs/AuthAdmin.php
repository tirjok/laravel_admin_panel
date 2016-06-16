<?php

namespace Greenelf\Panel\libs;

class AuthAdmin
{
    public function checkLoggedIn()
    {
        $temp = config('auth.model');
        config(['auth.model' => 'Greenelf\Panel\Admin']);
        $access = !\Auth::guard('panel')->guest();
        config(['auth.model' => $temp]);
        return $access;
    }
}

