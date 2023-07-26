<?php

namespace Wepa\Faq\Http\Controllers\Backend;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function index(Request $request)
    {
        $query = QuestionAnswer::orderBy('position')->when($request->search, function ($query, $search) {
            $query->whereTranslationLike('question', "%$search%");
        });

        $questionsAnswers = QuestionAnswerResource::collection($query->paginate());

        return $this->render('Vendor/Faq/Backend/QuestionAnswer/Index', ['faq', 'question-answer'], compact(['questionsAnswers']));
    }

    public function position(QuestionAnswer $questionAnswer, int $position): RedirectResponse|Application|Redirector
    {
        $questionAnswer->updatePosition($position);

        return back();
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

        return redirect(session()->has('backUrl')
            ? session()->get('backUrl')
            : route('admin.faq.questions-answers.index'));
    }

    public function create(): Response
    {
        session()->flash('backUrl', url()->previous());
        $categories = CategoryResource::collection(Category::orderBy('position')->get())->resolve();

        return $this->render('Vendor/Faq/Backend/QuestionAnswer/Create', ['faq', 'question-answer'], compact(['categories']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuestionAnswer $questionAnswer): Response
    {
        session()->flash('backUrl', url()->previous());
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

        return redirect(session()->has('backUrl')
            ? session()->get('backUrl')
            : route('admin.faq.questions-answers.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionAnswer $questionAnswer): Redirector|RedirectResponse|Application
    {
        $questionAnswer->updatePosition(QuestionAnswer::lastPosition());
        $questionAnswer->delete();

        return back();
    }
}
