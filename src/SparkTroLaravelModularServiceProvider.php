<?php

namespace Sparktro\LaravelModular;

use Illuminate\Support\ServiceProvider;
use Sparktro\LaravelModular\Console\MakeModelCommand;
use Sparktro\LaravelModular\Console\MakeModuleCommand;
use Sparktro\LaravelModular\Console\MakeRequestCommand;
use Sparktro\LaravelModular\Console\MakeMigrationCommand;
use Sparktro\LaravelModular\Console\ModuleMigrateCommand;
use Sparktro\LaravelModular\Console\MakeControllerCommand;

class SparkTroLaravelModularServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadModules();

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeModuleCommand::class,
                MakeRequestCommand::class,
                MakeControllerCommand::class,
                MakeModelCommand::class,
                MakeMigrationCommand::class,
                ModuleMigrateCommand::class,
            ]);
        }
    }

    protected function loadModules()
    {
        $modulesPath = base_path('modules');

        if (!is_dir($modulesPath)) {
            return;
        }

        foreach (scandir($modulesPath) as $module) {
            if ($module === '.' || $module === '..') {
                continue;
            }

            $serviceProvider = "Modules\\$module\\Providers\\{$module}ServiceProvider";

            if (class_exists($serviceProvider)) {
                $this->app->register($serviceProvider);
            } else {
                logger()->warning("Module service provider not found: $serviceProvider");
            }
        }
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
