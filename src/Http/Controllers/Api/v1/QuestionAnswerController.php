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
        $query = QuestionAnswer::orderBy('position');

        if ($category) {
            $query->whereCategoryId($category);
        }

        return QuestionAnswerResource::collection($query->paginate());
    }

    public function questions(int $number = 10, int $category = null)
    {
        $query = QuestionAnswer::orderBy('position')->take($number);

        if ($category) {
            $query->whereCategoryId($category);
        }

        return QuestionResource::collection($query->get());
    }

    public function answer(QuestionAnswer $questionAnswer)
    {
        return QuestionAnswerResource::make($questionAnswer);
    }
}
