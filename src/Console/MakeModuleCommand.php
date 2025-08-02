<?php

namespace Sparktro\LaravelModular\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class MakeModuleCommand extends Command
{
    protected $signature = 'module:make {name}';
    protected $description = 'Create a new module in modules/ directory';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $modulePath = base_path("modules/{$name}");

        if (is_dir($modulePath)) {
            $this->error("Module {$name} already exists!");
            return;
        }

        $fs = new Filesystem();

        // Create base folders
        $fs->makeDirectory($modulePath, 0755, true);
        $fs->makeDirectory("{$modulePath}/Http/Controllers", 0755, true);
        $fs->makeDirectory("{$modulePath}/Providers", 0755, true);
        $fs->makeDirectory("{$modulePath}/Routes", 0755, true);
        $fs->makeDirectory("{$modulePath}/Models", 0755, true);
        $fs->makeDirectory("{$modulePath}/Views", 0755, true);
        $fs->makeDirectory("{$modulePath}/Database/Migrations", 0755, true);

        // Generate ServiceProvider
        $providerContent = <<<PHP
<?php

namespace Modules\\{$name}\\Providers;

use Illuminate\Support\ServiceProvider;

class {$name}ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \$this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        \$this->loadViewsFrom(__DIR__ . '/../Views', '{$name}');
        \$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        \Log::info("{$name} module loaded.");
    }

    public function register()
    {
        //
    }
}
PHP;

        $fs->put("{$modulePath}/Providers/{$name}ServiceProvider.php", $providerContent);

        // Create controller
        $controllerContent = <<<PHP
<?php

namespace Modules\\{$name}\\Http\\Controllers;

use Illuminate\Routing\Controller;

class {$name}Controller extends Controller
{
    public function index()
    {
        return view('{$name}::index');
    }
}
PHP;

        $fs->put("{$modulePath}/Http/Controllers/{$name}Controller.php", $controllerContent);

        // Create routes
        $routeContent = <<<PHP
<?php

use Illuminate\Support\Facades\Route;
use Modules\\{$name}\\Http\\Controllers\\{$name}Controller;

Route::get('/{$name}', [{$name}Controller::class, 'index']);
PHP;

        $fs->put("{$modulePath}/Routes/web.php", $routeContent);

        // Create view
        $fs->put("{$modulePath}/Views/index.blade.php", "<h1>{$name} Module Working!</h1>");

        // Create default migration file
        $timestamp = date('Y_m_d_His');
        $migrationName = strtolower($name);
        $migrationFile = "{$timestamp}_create_{$migrationName}_table.php";

        $migrationContent = <<<PHP
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('{$migrationName}', function (Blueprint \$table) {
            \$table->id();
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('{$migrationName}');
    }
};
PHP;

        $fs->put("{$modulePath}/Database/Migrations/{$migrationFile}", $migrationContent);

        $this->info("Module {$name} created successfully with migration.");
    }
}
