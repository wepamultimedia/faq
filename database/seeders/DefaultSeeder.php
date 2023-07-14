<?php

namespace Wepa\Faq\Database\seeders;

use Illuminate\Database\Seeder;
use Wepa\Core\Models\Menu;
use Wepa\Faq\Models\Category;

class DefaultSeeder extends Seeder
{
    public function run()
    {
        Menu::loadPackageItems('faq');

        if (! Category::whereTranslation('name', 'General')->exists()) {
            Category::factory()->default()->create();
        }
    }
}
