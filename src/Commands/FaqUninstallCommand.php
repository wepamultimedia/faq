<?php

namespace Wepa\Faq\Commands;

use Illuminate\Console\Command;
use Wepa\Core\Models\Menu;

class FaqUninstallCommand extends Command
{
    public $description = 'Uninstall faq module';

    public string $package = 'faq';

    public $signature = 'faq:uninstall';

    protected array $vendor = [];

    public function handle(): int
    {
        Menu::removePackageItems($this->package);

        return self::SUCCESS;
    }
}
