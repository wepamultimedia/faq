<?php

namespace Wepa\Faq\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Wepa\Faq\Models\Category;
use Wepa\Faq\Models\QuestionAnswer;

/**
 * @extends Factory<QuestionAnswer>
 */
class QuestionAnswerFactory extends Factory
{
    protected $model = QuestionAnswer::class;

    protected static int $position = 1;

    public function configure()
    {
        self::$position = QuestionAnswer::nextPosition();

        return $this->afterMaking(function (QuestionAnswer $questionAnswer) {
            $category = Category::inRandomOrder()->first();
            $questionAnswer->category_id = $category->id;
            $questionAnswer->position = self::$position++;
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
            'question' => $this->faker->sentence,
            'answer' => $this->faker->text,
        ];
    }
}
