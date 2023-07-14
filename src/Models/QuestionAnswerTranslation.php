<?php

namespace Wepa\Faq\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswerTranslation extends Model
{
    public $timestamps = false;

    public $fillable = ['question', 'answer'];

    protected $table = 'faq_qas_translations';
}
