window.Swal = require('sweetalert2');
const axios = require('axios');
window.Axios = axios.create({
  headers: {
    'X-Requested-With': 'XMLHttpRequest'
  }
})
