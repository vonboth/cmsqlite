import {createApp} from '@vue/compat/dist/vue.esm-bundler';
import PageStatistics from './components/start/PageStatistics.vue';
import LastUsers from './components/start/LastUsers.vue';
import TopArticles from './components/start/TopArticles.vue';
import Settings from './settings/Settings.vue';

const App = {
    data() {
        return {
            isLoading: false,
            hideMenuForm: true,
            selectedMenu: {},
            selectedMenuId: null,
            hideMenuitemForm: true,
            selectedMenuitem: {},
            parentMenus: [],
            menuFormAction: '/admin/menus/add',
            menuitemFormAction: '/admin/menuitems/add',
            fileFormAction: '/admin/media/remove-file',
        };
    },
    // computed values
    computed: {
        canSaveMenu() {
            return this.selectedMenu.name !== '';
        },
        canSaveMenuitem() {
            return this.selectedMenuitem.title !== ''
                && (this.selectedMenuitem.article_id
                    || this.selectedMenuitem.url
                    || this.selectedMenuitem.category_id
                );
        }
    },
    // mounted hook
    mounted() {
        // M ist glob. Objekt f. Materialize-Bibl.
        M.Sidenav.init(document.querySelectorAll('.sidenav'));
        M.FormSelect.init(
            document.querySelectorAll('select:not(.no-material)'));
        M.Datepicker.init(document.querySelectorAll('input.datepicker'));
        M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'), {
            constrainWidth: false
        });
        M.Collapsible.init(document.querySelectorAll('.collapsible.simple'));
        M.Collapsible.init(document.querySelectorAll('.collapsible.admin-menu'),
            {
                accordion: false
            });
        M.Tabs.init(document.querySelectorAll('.tabs'));
        M.Tooltip.init(document.querySelectorAll('.tooltipped'));
        M.FloatingActionButton.init(
            document.querySelectorAll('.action-btn-menu'));
        M.FloatingActionButton.init(
            document.querySelectorAll('.fixed-action-btn'));
    },
    methods: {
        // general dialog when deleting an item
        onDeleteItem(controller, id) {
            Swal.fire({
                icon: 'warning',
                title: translations.delete_item,
                text: translations.delete_question,
                showCancelButton: true,
                cancelButtonText: translations.no,
                confirmButtonText: translations.yes
            })
                .then(function(result) {
                    if (result.isConfirmed) {
                        window.location.href = `/admin/${controller}/delete/${id}`;
                    }
                });
        },
        // select menu id, opening the collapsible
        onSelectMenu(id) {
            this.hideMenuitemForm = true;
            this.hideMenuForm = true;
            this.selectedMenuitem = {};
            this.selectedMenu = {};
            this.selectedMenuId = id;
        },

        // Menu section: check if menuitem has an ancestor
        hasAncestor(rgt, menu_id) {
            return menuitems.find(
                (item) => (item.lft === (rgt + 1) && item.menu_id === menu_id));
        },

        // Menu section: check if menuitem has parent item
        hasParent(lft, menu_id) {
            return menuitems.find(
                (item) => (item.rgt === (lft - 1) && item.menu_id === menu_id));
        },

        // Menu section: create a new menuitem
        onAddMenuitem(menuId) {
            this.selectedMenuId = menuId;
            this.menuitemFormAction = '/admin/menuitems/add';
            this.parentMenus = menuitems
                .filter((item) => item.menu_id === this.selectedMenuId);
            this.selectedMenuitem = {
                title: '',
                parent_id: null,
                menu_id: this.selectedMenuId,
                article_id: '',
                category_id: '',
                type: 'article',
                url: '',
                alias: '',
                li_class: '',
                li_attributes: '',
                a_class: '',
                a_attributes: '',
                layout: 'default',
                target: '_self',
                lft: 0,
                rgt: 0
            };
            this.hideMenuitemForm = false;
        },

        // Menu section: edit a menuitem
        onEditMenuitem(id) {
            this.menuitemFormAction = `/admin/menuitems/edit/${id}`;
            this.selectedMenuitem = menuitems.find((item) => item.id === id);
            this.hideMenuitemForm = false;
        },

        // Menu section: change menuitem callback
        onChangeMenuitemType() {
            this.selectedMenuitem.article_id = null;
            this.selectedMenuitem.url = '';
        },

        // Menu section: cancel edit a menuitem
        onCancelEditMenuitem() {
            this.selectedMenuitem = {};
            this.hideMenuitemForm = true;
        },

        // Menu section: save the menuitem
        onSaveMenuitem() {
            this.$refs.menuitem_form.submit();
        },

        // Menu section: remove a menuitem
        onDeleteMenuitem(id) {
            let menuitem = menuitems.find((item) => item.id === id),
                withInput = false,
                options = {
                    icon: 'warning',
                    title: translations.delete_item,
                    text: translations.delete_question,
                    showCancelButton: true,
                    cancelButtonText: translations.no,
                    confirmButtonText: translations.yes
                };

            if (menuitem.rgt - menuitem.lft > 1) {
                withInput = true;
                options = Object.assign(options, {
                    input: 'checkbox',
                    inputValue: 0,
                    inputPlaceholder: translations.delete_menu_all_children
                });
            }
            Swal.fire(options)
                .then((result) => {
                    if (result.isConfirmed) {
                        let url = `/admin/menuitems/delete/${id}`;
                        if (withInput) {
                            url = url + `?remove_tree=${result.value}`;
                        }
                        window.location.href = url;
                    }
                });
        },

        // Menu section: add a new menu
        onAddMenu() {
            this.menuFormAction = '/admin/menus/add';
            this.selectedMenu = {
                name: '',
                description: ''
            };
            this.hideMenuForm = false;
        },

        // Menu section: edit a new menu
        onEditMenu(id) {
            this.menuFormAction = `/admin/menus/edit/${id}`;
            this.selectedMenu = menus.find((menu) => menu.id === id);
            this.hideMenuForm = false;
        },

        // Menu section: cancel edit menu
        onCancelEditMenu() {
            this.selectedMenu = {};
            this.hideMenuForm = true;
        },

        // Menu section: save the menu form
        onSaveMenu() {
            this.$refs.menu_form.submit();
        },

        // Menu section: auto prepare the alias
        onChangeMenuitemTitle() {
            this.selectedMenuitem.alias = this.selectedMenuitem.title
                .replace(/\s/gi, '_')
                .replace(/!|\?|"|\'|\$|&/gi, '')
                .replace(/Ä|ä/gi, 'ae')
                .replace(/Ü|ü/gi, 'ue')
                .replace(/ß/g, 'ss')
                .replace(/Ö|ö/g, 'oe')
                .toLowerCase();
        },

        // Media section: delete media file
        onDeleteMedia(filename) {
            this.fileFormAction = '/admin/media/remove-file';

            Swal.fire({
                icon: 'warning',
                title: translations.delete_item,
                text: translations.delete_question,
                showCancelButton: true,
                cancelButtonText: translations.no,
                confirmButtonText: translations.yes
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$refs.remove_file.value = filename;
                    this.$refs.file_form.submit();
                } else {
                    this.$refs.remove_file.value = '';
                }
            });
        },

        // Media section: remove a directory
        onDeleteDirectory(dirname) {
            this.fileFormAction = '/admin/media/remove-dir';
            Swal.fire({
                icon: 'warning',
                title: translations.delete_directory,
                text: translations.delete_question,
                showCancelButton: true,
                cancelButtonText: translations.no,
                confirmButtonText: translations.yes
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$refs.remove_dir.value = dirname;
                    this.$refs.file_form.submit();
                } else {
                    this.$refs.remove_dir.value = '';
                }
            });
        },

        // check for a submited item and set it
        presetItem(prevItem) {
            if (prevItem !== false) {
                this.selectedMenuitem = {
                    id: prevItem.id,
                    title: prevItem.title,
                    parent_id: prevItem.parent_id,
                    menu_id: prevItem.menu_id,
                    article_id: prevItem.article_id,
                    category_id: prevItem.category_id,
                    type: prevItem.type,
                    url: prevItem.url,
                    alias: prevItem.alias,
                    li_class: prevItem.li_class,
                    li_attributes: prevItem.li_attributes,
                    a_class: prevItem.a_class,
                    a_attributes: prevItem.a_attributes,
                    target: prevItem.target,
                    layout: prevItem.layout,
                    lft: prevItem.lft,
                    rgt: prevItem.rgt
                };
                this.menuitemFormAction = this.selectedMenuitem.id
                    ? `/admin/menuitems/edit/${this.selectedMenuitem.id}`
                    : '/admin/menuitems/add';
                this.hideMenuitemForm = false;
            }
        }
    }
};

const app = createApp(App);
app.provide('translations', translations);
app.component('page-statistics', PageStatistics);
app.component('last-users', LastUsers);
app.component('top-articles', TopArticles);
app.component('settings', Settings);
app.mount('#main');
