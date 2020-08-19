import Vue from 'vue';

// TODO: TRANSLATIONS OF JS MUST BE IMPL
const main = new Vue({
  el: '#main',
  data: function() {
    return {
      isLoading: false,
      selectedMenuItem: {},
      selectedMenu: {},
      selectedMenuId: null,
      hideMenuForm: true,
      hideMenuitemForm: true,
      menuFormAction: '/admin/menus/add',
      menuitemsFormAction: '/admin/menuitems/add'
    };
  },
  // computed values
  computed: {
    canSaveMenu: function() {
      return this.selectedMenu.name !== '';
    }
  },
  // mounted hook
  mounted: function() {
    M.FormSelect.init(document.querySelectorAll('select:not(.no-material)'));
    M.Datepicker.init(document.querySelectorAll('input.datepicker'));
    M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'));
    M.Collapsible.init(document.querySelectorAll('.collapsible.simple'));
    M.Collapsible.init(document.querySelectorAll('.collapsible.admin-menu'), {
      onCloseEnd: function(el) {
        this.selectedMenuId = null;
      }.bind(this)
    });
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
      this.selectedMenuId = id;
    },
    // create a new menu item
    onAddMenuitem: function() {

    },
    // ask to delete the menuitem
    onDeleteMenuitem: function(id) {
      Swal.fire();
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
    onCancelEditMenu: function() {
      this.selectedMenu = {};
      this.hideMenuForm = true;
    },
    onSaveMenu: function() {
      this.$refs.menu_form.submit();
    },
    /*onDeleteMenu: function(id) {
      Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: 'Do you really want to delete the item?',
        confirmButtonText: 'yes',
        showCancelButton: true,
        cancelButtonText: 'no'
      }).then((result) => {
        if (result.isConfirmed) {
          Axios
            .post(`/admin/menus/delete/${id}`,
              {cmsql_sec_token: this.getCsrfToken()}
            )
            .then((result) => {
              M.toast({html: result.statusText});
            })
            .catch((error) => {
              console.error(error);
            })
            .then(() => window.location.reload());
        }
      });
    },*/
    // Menu actions:
    onChangeMenuitemTitle: function() {
      this.selectedMenuItem.alias = this.selectedMenuItem.title
        .replace(/\s/gi, '_')
        .replace(/!|\?|"|\'|\$|&/gi, '')
        .replace(/Ä|ä/gi, 'ae')
        .replace(/Ü|ü/gi, 'ue')
        .replace(/ß/g, 'ss')
        .replace(/Ö|ö/g, 'oe')
        .toLowerCase();
    },
    getCsrfToken: () => document.querySelectorAll(
      'meta[name="X-CSRF-TOKEN"]')[0].content
  }
});
