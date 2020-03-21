var copy = require('copy');

function callback (err, file) {
  if (err)
    console.error(err, file);
}

var options = {
  flatten: true
};

copy([
  'node_modules/bulma/css/*'
], 'public/css', options, callback);

copy([
  'node_modules/axios/dist/*'
], 'public/js', options, callback);