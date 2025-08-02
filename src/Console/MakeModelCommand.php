<?php

namespace Sparktro\LaravelModular\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MakeModelCommand extends Command
{
    protected $signature = 'module:make-model {module} {name}
        {--m|migration : Create a new migration file for the model}';

    protected $description = 'Create a new Eloquent model in a module (with optional migration)';

    public function handle()
    {
        $module = $this->argument('module');
        $name = Str::studly($this->argument('name'));

        $modelPath = base_path("modules/{$module}/Models");
        $namespace = "Modules\\{$module}\\Models";
        $filePath = "{$modelPath}/{$name}.php";

        File::ensureDirectoryExists($modelPath);

        if (File::exists($filePath)) {
            $this->error("❌ Model already exists: {$filePath}");
            return;
        }

        File::put($filePath, <<<PHP
<?php

namespace {$namespace};

use Illuminate\Database\Eloquent\Model;

class {$name} extends Model
{
    protected \$guarded = [];
}
PHP);

        $this->info("✅ Model created: modules/{$module}/Models/{$name}.php");

        if ($this->option('migration')) {
            $tableName = Str::snake(Str::pluralStudly($name));
            $migrationName = "create_{$tableName}_table";
            $migrationPath = "modules/{$module}/Database/Migrations";

            File::ensureDirectoryExists(base_path($migrationPath));

            Artisan::call('make:migration', [
                'name' => $migrationName,
                '--path' => $migrationPath,
            ]);

            $this->info("📦 Migration created: {$migrationName}");
        }
    }
}
