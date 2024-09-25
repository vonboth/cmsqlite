<?php

namespace Admin\Models;

use Admin\Services\AuthService;

class TranslationsModel extends BaseModel
{
    /** @inheritdoc  */
    protected $table = 'translations';

    /** @inheritdoc  */
    protected $returnType = 'Admin\Models\Entities\Translation';

    /** @inheritdoc  */
    protected $useTimestamps = true;

    /** @inheritdoc  */
    protected $createdField = 'created';

    /** @inheritdoc  */
    protected $updatedField = 'updated';

    /** @inheritdoc  */
    protected $beforeInsert = ['setUser', 'setAlias'];

    /** @inheritdoc  */
    protected $allowedFields = [
        'article_id',
        'language',
        'title',
        'alias',
        'doc_key',
        'content',
        'description',
        'user_id',
    ];

    /**
     * set the user id for the translation
     * @param array $data
     * @return array
     */
    protected function setUser(array $data)
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
    protected function setAlias(array $data)
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
}
