<?php

use Wepa\Faq\Http\Controllers\Api\v1\QuestionAnswerController;

Route::prefix('api/v1/faq')->middleware(['api'])->group(function () {
    Route::get('questions-answers/{locale}/{category?}', [QuestionAnswerController::class, 'index'])->name('api.v1.faq.questions-answers.index');
    Route::get('questions-answers/questions/{locale}/{number}/{category?}', [QuestionAnswerController::class, 'questions'])->name('api.v1.faq.questions-answers.questions');
    Route::get('questions-answers/answer/{locale}/{questionAnswer}', [QuestionAnswerController::class, 'answer'])->name('api.v1.faq.questions-answers.answer');
});
