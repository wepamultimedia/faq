<?php

namespace Wepa\Faq\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Wepa\Faq\Http\Resources\QuestionAnswerResource;
use Wepa\Faq\Http\Resources\QuestionResource;
use Wepa\Faq\Models\Category;
use Wepa\Faq\Models\QuestionAnswer;

class QuestionAnswerController extends Controller
{
    public function index(string $locale, Category $category = null)
    {
        app()->setLocale($locale);

        $query = QuestionAnswer::orderBy('position');

        if ($category) {
            $query->whereCategoryId($category);
        }

        return QuestionAnswerResource::collection($query->paginate());
    }

    public function questions(string $locale, int $number, int $category = null)
    {
        app()->setLocale($locale);
        $query = QuestionAnswer::orderBy('position')->take($number);

        if ($category) {
            $query->whereCategoryId($category);
        }

        return QuestionResource::collection($query->get());
    }

    public function answer(string $locale, QuestionAnswer $questionAnswer)
    {
        app()->setLocale($locale);

        return QuestionAnswerResource::make($questionAnswer);
    }
}
