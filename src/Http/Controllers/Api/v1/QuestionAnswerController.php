<?php

namespace Wepa\Faq\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Wepa\Faq\Http\Resources\QuestionAnswerResource;
use Wepa\Faq\Http\Resources\QuestionResource;
use Wepa\Faq\Models\Category;
use Wepa\Faq\Models\QuestionAnswer;

class QuestionAnswerController extends Controller
{
    public function index(Category $category = null)
    {
        return QuestionAnswerResource::collection(QuestionAnswer::orderBy('position')->paginate());
    }

    public function questions()
    {
        return QuestionResource::collection(QuestionAnswer::orderBy('position')->paginate());
    }

    public function answer(QuestionAnswer $questionAnswer)
    {
        return $questionAnswer->answer;
    }
}
