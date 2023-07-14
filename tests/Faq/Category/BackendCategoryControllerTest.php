<?php

namespace Tests\Feature\Faq\Category;

use Inertia\Testing\AssertableInertia;
use Tests\BaseTestCase;
use Wepa\Faq\Database\seeders\DefaultSeeder;
use Wepa\Faq\Models\Category;
use Wepa\Faq\Models\CategoryTranslation;

class BackendCategoryControllerTest extends BaseTestCase
{
    public function test_category_factory_successfully()
    {
        Category::factory(20)->create();

        $this->assertDatabaseCount((new Category())->getTable(), 20);
        $this->assertDatabaseCount((new CategoryTranslation())->getTable(), 20);
    }

    public function test_category_default_seed()
    {
        $this->seed(DefaultSeeder::class);

        $this->assertDatabaseHas((new CategoryTranslation())->getTable(), [
            'name' => 'General',
        ]);
    }

    public function test_store_category()
    {
        $data = ['translations' => ['en' => ['name' => 'Test']]];
        $this->actingAs($this->superAdminUser())
            ->post(route('admin.faq.categories.store'), $data)
            ->assertRedirectToRoute('admin.faq.categories.index');

        $this->assertDatabaseHas((new CategoryTranslation())->getTable(), ['name' => 'Test']);
    }

    public function test_update_category()
    {
        $dataStore = ['translations' => ['en' => ['name' => 'Test']]];
        $dataUpdate = ['translations' => ['en' => ['name' => 'Test Updated']]];

        $this->actingAs($this->superAdminUser())->post(route('admin.faq.categories.store'), $dataStore);

        $category = Category::whereTranslation('name', 'Test')->first();
        $this->actingAs($this->superAdminUser())
            ->put(route('admin.faq.categories.update', ['category' => $category->id]), $dataUpdate)
            ->assertRedirectToRoute('admin.faq.categories.index');

        $this->assertDatabaseHas((new CategoryTranslation())->getTable(), ['name' => 'Test Updated']);
    }

    public function test_destroy_category()
    {
        $dataStore = ['translations' => ['en' => ['name' => 'Test']]];

        $this->actingAs($this->superAdminUser())->post(route('admin.faq.categories.store'), $dataStore);
        $category = Category::whereTranslation('name', 'Test')->first();

        $this->actingAs($this->superAdminUser())->delete(route('admin.faq.categories.destroy', ['category' => $category->id]));

        $this->assertDatabaseMissing((new CategoryTranslation())->getTable(), ['name' => 'Test']);
    }

    public function test_category_index()
    {
        $this->seed(DefaultSeeder::class);

        $this->actingAs($this->superAdminUser())
            ->get(route('admin.faq.categories.index'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Vendor/Faq/Backend/Category/Index')
                ->has('categories')
                ->where('categories.data.0.name', 'General')
            );
    }

    public function test_category_create()
    {
        $this->actingAs($this->superAdminUser())
            ->get(route('admin.faq.categories.create'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Vendor/Faq/Backend/Category/Create')
            );
    }

    public function test_category_edit()
    {
        $this->seed(DefaultSeeder::class);
        $category = Category::first();

        $this->actingAs($this->superAdminUser())
            ->get(route('admin.faq.categories.edit', ['category' => $category->id]))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Vendor/Faq/Backend/Category/Edit')
                ->has('category')
                ->where('category.name', $category->name)
            );
    }

    public function test_category_position()
    {
        Category::factory(10)->create();

        $category = Category::orderBy('position')->first();

        $this->actingAs($this->superAdminUser())
            ->put(route('admin.faq.categories.position', ['category' => $category->id, 'position' => 8]))
            ->assertRedirectToRoute('admin.faq.categories.index');

        $this->assertDatabaseHas((new Category())->getTable(), ['id' => $category->id, 'position' => 8]);
    }
}
