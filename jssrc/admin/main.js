import Vue from 'vue';

// TODO: TRANSLATIONS OF JS MUST BE IMPL
const main = new Vue({
  el: '#main',
  data: function() {
    return {
      isLoading: false,
      hideMenuForm: true,
      selectedMenu: {},
      selectedMenuId: null,
      hideMenuitemForm: true,
      selectedMenuitem: {},
      parentMenus: [],
      menuFormAction: '/admin/menus/add',
      menuitemsFormAction: '/admin/menuitems/add'
    };
  },
  // computed values
  computed: {
    canSaveMenu: function() {
      return this.selectedMenu.name !== '';
    },
    canSaveMenuitem: function() {
      return this.selectedMenuitem.title !== ''
        && (this.selectedMenuitem.article_id || this.selectedMenuitem.url);
    }
  },
  // mounted hook
  mounted: function() {
    M.FormSelect.init(document.querySelectorAll('select:not(.no-material)'));
    M.Datepicker.init(document.querySelectorAll('input.datepicker'));
    M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'), {
      constrainWidth: false
    });
    M.Collapsible.init(document.querySelectorAll('.collapsible.simple'));
    M.Collapsible.init(document.querySelectorAll('.collapsible.admin-menu'));
    M.Tabs.init(document.querySelectorAll('.tabs'));
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
    M.FloatingActionButton.init(document.querySelectorAll('.action-btn-menu'));
    M.FloatingActionButton.init(document.querySelectorAll('.fixed-action-btn'));

    if (this.$refs.CKEditor) {
      ClassicEditor
        .create(document.getElementById('editor'), {
          language: 'de'
        })
        .catch(error => {
          console.error(error);
        });
    }
  },
  methods: {
    // general dialog when deleting an item
    onDeleteItem: function(controller, id) {
      Swal.fire({
        icon: 'warning',
        title: 'delete item',
        text: 'are you sure to delete the selected item?',
        showCancelButton: true
      })
        .then(function(result) {
          if (result.value) {
            window.location.href = `/admin/${controller}/delete/${id}`;
          }
        });
    },
    // select menu id, opening the collapsible
    onSelectMenu: function(id) {
      this.hideMenuitemForm = true;
      this.hideMenuForm = true;
      this.selectedMenuitem = {};
      this.selectedMenu = {};
      this.selectedMenuId = id;
    },
    // create a new menu item
    onAddMenuitem: function(menuId) {
      console.log(this.selectedMenuId);
      this.parentMenus = menuitems
        .filter((item) => item.menu_id === this.selectedMenuId);
      this.selectedMenuitem = {
        title: '',
        parent_id: null,
        menu_id: this.selectedMenuId,
        article_id: null,
        type: 'article',
        url: null,
        alias: '',
        layout: 'default',
        target: '_self',
        lft: 0,
        rgt: 0
      };
      this.hideMenuitemForm = false;
    },
    onEditMenuitem: function(id) {
      this.selectedMenuitem = menuitems.find((item) => item.id === id);
      this.hideMenuitemForm = false;
    },
    onChangeMenuitemType: function() {
      this.selectedMenuitem.article_id = null;
      this.selectedMenuitem.url = '';
    },
    onCancelEditMenuitem: function() {
      this.selectedMenuitem = {};
      this.hideMenuitemForm = true;
    },
    // save the menuitem
    onSaveMenuitem: function() {
      this.$refs.menuitem_form.submit();
    },
    // add a new menu
    onAddMenu: function() {
      this.menuFormAction = '/admin/menus/add';
      this.selectedMenu = {
        name: '',
        description: ''
      };
      this.hideMenuForm = false;
    },
    // edit a new menu
    onEditMenu: function(id) {
      this.menuFormAction = `/admin/menus/edit/${id}`;
      this.selectedMenu = menus.find((menu) => menu.id === id);
      this.hideMenuForm = false;
    },
    // cancel edit menu
    onCancelEditMenu: function() {
      this.selectedMenu = {};
      this.hideMenuForm = true;
    },
    // save the menu form
    onSaveMenu: function() {
      this.$refs.menu_form.submit();
    },
    // auto prepare the alias
    onChangeMenuitemTitle: function() {
      this.selectedMenuitem.alias = this.selectedMenuitem.title
        .replace(/\s/gi, '_')
        .replace(/!|\?|"|\'|\$|&/gi, '')
        .replace(/Ä|ä/gi, 'ae')
        .replace(/Ü|ü/gi, 'ue')
        .replace(/ß/g, 'ss')
        .replace(/Ö|ö/g, 'oe')
        .toLowerCase();
    },
    // read the CSRF token from the meta header
    getCsrfToken: () => document.querySelectorAll(
      'meta[name="X-CSRF-TOKEN"]')[0].content
  }
});
