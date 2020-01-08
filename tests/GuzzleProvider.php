<?php

namespace Calchen\LaravelDingtalkRobot\Test;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\ServiceProvider;

class GuzzleProvider extends ServiceProvider
{
    /**
     * 注册服务
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('guzzle', function ($app) {
            return new GuzzleClient([
                'timeout' => 5.0,
            ]);
        });
    }
}
