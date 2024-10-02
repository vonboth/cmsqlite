<?php


namespace Admin\Models\Entities;

/**
 * Class Menuitem
 * @package Admin\Models\Entities
 *
 * Menu item model
 *
 * @property int $id
 * @property string $title
 * @property int $parent_id
 * @property int $menu_id
 * @property int $article_id
 * @property int $category_id
 * @property string $type
 * @property string $url
 * @property string $alias
 * @property string $target
 * @property string $li_class
 * @property string $li_attributes
 * @property string $a_class
 * @property string $a_attributes
 * @property int $lft
 * @property int $rgt
 * @property string $created
 * @property string $updated
 */
class Menuitem extends Base
{
    /** @inheritdoc */
    protected $attributes = [
        'id' => null,
        'title' => null,
        'parent_id' => null,
        'menu_id' => null,
        'article_id' => null,
        'category_id' => null,
        'type' => null,
        'url' => null,
        'alias' => null,
        'target' => null,
        'li_class' => null,
        'li_attributes' => null,
        'a_class' => null,
        'a_attributes' => null,
        'lft' => null,
        'rgt' => null,
        'created' => null,
        'updated' => null,
    ];

    /** @inheritdoc */
    protected $dates = ['created', 'updated'];

    /**
     * get the title of the menu item
     * if the translation is enabled, return the title of the current locale
     * @return string
     */
    public function getTitle(): string
    {
        if ($this->translationEnabeled && !empty($this->attributes['menu_translations'])) {
            foreach ($this->attributes['menu_translations'] as $translation) {
                if ($translation->language === $this->locale && !empty($translation->title)) {
                    return $translation->title;
                }
            }
        }

        return $this->attributes['title'];
    }

    /**
     * get menuitem translations
     * @return array|mixed|null
     */
    public function getMenuTranslations()
    {
        if (isset($this->attributes['menu_translations']) && !empty($this->attributes['menu_translations'])) {
            return $this->attributes['menu_translations'];
        }

        $query = $this->db->table('menu_translations');
        return $query->where('menuitem_id', $this->attributes['id'])
            ->get()
            ->getResult('Admin\Models\Entities\MenuitemTranslation');
    }
}
