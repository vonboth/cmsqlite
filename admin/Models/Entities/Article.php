<?php


namespace Admin\Models\Entities;

use Tatter\Relations\Traits\EntityTrait;
use Tatter\Relations\Traits\ModelTrait;

/**
 * Class Article
 * @package Admin\Models\Entities
 *
 * The Article Model
 *
 * @property int $id
 * @property bool $is_startpage
 * @property string $title
 * @property string $alias
 * @property string $doc_key
 * @property string $content
 * @property string $description
 * @property string $class
 * @property int $category_id
 * @property string $layout
 * @property int $user_id
 * @property string $published
 * @property string $start_publish
 * @property string $stop_publish
 * @property int $hits
 * @property string $created
 * @property string $updated
 */
class Article extends Base
{
    use EntityTrait;

    protected $attributes = [
        'id' => null,
        'is_startpage' => null,
        'title' => null,
        'alias' => null,
        'doc_key' => null,
        'content' => null,
        'description' => null,
        'class' => null,
        'category_id' => null,
        'layout' => null,
        'user_id' => null,
        'published' => null,
        'start_publish' => null,
        'stop_publish' => null,
        'hits' => null,
        'created' => null,
        'updated' => null
    ];

    protected $dates = ['created', 'updated'];

    protected $with = ['translations'];

    /**
     * get the content of the article
     * @return string
     */
    public function getContent(): string
    {
        if ($this->translationEnabeled && isset($this->attributes['translations']) && !empty($this->attributes['translations'])) {
            foreach ($this->attributes['translations'] as $translation) {
                if ($translation->language === $this->locale) {
                    return $translation->content ?: $this->attributes['content'];
                }
            }
        }
        return $this->attributes['content'];
    }
}
