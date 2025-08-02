<?php

namespace Sparktro\LaravelModular\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MakeMigrationCommand extends Command
{
    protected $signature = 'module:make-migration {module} {name}';
    protected $description = 'Create a new migration for a module';

    public function handle()
    {
        $module = $this->argument('module');
        $name = $this->argument('name');

        $path = "modules/{$module}/Database/Migrations";

        File::ensureDirectoryExists(base_path($path));

        Artisan::call('make:migration', [
            'name' => $name,
            '--path' => $path,
        ]);

        $this->info("✅ Migration created for module {$module}");
    }
}
