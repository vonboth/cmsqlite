<?php


namespace App\Views\Cells;

use Admin\Models\MenuitemsModel;
use Admin\Models\MenusModel;
use CodeIgniter\Files\Exceptions\FileNotFoundException;

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
     * - template: name of the template (without php-FileExt.) to render
     * a custom menu.
     * If you want to use a custom template for your menu put the file
     * in the directory public/themes/frontend/Views/YOUR_THEME/cells/menu/
     * Give the file a name of your choice, e.g. "menu.php".
     * In the array set the template variable "template" to the name of your
     * template file with no php file extension e.g. [..., template => 'menu']
     * The file receives an array $menuitems with the menuitems and an
     * array with $options which contains the $options from the function
     * call view_cell
     * Note: You need to take care of multilevel menus by yourself!
     *
     * If you do not set the template file the menu is rendered by the function
     * menu_list from the tree_helper.php file.
     *
     * @param array $options
     * @return string
     */
    public function render(array $options = []): string
    {
        $current_path = service('request')->uri->getRoutePath();
        $templateFilePath = THEMEPATH . $this->theme . '/cells/menu/';
        $Menuitems = new MenuitemsModel();

        if (isset($options['id'])) {
            $items = $Menuitems->findTree($options['id']);
        } elseif (isset($options['name'])) {
            $Menus = new MenusModel();
            $menu = $Menus->where('name', $options['name'])->first();
            $items = $Menuitems->findTree($menu->id);
        }

        if (isset($options['template'])) {
            $templateName = strpos($options['template'], '.php') !== false ?
                str_replace('.php', '', $options['template']) : $options['template'];

            if (!file_exists($templateFilePath . $templateName . '.php')) {
                throw new FileNotFoundException(
                    "Missing template file: $templateName.php in path $templateFilePath for MenuCell"
                );
            }

            $output = view(
                'Themes\\' . $this->theme . '\\cells\\menu\\' . $templateName,
                [
                    'menuitems' => $items,
                    'options' => $options
                ]
            );
        } else {
            $output = service('menu')
                ->menu_list($items, $options, $current_path);
        }

        return $output;
    }
}
