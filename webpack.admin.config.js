const path = require('path');

module.exports = {
  mode: 'development',
  target: 'web',
  entry: {
    admin: './jssrc/admin/main.js',
    vendor: './jssrc/admin/vendor.js'
  },
  output: {
    filename: '[name].bundle.js',
    path: path.resolve(__dirname, 'public/themes/admin/Views/default/js')
  },
  resolve: {
    alias: {
      'vue$': 'vue/dist/vue.esm.browser.min.js'
    }
  }
}
