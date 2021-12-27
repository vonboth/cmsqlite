<?php
/**
 * Use this template with the MenuCell:
 * view_cell('App\Views\CellsMenu::render', [...options]);
 * Example:
 * view_cell('App\Views\Cells\Menu::render',
 *  [
 *    'id' => 1,
 *    'ulClass' => 'ul_parent right hide-on-med-and-down',
 *    'template' => 'menu.php'
 *  ]
 * );
 *
 * The template file must be located in public/themes/Views/THEMENAME/cells/menu/
 *
 * When using your own template you need to take care of recursion by yourself.
 * Ohterwise use the menu_tree-Helper function which is harder to configure.
 */

/** @var array $menuitems an array of menuitems threaded */
/** @var array $options the options passed from the view_cell function */
?>
<ul class="<?= $options['ulClass'] ?>">
  <?php
  foreach ($menuitems as $item): ?>
    <li>
      <a href="<?= $item['url'] ?>"><?= $item['title'] ?></a>
    </li>
  <?php
  endforeach; ?>
</ul>
