<?php


namespace App\Views\Cells;

use Admin\Models\MenuitemsModel;

/**
 * Class Menu
 * @package App\Views\Cells
 *
 * ViewCell to print out a menu
 * Pass an array with the ID of the menu or the name
 * e.g. view_cell('App\Views\Cells\Menu:render, ['id' => 1])
 * e.g. view_cell('App\Views\Cells\Menu:render, ['name' => 'main'])
 *
 * You need to know the ID and/or the name from the database or
 * the CMSQLite-Backend
 */
class Menu
{
    public function render(array $params = []): string
    {
        $Menuitems = new MenuitemsModel();
        $output = '';
        if (isset($params['id'])) {
            $items = $Menuitems->findTree($params['id']);
            $output = menu_list($items);
        }/* elseif (isset($params['name'])) {
        }*/

        return $output;
    }

    public function __call($name, $arguments): string
    {
        return $this->render($arguments);
    }
}