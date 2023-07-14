<?php

namespace Wepa\Faq\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Wepa\Faq\Models\Category;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected static int $position = 1;

    protected $model = Category::class;

    public function configure()
    {
        self::$position = Category::nextPosition();

        return $this->afterMaking(function (Category $category) {
            $category->position = self::$position++;
        });
    }

    public function default()
    {
        return $this->state(function () {
            return [
                'name' => 'General',
            ];
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
