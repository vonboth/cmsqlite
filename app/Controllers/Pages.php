<?php

namespace App\Controllers;

/**
 * Class Home
 * @package App\Controllers
 * TODO: LAYOUT AUS DEM MENUITEM PARSEN !
 */
class Pages extends Base
{
    /**
     * Entrypoint for the startpage
     */
    public function start()
    {
        $article = $this->Articles->where('is_startpage', 1)->first();
        $this->_setViewVars();
        return view(
            "Themes\default\home",
            [
                'article' => $article,
                'author' => 'Hallo',
                'title' => 'Hallo Title',
            ]
        );
    }

    /**
     * @param null $var
     * @return string
     */
    public function index($var = null)
    {
        $article = $this->Articles->find($var);
        $this->_setViewVars();
        return view(
            'Themes\default\home',
            [
                'article' => $article,
                'author' => 'Hallo',
                'title' => 'Hallo Title',
            ]
        );
    }

    private function _setViewVars()
    {
        $menus = $this->Menus->findAllMenusWithTrees();
        //var_dump($menus); exit;
        $this->View->setVar('menus', $menus);
        $this->View->setVar('description', 'Descrption');
    }
}
