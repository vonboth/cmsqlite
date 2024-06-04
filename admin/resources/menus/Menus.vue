<script>
import Swal from 'sweetalert2';
import MenuList from '../components/menus/MenuList.vue';
import axios from 'axios';

export default {
    name: 'PagesMenus',
    components: {MenuList},
    inject: ['translations'],
    data() {
        return {
            isLoading: false,
            hideMenuForm: true,
            selectedMenu: {},
            selectedMenuId: null,
            hideMenuitemForm: true,
            selectedMenuitem: null,
            parentMenus: [],
            currentMenus: this.menus || [],
            tabsInstance: null
        };
    },
    computed: {
        canSaveMenu() {
            return this.selectedMenu?.name !== '';
        },
        canSaveMenuitem() {
            return this.selectedMenuitem?.title !== ''
                && (this.selectedMenuitem?.article_id || this.selectedMenuitem?.url || this.selectedMenuitem?.category_id);
        },
        config() {
            return config;
        }
    },
    props: {
        menus: {
            type: Array,
            required: true
        },
        csrfToken: {
            type: String,
            required: true
        },
        articles: {
            type: Array
        },
        categories: {
            type: Array
        }
    },
    mounted() {
        console.log(this.menus);
        this.tabsInstance = M.Tabs.init(document.querySelectorAll('.tabs'));
    },
    methods: {
        // Menu section: add a new menu
        onAddMenu() {
            this.selectedMenu = {
                name: '',
                description: ''
            };
            this.hideMenuitemForm = true;
            this.hideMenuForm = false;
        },

        // Menu section: edit a new menu
        onEditMenu(id) {
            this.selectedMenu = Object.assign({}, this.currentMenus.find((menu) => menu.id === id));
            this.hideMenuitemForm = true;
            this.hideMenuForm = false;
        },

        // Menu section: cancel edit menu
        onResetMenu() {
            this.selectedMenu = {};
            this.hideMenuForm = true;
        },

        // Menu section: save the menu form
        async onSaveMenu() {
            this.isLoading = true;
            const url = this.selectedMenu.id
                ? `/admin/menus/edit/${this.selectedMenu.id}` : '/admin/menus/add';

            try {
                const response = await axios.post(url, this.selectedMenu, {
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken
                    }
                });

                if (this.selectedMenu.id) {
                    this.currentMenus
                        .splice(
                            this.currentMenus.findIndex(it => it.id === this.selectedMenu.id),
                            1,
                            response.data.data
                        );
                } else {
                    this.currentMenus.push(response.data.data);
                }

                if (response.data.message) {
                    M.toast({html: response.data.message});
                }
                this.onResetMenu();
            } catch (exception) {
                console.error(exception);
                const errors = exception.response?.data?.errors;
                if (errors) {
                    for (const key in exception.response.data?.errors) {
                        M.toast({html: `${key}: ${errors[key]}`});
                    }
                } else {
                    M.toast({html: exception.response?.data?.message || 'error occured'});
                }
            }
            this.isLoading = false;
        },

        // Delete Menu
        onDeleteMenu(id) {
            this.onResetMenuitem();
            Swal.fire({
                icon: 'warning',
                title: this.translations.delete_item,
                text: this.translations.delete_question,
                showCancelButton: true,
                cancelButtonText: this.translations.no,
                confirmButtonText: this.translations.yes
            }).then(async result => {
                if (result.isConfirmed) {
                    try {
                        const response = await axios.post(`/admin/menus/delete/${id}`, null, {
                            headers: {'X-CSRF-TOKEN': this.csrfToken}
                        });
                        this.currentMenus = this.currentMenus.filter(it => it.id !== id);
                        M.toast({html: response.data?.message});
                    } catch (exception) {
                        console.error(exception);
                        const errors = exception.response.data?.errors;
                        if (errors) {
                            for (const key in exception.response.data?.errors) {
                                M.toast({html: `${key}: ${errors[key]}`});
                            }
                        } else {
                            M.toast({html: exception.response.data.message});
                        }
                    }
                }
            });
        },

        // select menu id, opening the collapsible
        onSelectMenu(id) {
            this.hideMenuitemForm = true;
            this.hideMenuForm = true;
            this.selectedMenuitem = null;
            this.selectedMenu = {};
            this.selectedMenuId = id;
        },

        // add a menu item
        onAddMenuitem(menuId) {
            this.hideMenuForm = true;
            this.selectedMenuId = menuId;
            this.parentMenus = findMenuItems([], this.currentMenus.find(it => it.id === menuId).children);
            this.selectedMenuitem = {
                title: '',
                parent_id: null,
                menu_id: menuId,
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

            if (config.translationEnabled) {
                this.selectedMenuitem.translations = {};
                config.supportedTranslations.forEach(lang => {
                    this.selectedMenuitem.translations[lang] = {
                        language: lang,
                        title: ''
                    };
                });
            }

            this.hideMenuitemForm = false;
            this.tabsInstance[0].select(`tab_${config.language}`);
        },

        // edit menu item
        onEditMenuitem(id, menuId) {
            this.hideMenuForm = true;
            this.selectedMenuId = menuId;
            const menu = this.currentMenus.find(it => it.id === menuId);
            this.selectedMenuitem = Object.assign({}, findItemInMenu(menu.children, id));
            this.hideMenuitemForm = false;
            this.tabsInstance[0].select(`tab_${config.language}`);
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

        // Menu section: change menuitem callback
        onChangeMenuitemType(event) {
            this.selectedMenuitem.type = event.target.value;
            this.selectedMenuitem.article_id = null;
            this.selectedMenuitem.url = '';
        },

        // Menu section: cancel edit a menuitem
        onResetMenuitem() {
            this.selectedMenuitem = null;
            this.hideMenuitemForm = true;
        },

        // Menu section: save the menuitem
        async onSaveMenuitem() {
            this.isLoading = true;
            try {
                const url = this.selectedMenuitem?.id
                    ? `/admin/menuitems/edit/${this.selectedMenuitem?.id}` : '/admin/menuitems/add';

                const response = await axios.post(url, this.selectedMenuitem, {
                    headers: {'X-CSRF-TOKEN': this.csrfToken}
                });

                const menu = this.currentMenus.find(it => it.id === this.selectedMenuId);
                menu.children = response.data?.data;

                if (response.data?.message) {
                    M.toast({html: response.data?.message});
                }
            } catch (exception) {
                console.error(exception);
                const errors = exception.response?.data?.errors;
                if (errors) {
                    for (const key in exception.response.data?.errors) {
                        M.toast({html: `${key}: ${errors[key]}`});
                    }
                } else {
                    M.toast({html: exception.response.data.message});
                }
            }
            this.isLoading = false;
        },

        // Menu section: remove a menuitem
        onDeleteMenuitem(id, menuId) {
            this.onResetMenuitem();
            const menu = this.currentMenus.find(it => it.id === menuId);
            const menuitem = findItemInMenu(menu.children, id);

            let withInput = false,
                options = {
                    icon: 'warning',
                    title: this.translations.delete_item,
                    text: this.translations.delete_question,
                    showCancelButton: true,
                    cancelButtonText: this.translations.no,
                    confirmButtonText: this.translations.yes
                };

            if (menuitem.rgt - menuitem.lft > 1) {
                withInput = true;
                options = {
                    ...options,
                    input: 'checkbox',
                    inputValue: 0,
                    inputPlaceholder: this.translations.delete_menu_all_children
                };
            }

            Swal.fire(options)
                .then(async (result) => {
                    if (result.isConfirmed) {
                        this.isLoading = true;

                        let url = `/admin/menuitems/delete/${id}` + (withInput ? `?remove_tree=${result.value}` : '');
                        try {
                            const response = await axios.delete(url, {
                                headers: {'X-CSRF-TOKEN': this.csrfToken}
                            });
                            menu.children = response.data?.data;
                            M.toast({html: response.data?.message});
                        } catch (exception) {
                            console.error(exception);
                            const errors = exception.response.data?.errors;
                            if (errors) {
                                for (const key in exception.response.data?.errors) {
                                    M.toast({html: `${key}: ${errors[key]}`});
                                }
                            } else {
                                M.toast({html: exception.response.data.message});
                            }
                        }

                        this.isLoading = false;
                    }
                });
        },

        // move a menu item up
        async onMoveItem(id, menuId, direction = 'up') {
            try {
                const response = await axios.post(`/admin/menuitems/move/${id}`, {direction}, {
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken
                    }
                });
                const menu = this.currentMenus.find(it => it.id === menuId);
                menu.children = response.data?.data;
                M.toast({html: response.data.message});
            } catch (exception) {
                console.error(exception);
                const errors = exception.response.data?.errors;
                if (errors) {
                    for (const key in exception.response.data?.errors) {
                        M.toast({html: `${key}: ${errors[key]}`});
                    }
                } else {
                    M.toast({html: exception.response.data.message});
                }
            }
        }
    }
};

/**
 * Find all menu-items / children for a menu
 * @param elements
 * @param menu
 * @returns {*}
 */
function findMenuItems(elements, menu) {
    menu.forEach(item => {
        elements.push(item);
        if (item.children?.length > 0) {
            findMenuItems(elements, item.children);
        }
    });

    return elements;
}

/**
 * Find a menu item for a given id
 * @param menus
 * @param id
 * @returns {*}
 */
function findMenuitem(menus, id) {
    for (const menu of menus) {
        const item = findItemInMenu(menu.children, id);
        if (item) {
            return item;
        }
    }
}

/**
 * recursion for menuitems children
 * @param children
 * @param id
 * @returns {*}
 */
function findItemInMenu(children, id) {
    for (const child of children) {
        if (child.id === id) {
            return child;
        }
        if (child.children.length > 0) {
            const el = findItemInMenu(child.children, id);
            if (el) {
                return el;
            }
        }
    }
}
</script>

<template>
    <div>
        <div class="row">
            <div class="col s12">
                <a @click="onAddMenu"
                   class="btn-floating waves-effect waves-light blue pointer">
                    <i class="material-icons">add</i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col s4">
                <!-- MENU TREE -->
                <ul class="collapsible expandable collapsible-accordion admin-menu">
                    <li class="menu-administration active" v-for="menu in currentMenus">
                        <div class="flex space-between collapsible-header-wrapper">
                            <div class="collapsible-header flex-center"
                                 @click="onSelectMenu(menu.id)">
                                <div class="menu-name">
                                    <span>{{ menu.name }} | Id: {{ menu.id }}</span>
                                </div>
                                <div>
                                    <span class="menu-description">{{ menu.description }}</span>
                                </div>
                            </div>
                            <div class="flex flex-center p1rem">
                                <span class="clickable"
                                      @click="onEditMenu(menu.id)"><i class="material-icons">edit</i></span>
                                <span class="clickable"
                                      @click="onDeleteMenu(menu.id)"><i class="material-icons">delete</i></span>
                            </div>
                        </div>
                        <div class="collapsible-body">
                            <div class="right">
                                <a class="pointer"
                                   :title="translations.menus.add_menu_item"
                                   @click="onAddMenuitem(menu.id)">
                                    <i class="material-icons">add_circle_outline</i>
                                </a>
                            </div>
                            <div class="clearfix">
                                <menu-list :handle-delete="onDeleteMenuitem"
                                           :handle-edit="onEditMenuitem"
                                           :move-item="onMoveItem"
                                           :menuitems="menu.children"></menu-list>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col s8">
                <!-- MENU FORM -->
                <div :class="{hide: hideMenuForm}">
                    <form method="post" ref="menu_form">
                        <div class="card">
                            <div class="progress" :class="{hide: !(isLoading)}">
                                <div class="indeterminate"></div>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s12">
                                        <div>
                                            <label for="name">{{ translations.menus.name }}</label>
                                            <input type="text"
                                                   :value="selectedMenu.name"
                                                   @input="event => selectedMenu.name = event.target.value"
                                                   id="name"
                                                   required
                                                   class="validate"
                                                   name="name"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col s12">
                                        <div>
                                            <label for="name">{{ translations.menus.description }}</label>
                                            <input type="text"
                                                   :value="selectedMenu.description"
                                                   @input="event => selectedMenu.description = event.target.value"
                                                   id="description"
                                                   class="validate"
                                                   name="description"/>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-action">
                                <button class="btn waves-effect waves-light"
                                        @click="onResetMenu"
                                        type="button">{{ translations.cancel }}
                                    <i class="material-icons right">cancel</i></button>
                                <button class="btn waves-light waves-effect ml1rem"
                                        v-bind:disabled="!(canSaveMenu)"
                                        @click="onSaveMenu"
                                        type="button">{{ translations.submit }}
                                    <i class="material-icons right">send</i></button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- MENUITEM FORM -->
                <div :class="{hide: hideMenuitemForm}" class="z-depth-2 menuitem-container row">
                    <div class="progress" :class="{hide: !(isLoading)}">
                        <div class="indeterminate"></div>
                    </div>
                    <div class="col s12">
                        <div class="row menuitem-form-container">
                            <form ref="menuitem_form">
                                <input type="hidden" name="menu_id" :value="selectedMenuitem?.menu_id"/>
                                <input type="hidden" name="lft" :value="selectedMenuitem?.lft"/>
                                <input type="hidden" name="rgt" :value="selectedMenuitem?.rgt"/>
                                <div v-if="config.translationEnabled" class="col s12">
                                    <ul class="tabs">
                                        <li class="tab col s2">
                                            <a class="active" :href="`#tab_${config.language}`">
                                                {{ config.language }}
                                            </a>
                                        </li>
                                        <li v-for="lang in config.supportedTranslations"
                                            class="tab col s2">
                                            <a :href="`#tab_${lang}`">{{ lang }}</a>
                                        </li>
                                    </ul>
                                </div>

                                <div :id="`tab_${config.language}`" class="col s12">
                                    <div class="px1rem py2rem">
                                        <!-- TITLE -->
                                        <div class="row">
                                            <div class="col s12">
                                                <label for="title">{{ translations.menuitems.title }}
                                                    <span class="helper-text">
                                                <i class="material-icons tooltipped"
                                                   data-position="right"
                                                   :data-tooltip="translations.help.menus.title">help_outline</i>
                                            </span>
                                                </label>
                                                <input name="title"
                                                       required
                                                       @keyup="onChangeMenuitemTitle"
                                                       id="title"
                                                       type="text"
                                                       :value="selectedMenuitem?.title"
                                                       @input="event => selectedMenuitem.title = event.target.value"/>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col s12">
                                                <label for="type">{{ translations.menuitems.type }}
                                                    <span class="helper-text">
                                                <i class="material-icons tooltipped"
                                                   data-position="right"
                                                   :data-tooltip="translations.help.menus.type">help_outline</i>
                                            </span>
                                                </label>
                                                <select id="type"
                                                        class="no-material"
                                                        @change="onChangeMenuitemType"
                                                        :value="selectedMenuitem?.type"
                                                        name="type">
                                                    <option value="article">{{
                                                            translations.menuitems.article
                                                        }}
                                                    </option>
                                                    <option value="category">{{
                                                            translations.menuitems.category
                                                        }}
                                                    </option>
                                                    <option value="other">{{ translations.menuitems.other }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- article selector -->
                                        <div :class="{hide: selectedMenuitem?.type !== 'article'}" class="row">
                                            <div class="col s12">
                                                <label for="article_id">{{ translations.menuitems.article_id }}
                                                    <span class="helper-text">
                                                <i class="material-icons tooltipped"
                                                   data-position="right"
                                                   :data-tooltip="translations.help.menus.article_id">help_outline</i>
                                            </span>
                                                </label>
                                                <select id="article_id"
                                                        class="no-material"
                                                        :value="selectedMenuitem?.article_id"
                                                        @change="event => selectedMenuitem.article_id = event.target.value"
                                                        name="article_id">
                                                    <option v-for="article in articles" :value="article.id">{{
                                                            article.title
                                                        }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- category selector -->
                                        <div :class="{hide: selectedMenuitem?.type !== 'category'}" class="row">
                                            <div class="col s12">
                                                <label for="category_id">{{ translations.menuitems.category_id }}
                                                    <span class="helper-text">
                                                <i class="material-icons tooltipped"
                                                   data-position="right"
                                                   :data-tooltip="translations.help.menus.category_id">help_outline</i>
                                            </span>
                                                </label>
                                                <select id="category_id"
                                                        class="no-material"
                                                        :value="selectedMenuitem?.category_id"
                                                        @change="event => selectedMenuitem.category_id = event.target.value"
                                                        :required="selectedMenuitem?.type === 'category'"
                                                        name="category_id">
                                                    <option value="">-</option>
                                                    <option v-for="category in categories" :value="category.id">{{
                                                            category.name
                                                        }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- URL -->
                                        <div :class="{hide: selectedMenuitem?.type !== 'other'}" class="row">
                                            <div class="col s12">
                                                <label for="url">{{ translations.menuitems.url }}
                                                    <span class="helper-text">
                                                <i class="material-icons tooltipped"
                                                   data-position="right"
                                                   :data-tooltip="translations.help.menus.url">help_outline</i>
                                            </span>
                                                </label>
                                                <input name="url"
                                                       id="url"
                                                       type="text"
                                                       :value="selectedMenuitem?.url"
                                                       @input="event => selectedMenuitem.url = event.target.value"/>
                                            </div>
                                        </div>

                                        <div :class="{hide: selectedMenuitem?.id}" class="row">
                                            <div class="col s12">
                                                <label for="parent_id">{{ translations.menuitems.parent_id }}
                                                    <span class="helper-text">
                                                <i class="material-icons tooltipped"
                                                   data-position="right"
                                                   :data-tooltip="translations.help.menus.parent_id">help_outline</i>
                                            </span>
                                                </label>
                                                <select name="parent_id"
                                                        class="no-material"
                                                        id="parent_id"
                                                        :value="selectedMenuitem?.parent_id"
                                                        @change="event => selectedMenuitem.parent_id = event.target.value">
                                                    <option value="">-</option>
                                                    <option v-for="item in parentMenus"
                                                            :value="item.id"
                                                            v-text="item.title"></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col s12">
                                                <label for="alias">{{ translations.menuitems.alias }}
                                                    <span class="helper-text">
                                                <i class="material-icons tooltipped"
                                                   data-position="right"
                                                   :data-tooltip="translations.help.menus.alias">help_outline</i>
                                            </span>
                                                </label>
                                                <input type="text"
                                                       :value="selectedMenuitem?.alias"
                                                       @input="event => selectedMenuitem.alias = event.target.value"
                                                       name="alias"
                                                       id="alias"/>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col s12">
                                                <label for="target">{{ translations.menuitems.target }}
                                                    <span class="helper-text">
                                                <i class="material-icons tooltipped"
                                                   data-position="right"
                                                   :data-tooltip="translations.help.menus.target">help_outline</i>
                                            </span>
                                                </label>
                                                <select name="target"
                                                        class="no-material"
                                                        id="target"
                                                        :value="selectedMenuitem?.target"
                                                        @change="event => selectedMenuitem.target = event.target.value">
                                                    <option value="_self">{{ translations.menus.self }}</option>
                                                    <option value="_blank">{{ translations.menus.blank }}</option>
                                                    <!--option value="_parent">_parent</option-->
                                                    <!--option value="_top">_top</option-->
                                                </select>
                                            </div>
                                        </div>

                                        <ul class="collapsible simple">
                                            <li>
                                                <div class="collapsible-header">
                                                    <i class="material-icons">add_circle_outline</i>{{
                                                        translations.menuitems.additional_settings
                                                    }}
                                                </div>
                                                <div class="collapsible-body">
                                                    <div class="row">
                                                        <div class="col s12">
                                                            <label for="li_class">{{
                                                                    translations.menuitems.li_class
                                                                }}
                                                                <span class="helper-text">
                                                            <i class="material-icons tooltipped"
                                                               data-position="right"
                                                               :data-tooltip="translations.help.menus.li_class">help_outline</i>
                                                        </span>
                                                            </label>
                                                            <input id="li_class"
                                                                   :value="selectedMenuitem?.li_class"
                                                                   @input="event => selectedMenuitem.li_class = event.target.value"
                                                                   type="text"
                                                                   name="li_class"/>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col s12">
                                                            <label for="li_attributes">{{
                                                                    translations.menuitems.li_attributes
                                                                }}
                                                                <span class="helper-text">
                                                            <i class="material-icons tooltipped"
                                                               data-position="right"
                                                               :data-tooltip="translations.help.menus.li_attributes">help_outline</i>
                                                        </span>
                                                            </label>
                                                            <input id="li_attributes"
                                                                   :value="selectedMenuitem?.li_attributes"
                                                                   @input="event => selectedMenuitem.li_attributes = event.target.value"
                                                                   type="text"
                                                                   name="li_attributes"/>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col s12">
                                                            <label for="a_class">{{
                                                                    translations.menuitems.a_class
                                                                }}
                                                                <span class="helper-text">
                                                            <i class="material-icons tooltipped"
                                                               data-position="right"
                                                               :data-tooltip="translations.help.menus.a_class">help_outline</i>
                                                        </span>
                                                            </label>
                                                            <input id="a_class"
                                                                   :value="selectedMenuitem?.a_class"
                                                                   @input="event => selectedMenuitem.a_class = event.target.value"
                                                                   type="text"
                                                                   name="a_class"/>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col s12">
                                                            <label
                                                                for="a_attributes">{{
                                                                    translations.menuitems.a_attributes
                                                                }}
                                                                <span class="helper-text">
                                                            <i class="material-icons tooltipped"
                                                               data-position="right"
                                                               :data-tooltip="translations.help.menus.a_attributes">help_outline</i>
                                                        </span>
                                                            </label>
                                                            <input id="a_attributes"
                                                                   :value="selectedMenuitem?.a_attributes"
                                                                   @input="event => selectedMenuitem.a_attributes = event.target.value"
                                                                   type="text"
                                                                   name="a_attributes"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div v-if="config.translationEnabled"
                                     v-for="(lang, idx) in config.supportedTranslations"
                                     :id="`tab_${lang}`" class="col s12">
                                    <div class="px1rem py2rem">
                                        <!-- TITLE -->
                                        <div class="row">
                                            <div class="col s12">
                                                <label for="title">{{ translations.menuitems.title }}
                                                    <span class="helper-text">
                                                <i class="material-icons tooltipped"
                                                   data-position="right"
                                                   :data-tooltip="translations.help.menus.title">help_outline</i>
                                            </span>
                                                </label>
                                                <input name="title"
                                                       required
                                                       :id="`title_${lang}`"
                                                       type="text"
                                                       :value="selectedMenuitem?.translations[lang]?.title"
                                                       @input="event => selectedMenuitem.translations[lang].title = event.target.value"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="menu-action-footer col s12">
                                    <button class="btn waves-effect waves-light"
                                            @click="onResetMenuitem"
                                            type="button">{{ translations.cancel }} <i
                                        class="material-icons right">cancel</i>
                                    </button>

                                    <button class="btn waves-light waves-effect ml1rem"
                                            v-bind:disabled="!(canSaveMenuitem)"
                                            @click="onSaveMenuitem"
                                            type="button">{{ translations.save }} <i
                                        class="material-icons right">send</i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.menuitem-container {
    background-color: #fff;
    margin: .5rem 0 1rem 0;
}

.menuitem-form-container.row {
    margin-bottom: 0;
}

.menu-action-footer {
    border-top: 1px solid #e0e0e0;
    padding: 16px 26px;
    background-color: #fff;
}
</style>
