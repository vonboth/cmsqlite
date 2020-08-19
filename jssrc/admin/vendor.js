window.ClassicEditor = require('@ckeditor/ckeditor5-build-classic');
window.Swal = require('sweetalert2');
let axios = require('axios');
window.Axios = axios.create({
  headers: {
    'X-Requested-With': 'XMLHttpRequest'
  }
})
