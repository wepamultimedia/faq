<?php

namespace Wepa\Faq\Models;

use Astrotomic\Translatable\Translatable;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wepa\Core\Http\Traits\Backend\PositionModelTrait;
use Wepa\Faq\Database\Factories\CategoryFactory;

/**
 * Wepa\Faq\Models\Category
 *
 * @property string $name
 * @property int $position
 * @property QuestionAnswer[] $questionsAnswers
 * @property-read Collection<int, CategoryTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static Builder|Category listsTranslations(string $translationField)
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category notTranslatedIn(?string $locale = null)
 * @method static Builder|Category orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Category orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Category orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Category query()
 * @method static Builder|Category translated()
 * @method static Builder|Category translatedIn(?string $locale = null)
 * @method static Builder|Category whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Category whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Category withTranslation()
 *
 * @mixin Eloquent
 */
class Category extends Model
{
    use HasFactory;
    use PositionModelTrait;
    use Translatable;

    protected $table = 'faq_categories';

    protected $fillable = ['position'];

    public array $translatedAttributes = ['name'];

    public $translationForeignKey = 'category_id';

    public function questionsAnswers(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class, 'category_id', 'id');
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}
