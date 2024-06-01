<?php

namespace Admin\Models\Entities;

use Tatter\Relations\Traits\EntityTrait;

/**
 * @property int $id
 * @property int $article_id
 * @property string $language
 * @property string $title
 * @property string $alias
 * @property string $doc_key
 * @property string $content
 * @property string $description
 * @property int $user_id
 * @property string $created
 * @property string $updated
 */
class Translation extends Base
{
    use EntityTrait;

    /** @inheritdoc  */
    protected $attributes = [
        'id' => null,
        'article_id' => null,
        'language' => null,
        'title' => null,
        'alias' => null,
        'doc_key' => null,
        'content' => null,
        'description' => null,
        'user_id' => null,
        'created' => null,
        'updated' => null,
    ];

    /** @inheritdoc */
    protected $dates = ['created', 'updated'];
}
