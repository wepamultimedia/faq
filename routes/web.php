<?php

use Wepa\Faq\Http\Controllers\Frontend\QuestionAnswerController;

Route::prefix('faq')->middleware(['web'])->group(function(){
   Route::get('components', [QuestionAnswerController::class, 'components']);
});
