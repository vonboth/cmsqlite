<?php

namespace Admin\Models\Entities;

use Tatter\Relations\Traits\EntityTrait;

/**
 * Class MenuTranslation
 * @package Admin\Models\Entities
 *
 * Menu translation model
 *
 * @property int $id
 * @property int $menuitem_id
 * @property string $language
 * @property string $title
 * @property string $created
 * @property string $updated
 */
class MenuTranslation extends Base
{
    use EntityTrait;

    /** @inheritdoc */
    protected $attributes = [
        'id' => null,
        'menuitem_id' => null,
        'language' => null,
        'title' => null,
        'created' => null,
        'updated' => null,
    ];

    /** @inheritdoc */
    protected $dates = ['created', 'updated'];
}
