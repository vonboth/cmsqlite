<?php

namespace Admin\Services;

use CodeIgniter\Config\BaseService;

class MenuService extends BaseService
{
    /** @var string $locale current frontend locale  */
    protected $locale = '';

    /** @var bool $translationsEnabled translations enabled in DB? */
    protected $translationsEnabled = false;

    /**
     * MenuService constructor.
     */
    public function __construct()
    {
        $this->translationsEnabled = config('Admin\Config\SystemSettings')->translations;
        $this->locale = service('language')->getLocale();
    }

    /**
     * generate a menu list
     *
     * @param $menuitems
     * @param array $options
     * @param string $current_path
     * @param $level
     * @return string
     */
    public function menu_list($menuitems, array $options = [], string $current_path = '', $level = 1): string
    {
        $current_path = str_replace(['index.php', $this->locale], '', $current_path);
        if (empty($current_path)) {
            $current_path = '/';
        }

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
                $ul .= self::menu_list($menuitem['children'], ['ulClass' => 'ul_child'], $current_path, $level += 1);
            }

            $level = $level < 1 ? 1 : $level - 1;

            $ul .= '</li>';
        }
        $ul .= "</ul>\n";

        return $ul;
    }

    /**
     * gernerate the admin list menu
     *
     * @param $menuitems
     * @param $ulClass
     * @param $level
     * @return string
     */
    public function admin_menu_list($menuitems, $ulClass = 'ul_parent', $level = 0)
    {
        $ul = "<ul class='{$ulClass} admin-menu-list'>";
        foreach ($menuitems as $menuitem) {
            $css = (isset($menuitem['children']) && count($menuitem['children']) > 0) ? 'li_parent' : 'li_child';
            $css .= ' level' . $level;
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

            if (isset($menuitem['children']) && count($menuitem['children']) > 0) {
                $ul .= self::admin_menu_list($menuitem['children'], 'ul_child', $level + 1);
            }

            $ul .= '</li>';
        }

        $ul .= "</ul>\n";

        return $ul;
    }

    /**
     * create the admin menu tree
     * @param $menus
     * @return string
     */
    public function admin_menu_tree($menus)
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
               title="' . lang('Menu.add_menu_item') . '" 
               @click="onAddMenuitem(' . $menu->id . ')">
              <i class="material-icons">add_circle_outline</i></a>
        </div>
        <div class="clearfix">' . self::admin_menu_list($menu->children) . '<div>
    </div>
</li>';
        }

        return $ul . '</ul>';
    }
}
