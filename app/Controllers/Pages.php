<?php

namespace App\Controllers;

use Admin\Models\UsersModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Home
 * @package App\Controllers
 * @property UsersModel $Users
 */
class Pages extends Base
{
    /** @var UsersModel $Users */
    protected UsersModel $Users;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);
        $this->Users = new UsersModel();
    }

    /**
     * Entrypoint for the startpage
     */
    public function start()
    {
        $article = $this->Articles
            ->where('is_startpage', 1)
            ->first();

        $this->_updateHits($article);

        $article->user = $this->Users->findAuthor($article->user_id);

        $this->_setViewVars();

        return view(
            "Themes\\$this->theme\\start",
            [
                'article' => $article,
            ]
        );
    }

    /**
     * @param null $var
     * @return string
     */
    public function pages($var = null)
    {
        $article = $this->Articles->find($var);
        $this->_updateHits($article);

        $this->_setViewVars();
        return view(
            "Themes\\$this->theme\\page",
            [
                'article' => $article,
            ]
        );
    }

    /**
     * set common data for the view
     *
     * @return void
     */
    private function _setViewVars(): void
    {
        $menus = $this->Menus->findAllMenusWithTrees();
        $this->View->setVar('menus', $menus);
        $this->View->setVar('theme', $this->theme);
    }

    /**
     * Update hits after finding the article
     *
     * @param array|object|null $article
     *
     * @return void
     */
    private function _updateHits($article): void
    {
        if ($article) {
            try {
                $this->Articles->setHit($article->id);
            } catch (\Exception $exception) {
            }
        }
    }
}
