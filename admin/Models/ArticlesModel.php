<?php

namespace Admin\Models;

use Admin\Models\Entities\Translation;
use Admin\Models\Traits\RelationsTrait;
use Admin\Services\AuthService;
use CodeIgniter\Database\BaseBuilder;
use Tatter\Relations\Traits\ModelTrait;

/**
 * Class ArticlesModel
 * @package App\Models
 */
class ArticlesModel extends BaseModel
{
    use RelationsTrait;

    /** @inheritdoc */
    protected $table = 'articles';

    /** @inheritdoc */
    protected $returnType = 'Admin\Models\Entities\Article';

    /** @inheritdoc */
    protected $useTimestamps = true;

    /** @inheritdoc */
    protected $updatedField = 'updated';

    /** @inheritdoc */
    protected $createdField = 'created';

    /** @inheritdoc */
    protected $beforeUpdate = ['setStartpageFlagToNull'];

    /** @inheritdoc */
    protected $beforeInsert = ['setUser', 'setAlias'];

    protected $afterDelete = ['deleteRelations'];

    /** @inheritdoc */
    protected $allowedFields = [
        'is_startpage',
        'title',
        'alias',
        'doc_key',
        'content',
        'description',
        'class',
        'category_id',
        'layout',
        'user_id',
        'published',
        'start_publish',
        'stop_publish',
        'hits'
    ];

    /**
     * @return void
     */
    public function initialize()
    {
        $this->hasOne('users', [
            'foreign_key' => 'user_id',
            'finder' => function (BaseBuilder $query, $user_id) {
                return $query->select('id, username, firstname, lastname')
                    ->where('id', $user_id)
                    ->get()
                ->getFirstRow('Admin\Models\Entities\User');
            }
        ])->hasOne('categories', [
            'foreign_key' => 'category_id',
            'entity' => 'Admin\Models\Entities\Category'
        ])->hasMany('translations', [
            'foreign_key' => 'article_id',
            'entity' => 'Admin\Models\Entities\Translation'
        ]);
    }

    /**
     * Reset hits for all articles
     * @return mixed
     */
    public function resetHits()
    {
        return $this->db->simpleQuery('UPDATE articles SET hits=0');
    }

    /**
     * sets a hit on the page preventing updating
     * the "update" field
     * @param $id
     * @return mixed
     */
    public function setHit($id)
    {
        return $this->db->simpleQuery('UPDATE articles SET hits=hits+1 WHERE id=' . $id);
    }

    /**
     * set all flags is_startpage to null
     * so that we will have only one startpage
     *
     * @param array $data
     * @return array
     */
    protected function setStartpageFlagToNull(array $data): array
    {
        if (isset($data['data']['is_startpage'])) {
            $this->db->simpleQuery('UPDATE articles SET is_startpage=NULL');
        }
        return $data;
    }

    /**
     * set the user id for
     * the article
     * @param array $data
     * @return array
     */
    protected function setUser(array $data): array
    {
        /** @var AuthService $authService */
        $authService = service('auth');
        $user = $authService->getUser();
        $data['data']['user_id'] = $user['id'];
        return $data;
    }

    /**
     * create a page alias of none exists
     * @param array $data
     * @return array
     */
    protected function setAlias(array $data): array
    {
        if (empty($data['data']['alias'])) {
            $search = [' ', '-', '_'];
            $replace = ['_', '_', '_'];
            $data['data']['alias'] = str_replace(
                $search,
                $replace,
                strtolower($data['data']['title'])
            );
        }
        return $data;
    }

    /**
     * find an article with translations as an assoc array
     * @param $id
     * @return array
     */
    public function findWithTranslations($id): array
    {
        $article = $this->find($id);
        $articleAsArray = $article->toArray();
        $articleAsArray['translations'] = [];
        $supportedTranslations = config('Admin\Config\SystemSettings')->supportedTranslations;
        $defaultLanguage = config('Admin\Config\SystemSettings')->language;
        $languages = array_diff($supportedTranslations, [$defaultLanguage]);

        // add existing translations
        foreach ($article->translations as $translation) {
            $articleAsArray['translations'][$translation->language] = $translation->toArray();
        }

        // add missing translations
        foreach ($languages as $language) {
            if (!isset($articleAsArray['translations'][$language])) {
                $articleAsArray['translations'][$language] = (new Translation([
                    'article_id' => $article->id,
                    'language' => $language,
                    'title' => $article->title,
                    'content' => $article->content
                ]))->toArray();
            }
        }

        return $articleAsArray;
    }

    /**
     * callback on after delete
     * remove relations
     *
     * @param array $data
     * @return array
     */
    protected function deleteRelations(array $data): array
    {
        $this->db->table('translations')->where('article_id', $data['id'])->delete();
        return $data;
    }
}
