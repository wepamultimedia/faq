<?php

namespace Wepa\Faq\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Wepa\Core\Models\Menu;

class FaqInstallCommand extends Command
{
    public $description = 'Install faq module';

    public string $package = 'faq';

    public $signature = 'faq:install';

    protected array $vendor = [];

    public function handle(): int
    {
        $this->call('migrate');
        $this->call('vendor:publish', ['--tag' => 'faq', '--force' => true]);

        Menu::loadPackageItems($this->package);

        $this->call('db:seed', ['class' => 'Wepa\Faq\Database\Seeders\DefaultSeeder']);

        $process = Process::fromShellCommandline('npm i -D @ckeditor/ckeditor5-vue wepa-ckeditor5-filemanager');
        $process->run();
        $this->info($process->getOutput());

        return self::SUCCESS;
    }
}
