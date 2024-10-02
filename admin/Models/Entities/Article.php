<?php


namespace Admin\Models\Entities;


use Admin\Models\Traits\RelationsTrait;

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
    use RelationsTrait;

    /** @inheritdoc */
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

    /** @inheritdoc */
    protected $dates = ['created', 'updated'];

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
        return $this->attributes['content'] ?? '';
    }

    /**
     * @return array|object|null
     */
    public function getUser()
    {
        if (isset($this->attributes['user']) && !empty($this->attributes['user'])) {
            return $this->attributes['user'];
        }

        $query = $this->db->table('users');
        return $query->select('id, username, firstname, lastname')
            ->where('id', $this->attributes['user_id'])
            ->get()
            ->getFirstRow('Admin\Models\Entities\User');
    }

    /**
     * @return array|object|null
     */
    public function getCategory()
    {
        if (isset($this->attributes['category']) && !empty($this->attributes['category'])) {
            return $this->attributes['category'];
        }

        $query = $this->db->table('categories');
        return $query->where('id', $this->attributes['category_id'])
            ->get()
            ->getFirstRow('Admin\Models\Entities\Category');
    }

    /**
     * @return array
     */
    public function getTranslations()
    {
        if (isset($this->attributes['translations']) && !empty($this->attributes['translations'])) {
            return $this->attributes['translations'];
        }

        $query = $this->db->table('translations');
        return $query->where('article_id', $this->attributes['id'])
            ->get()
            ->getResult('Admin\Models\Entities\Translation');
    }
}
