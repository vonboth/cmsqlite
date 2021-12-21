<?php


namespace App\Views\Cells;

use Admin\Models\MenuitemsModel;
use Admin\Models\MenusModel;
use App\Views\Cells\AppCell;
use CodeIgniter\Services;

/**
 * Class Menu
 * @package App\Views\Cells
 *
 * ViewCell to print out a menu
 * Pass an array with the ID of the menu or the name
 * e.g. view_cell('View\Cells\Menu:render, ['id' => 1])
 * e.g. view_cell('View\Cells\Menu:render, ['name' => 'main'])
 *
 * You need to know the ID and/or the name from the database or
 * the CMSQLite-Backend
 */
class Menu extends AppCell
{
    /**
     * renders an un-ordered list of the menu
     * You can pass either the ID or the name of a
     * menu but one of the two is required
     * e.g. view_cell(App\Views\Cells\Menu::render(), ['id' => 1]);
     * e.g. view_cell(App\Views\Cells\Menu::render(), ['name' => 'main']);
     *
     * Possible options:
     * - id: Id of menu
     * - name: name of menu
     * - ulId: id for the UL element
     * - ulClass: css classes for the ul element
     * @param array $options
     * @return string
     */
    public function render(array $options = []): string
    {
        $output = '';
        $current_path = service('request')->uri->getPath();
        $Menuitems = new MenuitemsModel();

        if (isset($options['id'])) {
            $items = $Menuitems->findTree($options['id']);
            $output = menu_list($items, $options, $current_path);
        } elseif (isset($options['name'])) {
            $Menus = new MenusModel();
            $menu = $Menus->where('name', $options['name']);
            $items = $Menuitems->findTree($menu->id);
            $output = menu_list($items, $options);
        }

        return $output;
    }
}