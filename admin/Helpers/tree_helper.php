<?php

if (!function_exists('menu_list')) {
    /**
     * generates an unordered list from a nested set
     *
     * @param $menuitems
     * @param array $options
     * @param string $current_path
     * @param int $level
     * @return mixed
     * @deprecated use service('menu')->menu_list instead
     */
    function menu_list($menuitems, array $options = [], string $current_path = '', $level = 1): string
    {
        $ulClass = $options['ulClass'] ?? 'ul_parent';
        $ulId = isset($options['ulId']) ? ' id="' . $options['ulId'] . '"' : '';
        $liClass = isset($options['liClass']) ? ' ' . $options['liClass'] : '';
        $aClass = $options['aClass'] ?? '';

        $ul = "<ul{$ulId} class='$ulClass'>";
        foreach ($menuitems as $menuitem) {
            $url = $menuitem['url'];
            if (empty($url) && $menuitem['type'] === 'article') {
                $url = "/pages/{$menuitem['article_id']}";
            }

            $css = (isset($menuitem['children']) && count($menuitem['children']) > 0) ? 'li_parent' : 'li_child';
            $css .= ' level' . $level;
            $css .= ($url === $current_path) ? ' active' : '';
            $css .= $liClass;
            $css .= $menuitem['li_class'] ? ' ' . $menuitem['li_class'] : '';
            $aClass .= $menuitem['a_class'] ? ' ' . $menuitem['a_class'] : '';

            $ul .= "<li class=\"$css\" {$menuitem['li_attributes']}>" .
                "<a class=\"$aClass\" href=\"$url\" {$menuitem['a_attributes']}>{$menuitem['title']}</a>";

            if (isset($menuitem['children']) && count($menuitem['children']) > 0) {
                $ul .= menu_list($menuitem['children'], ['ulClass' => 'ul_child'], $current_path, $level += 1);
            }

            $level = $level < 1 ? 1 : $level - 1;

            $ul .= '</li>';
        }
        $ul .= "</ul>\n";

        return $ul;
    }
}

if (!function_exists('admin_menu_list')) {
    /**
     * generates a tree for the
     * admin-section to change menus
     *
     * @param $menuitems
     * @param string $ulClass
     * @param int $level
     * @return string
     * @deprecated
     */
    function admin_menu_list($menuitems, $ulClass = 'ul_parent', $level = 0)
    {
        $ul = "<ul class='{$ulClass} admin-menu-list'>";
        foreach ($menuitems as $menuitem) {
            $css = (isset($menuitem['children']) && count($menuitem['children']) > 0) ? 'li_parent' : 'li_child';
            $css .= ' level' . $level;
            $ul .= "<li class='{$css}'>
<div class='flex space-between'>
  <a href='javascript:void(0)' 
     class='menuitem-title'
     title='" . lang('admin.menu.edit_menu_item') . "'
     @click='onEditMenuitem({$menuitem['id']})'>{$menuitem['title']}</a>
  <div>
    <a href='/admin/menuitems/movedown/{$menuitem['id']}'
       :class='{hide: !hasAncestor({$menuitem['rgt']}, {$menuitem['menu_id']})}'
       title='" . lang('admin.menu.move_item_down') . "'>
      <i class='material-icons'>arrow_downward</i>
    </a>
    <a href='/admin/menuitems/moveup/{$menuitem['id']}'
       :class='{hide: !hasParent({$menuitem['lft']}, {$menuitem['menu_id']})}'
       title='" . lang('admin.menu.move_item_up') . "'>
      <i class='material-icons'>arrow_upward</i>
    </a>
    <span class='clickable' 
          title='" . lang('admin.menu.delete_menu_item') . "'
          @click='onDeleteMenuitem({$menuitem['id']})'>
      <i class='material-icons'>delete</i>
    </span>
  </div>
</div>";

            if (isset($menuitem['children']) && count($menuitem['children']) > 0) {
                $ul .= admin_menu_list($menuitem['children'], 'ul_child', $level + 1);
            }

            $ul .= '</li>';
        }

        $ul .= "</ul>\n";

        return $ul;
    }
}

if (!function_exists('admin_menu_tree')) {
    /**
     * generates a collapsible list
     * with menus as headlines and
     * the menus inside the collapsibles
     * @param $menus
     * @return string
     * @deprecated
     */
    function admin_menu_tree($menus)
    {
        $ul = '<ul class="collapsible expandable collapsible-accordion admin-menu">';
        foreach ($menus as $menu) {
            $ul .= '
<li class="menu-administration active">
    <div class="flex space-between collapsible-header-wrapper">
        <div class="collapsible-header flex-center" 
             @click="onSelectMenu(' . $menu->id . ')">
             <div class="menu-name"><span>' . $menu->name . '</span> | <span>Id: ' . $menu->id . '</span></div>
             <div><span class="menu-description">' . $menu->description . '</span></div>
        </div>
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
               title="' . lang('admin.menu.add_menu_item') . '" 
               @click="onAddMenuitem(' . $menu->id . ')">
              <i class="material-icons">add_circle_outline</i></a>
        </div>
        <div class="clearfix">' . admin_menu_list($menu->children) . '<div>
    </div>
</li>';
        }

        return $ul . '</ul>';
    }
}
