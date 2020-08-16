import Vue from 'vue';

const main = new Vue({
  el: '#main',
  data: function() {
    return {
      selectedMenuItem: {},
      selectedMenuId: null,
      hideMenuitemForm: true,
    };
  },
  mounted: function() {
    M.FormSelect.init(document.querySelectorAll('select:not(.no-material)'));
    M.Datepicker.init(document.querySelectorAll('input.datepicker'));
    M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'));
    M.Collapsible.init(document.querySelectorAll('.collapsible'));
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

    },
    onEditMenu: function(id) {
      console.log('edit the menu');
    },
    onDeleteMenu: function(id) {
      console.log('delete the menu');
    },
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
    }
  }
});
console.log(main);