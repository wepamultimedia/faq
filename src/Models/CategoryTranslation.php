<?php

namespace Wepa\Faq\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;

    public $fillable = ['name'];

    protected $table = 'faq_categories_translations';
}
