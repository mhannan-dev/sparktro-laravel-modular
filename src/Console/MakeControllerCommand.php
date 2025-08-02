<?php

namespace Sparktro\LaravelModular\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeControllerCommand extends Command
{
    protected $signature = 'module:make-controller {module} {name}';
    protected $description = 'Create a new controller in a module';

    public function handle()
    {
        $module = $this->argument('module');
        $name = Str::studly($this->argument('name')) . 'Controller';

        $modulePath = base_path("modules/{$module}/Http/Controllers");
        $namespace = "Modules\\{$module}\\Http\\Controllers";

        File::ensureDirectoryExists($modulePath);
        $filePath = "{$modulePath}/{$name}.php";

        if (File::exists($filePath)) {
            $this->error("❌ Controller already exists: {$name}");
            return;
        }

        File::put($filePath, <<<PHP
<?php

namespace {$namespace};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class {$name} extends Controller
{
    public function index()
    {
        //
    }
}
PHP);

        $this->info("✅ {$name} created in module {$module}");
    }
}
