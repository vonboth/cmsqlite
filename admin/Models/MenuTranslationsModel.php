<?php

namespace Admin\Models;

/**
 * Class MenuTranslations
 * @package Admin\Models
 *
 * @property int $id
 * @property int $menuitem_id
 * @property string $language
 * @property string $title
 * @property string $created
 * @property string $updated
 */
class MenuTranslationsModel extends BaseModel
{
    /** @inheritdoc */
    protected $table = 'menu_translations';

    /** @inheritdoc */
    protected $returnType = 'Admin\Models\Entities\MenuTranslation';

    /** @inheritdoc */
    protected $allowedFields = [
        'id',
        'menuitem_id',
        'language',
        'title',
        'created',
        'updated'
    ];
}
