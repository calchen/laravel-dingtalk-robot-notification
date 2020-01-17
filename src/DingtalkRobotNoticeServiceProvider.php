<?php

namespace Calchen\LaravelDingtalkRobot;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class DingtalkRobotNoticeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * 处理配置项.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath($raw = __DIR__.'/../config/dingtalk_robot.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                $source => config_path('dingtalk_robot.php'),
            ]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('dingtalk_robot');
        }

        $this->mergeConfigFrom($source, 'dingtalk_robot');
    }

    /**
     * 注册服务
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DingtalkRobot::class, function ($app) {
            return new DingtalkRobot();
        });
    }
}
