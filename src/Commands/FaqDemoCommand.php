<?php

namespace Wepa\Faq\Commands;

use Illuminate\Console\Command;

class FaqDemoCommand extends Command
{
    public $description = 'Demo faq module';

    public string $package = 'faq';

    public $signature = 'faq:demo';

    protected array $vendor = [];

    public function handle(): int
    {
        return self::SUCCESS;
    }
}
