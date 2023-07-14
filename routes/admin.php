<?php

use Wepa\Faq\Http\Controllers\Backend\CategoryController;
use Wepa\Faq\Http\Controllers\Backend\QuestionAnswerController;

Route::prefix('admin/faq')->middleware(['web', 'auth:sanctum', 'core.backend'])->group(function () {
    Route::put('categories/position/{category}/{position}', [CategoryController::class, 'position'])
        ->name('admin.faq.categories.position');
    Route::resource('categories', CategoryController::class)->names('admin.faq.categories');

    Route::resource('questions-answers', QuestionAnswerController::class)
        ->parameter('questions-answers', 'questionAnswer')
        ->names('admin.faq.questions-answers');

    Route::put('questions-answers/position/{questionAnswer}/{position}', [QuestionAnswerController::class, 'position'])
        ->name('admin.faq.questions-answers.position');
});
