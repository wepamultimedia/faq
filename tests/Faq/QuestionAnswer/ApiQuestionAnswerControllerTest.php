<?php

namespace Tests\Feature\Faq\QuestionAnswer;

use Tests\BaseTestCase;
use Wepa\Faq\Http\Resources\QuestionAnswerResource;
use Wepa\Faq\Http\Resources\QuestionResource;
use Wepa\Faq\Models\Category;
use Wepa\Faq\Models\QuestionAnswer;

class ApiQuestionAnswerControllerTest extends BaseTestCase
{
    public function test_question_answer_index()
    {
        Category::factory(10)->create();
        QuestionAnswer::factory(10)->create();

        $questionsAnswers = QuestionAnswerResource::collection(QuestionAnswer::orderBy('position')->get())->resolve();

        $response = $this->actingAs($this->superAdminUser())
            ->get(route('api.v1.faq.questions-answers.index'))
            ->assertOk();

        $this->assertEquals($response['data'], $questionsAnswers);
    }

    public function test_questions_index()
    {
        Category::factory(10)->create();
        QuestionAnswer::factory(10)->create();

        $questionsAnswers = QuestionResource::collection(QuestionAnswer::orderBy('position')->get())
            ->resolve();

        $response = $this->actingAs($this->superAdminUser())
            ->get(route('api.v1.faq.questions-answers.questions'))
            ->assertOk();

        $this->assertEquals($response['data'], $questionsAnswers);
    }

    public function test_answer()
    {
        Category::factory(10)->create();
        QuestionAnswer::factory(10)->create();

        $questionAnswer = QuestionAnswer::first();

        $response = $this->actingAs($this->superAdminUser())
            ->get(route('api.v1.faq.questions-answers.answer', ['questionAnswer' => $questionAnswer->id]))
            ->assertOk();

        $this->assertEquals($response->content(), $questionAnswer->answer);
    }
}
