<?php

namespace Wepa\Faq;

use Database\Seeders\DatabaseSeeder;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Wepa\Faq\Commands\FaqDemoCommand;
use Wepa\Faq\Commands\FaqInstallCommand;
use Wepa\Faq\Commands\FaqUninstallCommand;
use Wepa\Faq\Commands\FaqUpdateCommand;
use Wepa\Faq\Database\seeders\DefaultSeeder;

class FaqServiceProvider extends PackageServiceProvider
{
    public function bootingPackage()
    {
        $this->hasSeeders([DefaultSeeder::class]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Pages
        $this->publishes([
            __DIR__.'/../resources/js/Pages' => resource_path('js/Pages/Vendor/Faq'),
        ], ['faq', 'faq-pages']);

        // Components
        $this->publishes([
            __DIR__.'/../resources/js/Components' => resource_path('js/Vendor/Faq'),
        ], ['faq', 'faq-components']);

        $this->publishes([
            __DIR__.'/../tests/Unit' => base_path('tests/Unit/Faq'),
            __DIR__.'/../tests/Feature' => base_path('tests/Feature/Faq'),
        ], ['faq-tests']);
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('faq')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasRoutes(['web', 'admin', 'api'])
            ->hasMigration('create_faq_table')
            ->hasCommands([
                FaqInstallCommand::class,
                FaqUninstallCommand::class,
                FaqDemoCommand::class,
                FaqUpdateCommand::class,
            ]);
    }

    protected function hasSeeders(array $seeders): void
    {
        $this->callAfterResolving(DatabaseSeeder::class,
            function ($cb) use ($seeders) {
                $cb->call($seeders);
            });
    }
}
