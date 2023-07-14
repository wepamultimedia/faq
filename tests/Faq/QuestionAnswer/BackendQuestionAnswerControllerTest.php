<?php

namespace Tests\Feature\Faq\QuestionAnswer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Inertia\Testing\AssertableInertia;
use Tests\BaseTestCase;
use Wepa\Faq\Database\seeders\DefaultSeeder;
use Wepa\Faq\Models\Category;
use Wepa\Faq\Models\CategoryTranslation;
use Wepa\Faq\Models\QuestionAnswer;
use Wepa\Faq\Models\QuestionAnswerTranslation;

class BackendQuestionAnswerControllerTest extends BaseTestCase
{
    public function test_question_answer_factory_successfully()
    {
        Category::factory(20)->create();
        QuestionAnswer::factory(20)->create();

        $this->assertDatabaseCount((new QuestionAnswer())->getTable(), 20);
        $this->assertDatabaseCount((new QuestionAnswerTranslation())->getTable(), 20);
    }

    public function test_store_question_answer()
    {
        Category::factory(1)->create();
        $category = Category::first();

        $data = ['category_id' => $category->id, 'translations' => ['en' => ['question' => 'Test question', 'answer' => 'Test answer']]];

        $this->actingAs($this->superAdminUser())
            ->post(route('admin.faq.questions-answers.store'), $data)
            ->assertRedirectToRoute('admin.faq.questions-answers.index');

        $this->assertDatabaseHas((new QuestionAnswerTranslation())->getTable(), ['question' => 'Test question', 'answer' => 'Test answer']);
    }

    public function test_update_question_answer()
    {
        Category::factory(1)->create();
        $category = Category::first();

        $dataStore = ['category_id' => $category->id, 'translations' => ['en' => ['question' => 'Test question', 'answer' => 'Test answer']]];
        $dataUpdate = ['category_id' => $category->id, 'translations' => ['en' => ['question' => 'Test question updated', 'answer' => 'Test answer updated']]];

        $this->actingAs($this->superAdminUser())
            ->post(route('admin.faq.questions-answers.store'), $dataStore);

        $questionAnswer = QuestionAnswer::whereTranslation('question', 'Test question')->first();

        $this->actingAs($this->superAdminUser())
            ->put(route('admin.faq.questions-answers.update', ['questionAnswer' => $questionAnswer->id]), $dataUpdate)
            ->assertRedirectToRoute('admin.faq.questions-answers.index');

        $this->assertDatabaseHas((new QuestionAnswerTranslation())->getTable(), ['question' => 'Test question updated', 'answer' => 'Test answer updated']);
    }

    public function test_destroy_question_answer()
    {
        Category::factory(1)->create();
        $category = Category::first();
        $dataStore = ['category_id' => $category->id, 'translations' => ['en' => ['question' => 'Test question', 'answer' => 'Test answer']]];

        $this->actingAs($this->superAdminUser())->post(route('admin.faq.questions-answers.store'), $dataStore);
        $questionAnswer = QuestionAnswer::whereTranslation('question', 'Test question')->first();

        $this->actingAs($this->superAdminUser())
            ->delete(route('admin.faq.questions-answers.destroy', ['questionAnswer' => $questionAnswer->id]))
            ->assertRedirectToRoute('admin.faq.questions-answers.index');


        $this->assertDatabaseMissing((new QuestionAnswerTranslation())->getTable(), ['question' => 'Test question']);
    }

    public function test_question_answer_index()
    {
        Category::factory(10)->create();
        QuestionAnswer::factory(10)->create();

        $category = Category::orderBy('position')->first();
        $questionAnswer = QuestionAnswer::orderBy('position')->first();

        $this->actingAs($this->superAdminUser())
            ->get(route('admin.faq.questions-answers.index'))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Vendor/Faq/Backend/QuestionAnswer/Index')
                ->has('questionsAnswers')
                ->where('questionsAnswers.data.0.question', $questionAnswer->question)
            );
    }

    public function test_question_answer_crete()
    {
        $this->actingAs($this->superAdminUser())
            ->get(route('admin.faq.questions-answers.create'))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Vendor/Faq/Backend/QuestionAnswer/Create')
            );
    }

    public function test_question_answer_edit()
    {
        Category::factory(10)->create();
        QuestionAnswer::factory(10)->create();

        $questionAnswer = QuestionAnswer::first();

        $this->actingAs($this->superAdminUser())
            ->get(route('admin.faq.questions-answers.edit', ['questionAnswer' => $questionAnswer->id]))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Vendor/Faq/Backend/QuestionAnswer/Edit')
                ->has('questionAnswer')
                ->where('questionAnswer.translations.en.question', $questionAnswer->question)
            );
    }

    public function test_question_answer_position()
    {
        Category::factory(10)->create();
        QuestionAnswer::factory(10)->create();

        $questionAnswer = QuestionAnswer::first();

        $this->actingAs($this->superAdminUser())
            ->put(route('admin.faq.questions-answers.position', ['questionAnswer' => $questionAnswer->id, 'position' => 8]))
            ->assertRedirectToRoute('admin.faq.questions-answers.index');

        $this->assertDatabaseHas((new QuestionAnswer())->getTable(), ['id' => $questionAnswer->id, 'position' => 8]);
    }
}
