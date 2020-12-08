<?php

if (!function_exists('tree_list')) {
    /**
     * generates an unordered list from a nested set
     *
     * @param $menuitems
     * @param array $options
     * @return mixed
     */
    function menu_list($menuitems, array $options = [])
    {
        $ulClass = $options['ulClass'] ?? 'ul_parent';
        $ulId = isset($options['ulId']) ? ' id="' . $options['ulId'] . '"' : '';

        $ul = "<ul{$ulId} class='$ulClass'>";
        foreach ($menuitems as $menuitem) {
            $css = (count($menuitem['children']) > 0) ? 'li_parent' : 'li_child';
            $css .= ' level' . $menuitem['level'];
            $ul .= "<li class='{$css}'>" .
                "<a href='{$menuitem['url']}'>{$menuitem['title']}</a>";

            if (count($menuitem['children']) > 0) {
                $ul .= menu_list($menuitem['children'], ['ulClass' => 'ul_child']);
            }

            $ul .= '</li>';
        }
        $ul .= "</ul>\n";

        return $ul;
    }

    /**
     * generates a tree for the
     * admin-section to change menus
     *
     * @param $menuitems
     * @param string $ulClass
     * @return string
     */
    function admin_menu_list($menuitems, $ulClass = 'ul_parent')
    {
        $ul = "<ul class='{$ulClass} admin-menu-list'>";
        foreach ($menuitems as $menuitem) {
            $css = (count($menuitem['children']) > 0) ? 'li_parent' : 'li_child';
            $css .= ' level' . $menuitem['level'];
            $ul .= "<li class='{$css}'>
<div class='flex space-between'>
  <a href='javascript:void(0)' 
     class='menuitem-title'
     title='" . lang('Menu.edit_menu_item') . "'
     @click='onEditMenuitem({$menuitem['id']})'>{$menuitem['title']}</a>
  <div>
    <a href='/admin/menuitems/movedown/{$menuitem['id']}'
       :class='{hide: !hasAncestor({$menuitem['rgt']}, {$menuitem['menu_id']})}'
       title='" . lang('Menu.move_item_down') . "'>
      <i class='material-icons'>arrow_downward</i>
    </a>
    <a href='/admin/menuitems/moveup/{$menuitem['id']}'
       :class='{hide: !hasParent({$menuitem['lft']}, {$menuitem['menu_id']})}'
       title='" . lang('Menu.move_item_up') . "'>
      <i class='material-icons'>arrow_upward</i>
    </a>
    <span class='clickable' 
          title='" . lang('Menu.delete_menu_item') . "'
          @click='onDeleteMenuitem({$menuitem['id']})'>
      <i class='material-icons'>delete</i>
    </span>
  </div>
</div>";

            if (count($menuitem['children']) > 0) {
                $ul .= admin_menu_list($menuitem['children'], 'ul_child');
            }

            $ul .= '</li>';
        }
        $ul .= "</ul>\n";

        return $ul;
    }

    /**
     * generates a collapsible list
     * with menus as headlines and
     * the menus inside the collapsibles
     * @param $menus
     * @return string
     */
    function admin_menu_tree($menus)
    {
        $idx = 0;
        $ul = '<ul class="collapsible collapsible-accordion admin-menu">';
        foreach ($menus as $menu) {
            $ul .= '
<li class="menu-administration' . (($idx == 0) ? ' active' : '') . '">
    <div class="flex space-between collapsible-header-wrapper">
        <div class="collapsible-header flex-center" 
             @click="onSelectMenu(' . $menu->id . ')"><div class="menu-name">' . $menu->name . '</div></div>
        <div class="flex flex-center p1rem">
           <span class="clickable"
                 @click="onEditMenu(' . $menu->id . ')"><i class="material-icons">edit</i></span>
           <span class="clickable"
                 @click="onDeleteItem(\'menus\', ' . $menu->id . ')"><i class="material-icons">delete</i></span>
        </div>
    </div>
    <div class="collapsible-body">
        <div class="right">
            <a href="javascript:void(0)" 
               title="' . lang('Menu.add_menu_item') . '" 
               @click="onAddMenuitem">
              <i class="material-icons">add_circle_outline</i></a>
        </div>
        <div class="clearfix">' . admin_menu_list($menu->tree) . '<div>
    </div>
</li>';
            $idx++;
        }
        return $ul .= '</ul>';
    }
}