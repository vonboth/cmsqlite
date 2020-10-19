<?php

namespace App\Controllers;

use Admin\Models\UsersModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Home
 * @package App\Controllers
 * TODO: LAYOUT/VIEW LAYOUT AUS DEM MENUITEM PARSEN ?!
 */
class Pages extends Base
{
    protected $Users;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
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

        $article->user = $this->Users->findAuthor($article->user_id);

        $this->_setViewVars();
        return view(
            "Themes\\$this->layout\start",
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
        $this->_setViewVars();
        return view(
            "Themes\\$this->layout\page",
            [
                'article' => $article,
            ]
        );
    }

    /**
     * set common data for the view
     */
    private function _setViewVars()
    {
        $menus = $this->Menus->findAllMenusWithTrees();
        $this->View->setVar('menus', $menus);
        $this->View->setVar('description', 'Descrption');
    }
}
