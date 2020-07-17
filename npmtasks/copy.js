var copy = require('copy');

function callback (err, file) {
  if (err)
    console.error(err, file);
}

var options = {
  flatten: true
};
copy([
'node_modules/@ckeditor/ckeditor5-build-classic/build/ckeditor.js',
'node_modules/@ckeditor/ckeditor5-build-classic/build/ckeditor.js.map',
], 'public/js/ckeditor/classic', options, callback);
copy([
'node_modules/@ckeditor/ckeditor5-build-classic/build/translations/*.js',
], 'public/js/ckeditor/classic/translations', options, callback);
copy([
  'node_modules/axios/dist/*'
], 'public/js', options, callback);