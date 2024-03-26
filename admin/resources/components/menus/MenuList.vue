<script>
import Swal from 'sweetalert2';
import menus from '../../menus/Menus.vue';

export default {
    computed: {
        menus() {
            return menus;
        }
    },
    inject: ['translations'],
    name: 'MenuList',
    props: {
        menuitems: {
            type: Array
        },
        ulClass: {
            type: String,
            default: 'ul_parent'
        },
        level: {
            type: Number,
            default: 0
        },
        handleDelete: Function,
        handleEdit: Function,
        moveItem: Function,
    },
    mounted() {
    },
    emits: ['deleteMenuitem'],
    methods: {
        // Menu section: check if menuitem has an ancestor
        hasAncestor(rgt, menu_id) {
            return this.menuitems.find(
                (item) => (item.lft === (rgt + 1) && item.menu_id === menu_id));
        },

        // Menu section: check if menuitem has parent item
        hasParent(lft, menu_id) {
            return this.menuitems.find(
                (item) => (item.rgt === (lft - 1) && item.menu_id === menu_id));
        }
    }
};
</script>

<template>
    <ul :class="ulClass" class="admin-menu-list">
        <li v-for="menuitem in menuitems"
            :class="`level${level} ${menuitem.children && menuitem.children.length > 0 ? 'li_parent' : 'li_child'}`">
            <div class="flex space-between">
                <a class="pointer menuitem-title"
                   @click="handleEdit(menuitem.id, menuitem.menu_id)"
                   :title="translations.menus.edit_menu_item">{{ menuitem.title }}</a>
                <div>
                    <a class="pointer"
                       :class="{hide: !hasAncestor(menuitem.rgt, menuitem.menu_id)}"
                       :title="translations.menus.move_item_down"
                       @click="moveItem(menuitem.id, menuitem.menu_id, 'down')"><i class="material-icons">arrow_downward</i></a>
                    <a class="pointer"
                       :class="{hide: !hasParent(menuitem.lft, menuitem.menu_id)}"
                       :title="translations.menus.move_item_up"
                       @click="moveItem(menuitem.id, menuitem.menu_id, 'up')"><i class="material-icons">arrow_upward</i></a>
                    <a class="pointer"
                       :title="translations.menus.delete_menu_item"
                       @click="handleDelete(menuitem.id, menuitem.menu_id)">
                        <i class="material-icons">delete</i>
                    </a>
                </div>
            </div>
            <menu-list v-if="menuitem.children?.length > 0"
                       :menuitems="menuitem.children"
                       :handle-delete="handleDelete"
                       :handle-edit="handleEdit"
                       :move-item="moveItem"
                       :level="this.level + 1"
                       ul-class="ul_child"></menu-list>
        </li>
    </ul>
</template>

<style scoped>

</style>
