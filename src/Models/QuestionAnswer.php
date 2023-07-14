<?php

namespace Wepa\Faq\Models;

use Astrotomic\Translatable\Translatable;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wepa\Core\Http\Traits\Backend\PositionModelTrait;
use Wepa\Faq\Database\Factories\QuestionAnswerFactory;

/**
 * Wepa\Faq\Models\QuestionAnswer
 *
 * @property int $category_id
 * @property bool $draft
 * @property string $question
 * @property string $answer
 * @property int $position
 * @property-read Collection<int, QuestionAnswerTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static Builder|QuestionAnswer listsTranslations(string $translationField)
 * @method static Builder|QuestionAnswer newModelQuery()
 * @method static Builder|QuestionAnswer newQuery()
 * @method static Builder|QuestionAnswer notTranslatedIn(?string $locale = null)
 * @method static Builder|QuestionAnswer orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|QuestionAnswer orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|QuestionAnswer orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|QuestionAnswer query()
 * @method static Builder|QuestionAnswer translated()
 * @method static Builder|QuestionAnswer translatedIn(?string $locale = null)
 * @method static Builder|QuestionAnswer whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|QuestionAnswer whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|QuestionAnswer withTranslation()
 *
 * @mixin Eloquent
 */
class QuestionAnswer extends Model
{
    use HasFactory;
    use PositionModelTrait;
    use Translatable;

    protected $table = 'faq_qas';

    protected $fillable = ['position', 'category_id', 'draft'];

    public array $translatedAttributes = ['question', 'answer'];

    public $translationForeignKey = 'qa_id';

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    protected static function newFactory(): QuestionAnswerFactory
    {
        return QuestionAnswerFactory::new();
    }
}
