<?php

namespace Sparktro\LaravelModular\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRequestCommand extends Command
{
    protected $signature = 'module:make-request {module} {name}';
    protected $description = 'Create a new FormRequest class for a specific module';

    public function handle(): void
    {
        $module = $this->argument('module');
        $name = $this->argument('name');

        $requestClass = Str::studly($name);
        $modulePath = base_path("modules/{$module}");

        if (!File::exists($modulePath)) {
            $this->error("Module [{$module}] does not exist.");
            return;
        }

        $requestPath = "{$modulePath}/Http/Requests/{$requestClass}.php";
        $namespace = "Modules\\{$module}\\Http\\Requests";

        if (File::exists($requestPath)) {
            $this->error("Request already exists: {$requestClass}");
            return;
        }

        File::ensureDirectoryExists("{$modulePath}/Http/Requests");

        File::put($requestPath, <<<PHP
<?php

namespace {$namespace};

use Illuminate\Foundation\Http\FormRequest;

class {$requestClass} extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Add your validation rules
        ];
    }
}
PHP);

        $this->info("✅ {$requestClass} created successfully in module {$module}!");
    }
}
