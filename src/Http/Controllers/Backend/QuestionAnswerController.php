<?php

namespace Wepa\Faq\Http\Controllers\Backend;

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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $questionsAnswers = QuestionAnswerResource::collection(QuestionAnswer::orderBy('position')->paginate());

        return $this->render('Vendor/Faq/Backend/QuestionAnswer/Index', ['faq', 'question-answer'], compact(['questionsAnswers']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = CategoryResource::collection(Category::orderBy('position')->get())->resolve();

        return $this->render('Vendor/Faq/Backend/QuestionAnswer/Create', ['faq', 'question-answer'], compact(['categories']));
    }

    public function position(QuestionAnswer $questionAnswer, int $position): RedirectResponse|Application|Redirector
    {
        $questionAnswer->updatePosition($position);

        return redirect(route('admin.faq.questions-answers.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionAnswerRequest $request): Redirector|RedirectResponse|Application
    {
        $data = collect($request->all())
            ->merge([
                'position' => QuestionAnswer::nextPosition(),
            ])
            ->merge($request->translations)
            ->except(['translations'])
            ->toArray();

        $questionAnswer = QuestionAnswer::create($data);
        $questionAnswer->touch();

        return redirect(route('admin.faq.questions-answers.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuestionAnswer $questionAnswer): Response
    {
        $categories = CategoryResource::collection(Category::orderBy('position')->get())->resolve();
        $questionAnswer = QuestionAnswerResource::make($questionAnswer)->resolve();

        return $this->render('Vendor/Faq/Backend/QuestionAnswer/Edit', ['faq', 'question-answer'], compact(['questionAnswer', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionAnswerRequest $request, QuestionAnswer $questionAnswer): Redirector|RedirectResponse|Application
    {
        $questionAnswer->updateTimestamps();

        $data = collect($request->all())
            ->merge($request->translations)
            ->except(['translations'])
            ->toArray();

        $questionAnswer->update($data);

        return redirect(route('admin.faq.questions-answers.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionAnswer $questionAnswer): Redirector|RedirectResponse|Application
    {
        $questionAnswer->delete();

        return redirect(route('admin.faq.questions-answers.index'));
    }
}
