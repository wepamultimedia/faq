<?php

namespace Wepa\Faq\Http\Controllers\Backend;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Inertia\Response;
use Wepa\Core\Http\Controllers\Backend\InertiaController;
use Wepa\Faq\Http\Requests\CategoryRequest;
use Wepa\Faq\Http\Resources\CategoryResource;
use Wepa\Faq\Models\Category;

class CategoryController extends InertiaController
{
    public string $packageName = 'faq';

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $categories = CategoryResource::collection(Category::orderBy('position')->paginate());

        return $this->render('Vendor/Faq/Backend/Category/Index', ['faq', 'category'], compact(['categories']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return $this->render('Vendor/Faq/Backend/Category/Create', ['faq', 'category']);
    }

    public function position(Category $category, int $position): RedirectResponse|Application|Redirector
    {
        $category->updatePosition($position);

        return redirect(route('admin.faq.categories.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): Redirector|RedirectResponse|Application
    {
        $data = collect($request->all())
            ->merge([
                'position' => Category::nextPosition(),
            ])
            ->merge($request->translations)
            ->except(['translations'])
            ->toArray();

        $category = Category::create($data);
        $category->touch();

        return redirect(route('admin.faq.categories.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): Response
    {
        $category = CategoryResource::make($category)->resolve();

        return $this->render('Vendor/Faq/Backend/Category/Edit', ['faq', 'category'], compact(['category']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category): Redirector|RedirectResponse|Application
    {
        $category->updateTimestamps();

        $params = collect($request->all())
            ->merge($request->translations)
            ->except(['translations'])
            ->toArray();

        $category->update($params);

        return redirect(route('admin.faq.categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): Redirector|RedirectResponse|Application
    {
        $category->delete();

        return redirect(route('admin.faq.categories.index'));
    }
}
