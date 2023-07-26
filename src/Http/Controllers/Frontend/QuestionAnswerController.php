<?php

namespace Wepa\Faq\Http\Controllers\Frontend;

use Inertia\Response;
use Wepa\Core\Http\Controllers\Backend\InertiaController;
use Wepa\Faq\Http\Resources\QuestionAnswerResource;
use Wepa\Faq\Models\QuestionAnswer;

class QuestionAnswerController extends InertiaController
{
    public string $packageName = 'faq';

    public function index(): Response
    {
        $questionsAnswers = QuestionAnswerResource::collection(QuestionAnswer::orderBy('position')->paginate());

        return $this->render('Vendor/Faq/Frontend/QuestionAnswer/Index', ['faq', 'question-answer'], compact(['questionsAnswers']));
    }

    public function components(): Response
    {
        $questionsAnswers = QuestionAnswerResource::collection(QuestionAnswer::orderBy('position')->paginate());

        return $this->render('Vendor/Faq/Frontend/FaqComponents', ['faq', 'question-answer'], compact(['questionsAnswers']));
    }
}
