<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakePackageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package {name? : The name of the package (e.g., cbs-reporting)} {--vendor=open-cbs : The vendor name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold a new package for the open-cbs application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name') ?? $this->ask('What is the name of the package? (e.g., cbs-reporting)');
        $name = Str::kebab($name);
        $vendor = $this->option('vendor');

        $fullPackageName = "$vendor/$name";
        $packagePath = base_path("packages/$vendor/$name");

        if (File::exists($packagePath)) {
            $this->error("Package directory already exists: $packagePath");
            return 1;
        }

        $this->info("Creating package: $fullPackageName at $packagePath");

        $directories = [
            'database/migrations',
            'database/seeders',
            'routes',
            'docs',
            'tests/Feature',
            'tests/Unit',
            'src/Actions',
            'src/DTOs',
            'src/Events',
            'src/Listeners',
            'src/Http/Controllers',
            'src/Models',
            'src/Observers',
            'src/Policies',
            'src/Repositories',
            'src/Services',
        ];

        foreach ($directories as $dir) {
            $path = "$packagePath/$dir";
            File::ensureDirectoryExists($path);
            File::put("$path/.gitkeep", '');
        }

        $this->createComposerJson($packagePath, $fullPackageName, $name, $vendor);
        $this->createReadme($packagePath, $fullPackageName);
        $this->createServiceProvider($packagePath, $name, $vendor);
        $this->createRoutes($packagePath);
        $this->createExampleTest($packagePath, $name, $vendor);

        $this->info("Package created successfully!");
        $this->line("Next steps:");
        $this->line("1. Run `composer update` to register the package.");
        $this->line("2. Add the service provider to `bootstrap/providers.php` if not auto-discovered.");
    }

    protected function createComposerJson($path, $fullName, $name, $vendor)
    {
        $namespace = $this->studlyNamespace($vendor) . '\\\\' . $this->studlyNamespace($name) . '\\\\';
        $providerClass = $namespace . $this->studlyNamespace($name) . 'ServiceProvider';

        $content = <<<JSON
{
    "name": "$fullName",
    "description": "Core Banking System - $name Module",
    "type": "library",
    "license": "MIT",
    "autoload": {
        "psr-4": {
            "$namespace": "src/"
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "$providerClass"
            ]
        }
    },
    "require": {
        "illuminate/support": "^12.0"
    }
}
JSON;
        File::put("$path/composer.json", $content);
    }

    protected function createReadme($path, $fullName)
    {
        $content = <<<MD
# $fullName

Core Banking System - $fullName Module

## Installation

```bash
composer require $fullName
```

## Usage

Documentation for this package.

## License

The MIT License (MIT).
MD;
        File::put("$path/README.md", $content);
    }

    protected function createServiceProvider($path, $name, $vendor)
    {
        $namespace = $this->studlyNamespace($vendor) . '\\' . $this->studlyNamespace($name);
        $className = $this->studlyNamespace($name) . 'ServiceProvider';

        $content = <<<PHP
<?php

namespace $namespace;

use Illuminate\Support\ServiceProvider;

class $className extends ServiceProvider
{
    public function register(): void
    {
        // \$this->mergeConfigFrom(__DIR__.'/../config/$name.php', '$name');
    }

    public function boot(): void
    {
        \$this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        \$this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // \$this->loadViewsFrom(__DIR__.'/../resources/views', '$name');
    }
}
PHP;
        File::put("$path/src/$className.php", $content);
    }

    protected function createRoutes($path)
    {
        $content = <<<PHP
<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    // Add your package routes here
});
PHP;
        File::put("$path/routes/api.php", $content);
    }

    protected function createExampleTest($path, $name, $vendor)
    {
        $content = <<<PHP
<?php

test('example', function () {
    expect(true)->toBeTrue();
});
PHP;
        File::put("$path/tests/Feature/ExampleTest.php", $content);
    }

    protected function studlyNamespace($value)
    {
        return Str::studly(Str::replace('-', ' ', $value));
    }
}
