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
    protected $signature = 'make:package {name? : The name of the package (e.g., cbs-reporting)}';

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

        $vendor = 'open-cbs';
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
            'src/Actions',
            'src/DTOs',
            'src/Events',
            'src/Http/Controllers',
            'src/Models',
            'src/Observers',
            'src/Policies',
            'src/Repositories',
            'src/Services',
            'src/Providers',
        ];

        foreach ($directories as $dir) {
            $path = "$packagePath/$dir";
            File::ensureDirectoryExists($path);
            File::put("$path/.gitkeep", '');
        }

        $this->createComposerJson($packagePath, $fullPackageName, $name, $vendor);
        $this->createReadme($packagePath, $fullPackageName);
        $this->createServiceProvider($packagePath, $name, $vendor);

        $this->info("Package created successfully!");
        $this->line("Next steps:");
        $this->line("1. Run `composer update` to register the package.");
        $this->line("2. Add the service provider to `config/app.php` or `bootstrap/providers.php` if not auto-discovered.");
    }

    protected function createComposerJson($path, $fullName, $name, $vendor)
    {
        $namespace = $this->studlyNamespace($vendor) . '\\\\' . $this->studlyNamespace($name) . '\\\\';
        $providerClass = $namespace . $this->studlyNamespace($name) . 'ServiceProvider';
        // unescape needed for json file, but strictly for writing:
        // Double backslash in php string = single backslash in output. 
        // We need double backslash in JSON string. so we need 4 backslashes in PHP string.

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
    public function register()
    {
        // Register services
        // \$this->mergeConfigFrom(__DIR__.'/../config/$name.php', '$name');
    }

    public function boot()
    {
        // \$this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        // \$this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // \$this->loadViewsFrom(__DIR__.'/../resources/views', '$name');
    }
}
PHP;
        // ensure Providers directory exists (it should from loop)
        File::put("$path/src/$className.php", $content);
        // Wait, user asked for src/, events etc. AND src/Providers. 
        // usually main provider is in src/ or src/Providers/. 
        // The prompt said "service provider etc" in "src". I'll put it in src/ directory directly for simplicity as per current convention in this project, 
        // looking at cbs-cif/src/CbsCifServiceProvider.php from previous turns.
        // Wait, let me check the file structure of cbs-cif again.
    }

    protected function studlyNamespace($value)
    {
        return Str::studly(Str::replace('-', ' ', $value));
    }
}
