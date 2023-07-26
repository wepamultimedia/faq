<?php

namespace Wepa\Faq\Commands;

use Illuminate\Console\Command;

class FaqUpdateCommand extends Command
{
    public $description = 'Update faq module';

    public string $package = 'faq';

    public $signature = 'faq:update';

    protected array $vendor = [];

    public function handle(): int
    {
        $this->call('migrate');
        $this->call('vendor:publish', ['--tag' => 'faq', '--force' => true]);

        return self::SUCCESS;
    }
}
