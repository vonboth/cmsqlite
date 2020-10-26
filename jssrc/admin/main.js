import Vue from 'vue';

window.adminVue = new Vue({
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
      menuitemFormAction: '/admin/menuitems/add',
      fileFormAction: '/admin/media/remove-file',
      addNewSetting: false,
      editSettingId: '',
      prevSettingsValue: ''
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
  },
  methods: {
    // general dialog when deleting an item
    onDeleteItem: function(controller, id) {
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
    onSelectMenu: function(id) {
      this.hideMenuitemForm = true;
      this.hideMenuForm = true;
      this.selectedMenuitem = {};
      this.selectedMenu = {};
      this.selectedMenuId = id;
    },

    // Menu section: check if menuitem has an ancestor
    hasAncestor: function(rgt, menu_id) {
      return menuitems.find(
        (item) => (item.lft === (rgt + 1) && item.menu_id === menu_id));
    },

    // Menu section: check if menuitem has parent item
    hasParent: function(lft, menu_id) {
      return menuitems.find(
        (item) => (item.rgt === (lft - 1) && item.menu_id === menu_id));
    },

    // Menu section: create a new menuitem
    onAddMenuitem: function(menuId) {
      this.menuitemFormAction = '/admin/menuitems/add';
      this.parentMenus = menuitems
        .filter((item) => item.menu_id === this.selectedMenuId);
      this.selectedMenuitem = {
        title: '',
        parent_id: null,
        menu_id: this.selectedMenuId,
        article_id: '',
        type: 'article',
        url: '',
        alias: '',
        layout: 'default',
        target: '_self',
        lft: 0,
        rgt: 0
      };
      this.hideMenuitemForm = false;
    },

    // Menu section: edit a menuitem
    onEditMenuitem: function(id) {
      this.menuitemFormAction = `/admin/menuitems/edit/${id}`;
      this.selectedMenuitem = menuitems.find((item) => item.id === id);
      this.hideMenuitemForm = false;
    },

    // Menu section: change menuitem callback
    onChangeMenuitemType: function() {
      this.selectedMenuitem.article_id = null;
      this.selectedMenuitem.url = '';
    },

    // Menu section: cancel edit a menuitem
    onCancelEditMenuitem: function() {
      this.selectedMenuitem = {};
      this.hideMenuitemForm = true;
    },

    // Menu section: save the menuitem
    onSaveMenuitem: function() {
      this.$refs.menuitem_form.submit();
    },

    // Menu section: remove a menuitem
    onDeleteMenuitem: function(id) {
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
    onAddMenu: function() {
      this.menuFormAction = '/admin/menus/add';
      this.selectedMenu = {
        name: '',
        description: ''
      };
      this.hideMenuForm = false;
    },

    // Menu section: edit a new menu
    onEditMenu: function(id) {
      this.menuFormAction = `/admin/menus/edit/${id}`;
      this.selectedMenu = menus.find((menu) => menu.id === id);
      this.hideMenuForm = false;
    },

    // Menu section: cancel edit menu
    onCancelEditMenu: function() {
      this.selectedMenu = {};
      this.hideMenuForm = true;
    },

    // Menu section: save the menu form
    onSaveMenu: function() {
      this.$refs.menu_form.submit();
    },

    // Menu section: auto prepare the alias
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

    // Media section: delete media file
    onDeleteMedia: function(filename) {
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
    onDeleteDirectory: function(dirname) {
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

    // Settings section: add new
    onAddNewSetting: function() {
      this.addNewSetting = true;
    },

    // Settings section: cancel new setting
    onCancelNewSetting: function() {
      this.addNewSetting = false;
      document.getElementById('new_name').value = '';
      document.getElementById('new_value').value = '';
    },

    // Settings section: start editing a setting
    onEditSetting: function(id, name) {
      let el = document.getElementById('id-' + name);
      this.prevSettingsValue = el.value;
      this.editSettingId = id;
      el.removeAttribute('disabled');
    },

    // cancel edit setting
    onCancelEditSetting: function(name) {
      let el = document.getElementById('id-' + name);
      el.value = this.prevSettingsValue;
      this.prevSettingsValue = '';
      this.editSettingId = '';
      el.setAttribute('disabled', true);
    },

    // Setting section: save setting
    onSaveSetting: function(id, name) {
      let formData = new FormData(),
        el = document.getElementById('id-' + name);

      formData.append('value', el.value);
      Axios.post(
        `/admin/settings/save/${id}`,
        formData, {
          headers: {
            'X-CSRF-TOKEN': this.getCsrfToken()
          }
        })
        .then((response) => {
          window.location.reload();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // Setting section: delete setting
    onDeleteSetting: function(id) {
      Swal.fire({
        icon: 'warning',
        title: translations.delete_setting,
        text: translations.delete_question,
        showCancelButton: true,
        cancelButtonText: translations.no,
        confirmButtonText: translations.yes
      }).then((result) => {
        if (result.isConfirmed) {
          Axios
            .post(
              `/admin/settings/delete/${id}`,
              {},
              {
                headers: {
                  'X-CSRF-TOKEN': this.getCsrfToken()
                }
              })
            .then((response) => {
              window.location.reload();
            })
            .catch((error) => {
              console.log(error);
            });
        }
      });
    },

    // read the CSRF token from the meta header
    getCsrfToken: () => document
      .querySelectorAll('meta[name="X-CSRF-TOKEN"]')[0].content
  }
});
