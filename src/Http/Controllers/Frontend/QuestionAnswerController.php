<?php

namespace Wepa\Faq\Http\Controllers\Frontend;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Inertia\Response;
use Wepa\Core\Http\Controllers\Backend\InertiaController;
use Wepa\Faq\Http\Requests\QuestionAnswerRequest;
use Wepa\Faq\Http\Resources\CategoryResource;
use Wepa\Faq\Http\Resources\QuestionAnswerResource;
use Wepa\Faq\Models\Category;
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
