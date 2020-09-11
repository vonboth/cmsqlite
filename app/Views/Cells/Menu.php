<?php


namespace ViewCells;

use Admin\Models\MenuitemsModel;
use Admin\Models\MenusModel;

/**
 * Class Menu
 * @package App\Views\Cells
 *
 * ViewCell to print out a menu
 * Pass an array with the ID of the menu or the name
 * e.g. view_cell('ViewCells\Menu:render, ['id' => 1])
 * e.g. view_cell('ViewCells\Menu:render, ['name' => 'main'])
 *
 * You need to know the ID and/or the name from the database or
 * the CMSQLite-Backend
 */
class Menu
{
    /**
     * renders an un-ordered list of the menu
     * You can pass either the ID or the name of a
     * menu.
     * e.g. view_cell(ViewCells\Menu::render(), ['id' => 1]);
     * e.g. view_cell(ViewCells\Menu::render(), ['name' => 'main']);
     *
     * @param array $params
     * @return string
     */
    public function render(array $params = []): string
    {
        $output = '';
        $Menuitems = new MenuitemsModel();

        if (isset($params['id'])) {
            $items = $Menuitems->findTree($params['id']);
            $output = menu_list($items);
        } elseif (isset($params['name'])) {
            $Menus = new MenusModel();
            $menu = $Menus->where('name', $params['name']);
            $items = $Menuitems->findTree($menu->id);
            $output = menu_list($items);
        }

        return $output;
    }

    /**
     * just a backup for miss-spelling
     * in the tempalte. This will allways
     * call $this->render
     *
     * @param $name
     * @param $arguments
     * @return string
     */
    public function __call($name, $arguments): string
    {
        return $this->render($arguments);
    }
}