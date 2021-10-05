<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CatchAllOptionsRequestsProvider extends ServiceProvider
{

    public function register()
    {
        $requests = app('request');

        if ($requests->isMethod('OPTIONS')) {
            app()->options($requests->path(), function () {
                return response('', 200);
            });;
        }
    }
}
