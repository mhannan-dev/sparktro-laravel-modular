<?php

namespace Sparktro\LaravelModular\Console;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ModuleMigrateCommand extends Command
{
    protected $signature = 'module:migrate {module}';
    protected $description = 'Run the migrations from a specific module';

    public function handle(): void
    {
        $module = $this->argument('module');
        $migrationPath = base_path("modules/{$module}/Database/Migrations");

        if (!File::isDirectory($migrationPath)) {
            $this->error("Migration path not found for module: {$module}");
            return;
        }

        $this->info("Running migrations for module: {$module}");
        Artisan::call('migrate', [
            '--path' => str_replace(base_path() . '/', '', $migrationPath),
            '--force' => true,
        ]);

        $this->line(Artisan::output());
    }
}
