import Vue from 'vue';

const main = new Vue({
  el: '#main',
  mounted: function() {
    M.FormSelect.init(document.querySelectorAll('select'));
    M.Datepicker.init(document.querySelectorAll('input.datepicker'));

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
    }
  }
});