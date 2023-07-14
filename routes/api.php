<?php

use Wepa\Faq\Http\Controllers\Api\v1\QuestionAnswerController;

Route::prefix('api/v1/faq')->middleware(['api'])->group(function () {
    Route::get('questions-answers', [QuestionAnswerController::class, 'index'])->name('api.v1.faq.questions-answers.index');
    Route::get('questions-answers/questions/{category?}', [QuestionAnswerController::class, 'questions'])->name('api.v1.faq.questions-answers.questions');
    Route::get('questions-answers/answer/{questionAnswer}', [QuestionAnswerController::class, 'answer'])->name('api.v1.faq.questions-answers.answer');
});
