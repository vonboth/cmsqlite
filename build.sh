#!/bin/bash

BUILD_DIR="build"
#VERSION=$(sed 's/.*"version": "\(.*\)".*/\1/;t;d' composer.json)

if [ ! -d $BUILD_DIR ]; then
  mkdir $BUILD_DIR
fi

# npm run build

# Admin-Section
cp -R admin/ $BUILD_DIR

# App-Section
cp -R app/ $BUILD_DIR

# Install-Section
cp -R install/ $BUILD_DIR

# Database
mkdir $BUILD_DIR/database
cp database/cmsqlite.db $BUILD_DIR/database
cp database/index.html $BUILD_DIR/database
cp database/.htaccess $BUILD_DIR/database

# public folder
mkdir -p ./$BUILD_DIR/public/css/
cp -R public/css/ $BUILD_DIR/public

mkdir -p $BUILD_DIR/public/fonts/
cp -R public/fonts/ $BUILD_DIR/public

mkdir -p $BUILD_DIR/public/js/
cp -R public/js/ $BUILD_DIR/public

mkdir -p $BUILD_DIR/public/media/
cp -R public/media/.gitkeep $BUILD_DIR/public/media
cp -R public/media/index.html $BUILD_DIR/public/media

mkdir -p $BUILD_DIR/public/themes/
cp -R public/themes $BUILD_DIR/public

cp -R public/.htaccess $BUILD_DIR/public
cp -R public/favicon.ico $BUILD_DIR/public
cp -R public/index.php $BUILD_DIR/public
cp -R public/robots.txt $BUILD_DIR/public

if [ -n "$1" -a "$1" == '--no_vendor' ]
then
  echo 'no vendor folder'
else
  # vendor folder
  mkdir -p $BUILD_DIR/vendor/bin/
  cp -R vendor/bin $BUILD_DIR/vendor
  mkdir -p $BUILD_DIR/vendor/codeigniter4/
  cp -R vendor/codeigniter4 $BUILD_DIR/vendor
  mkdir -p $BUILD_DIR/vendor/composer/
  cp -R vendor/composer $BUILD_DIR/vendor
  mkdir -p $BUILD_DIR/vendor/kint-php/
  cp -R vendor/kint-php $BUILD_DIR/vendor
  mkdir -p $BUILD_DIR/vendor/laminas/
  cp -R vendor/laminas $BUILD_DIR/vendor
  mkdir -p $BUILD_DIR/vendor/psr/
  cp -R vendor/psr $BUILD_DIR/vendor
  mkdir -p $BUILD_DIR/vendor/tatter/
  cp -R vendor/tatter $BUILD_DIR/vendor
  cp vendor/autoload.php $BUILD_DIR/vendor
fi

# writable folder
mkdir -p $BUILD_DIR/writable/cache/
cp writable/cache/index.html $BUILD_DIR/writable/cache
mkdir -p $BUILD_DIR/writable/logs/
cp writable/logs/index.html $BUILD_DIR/writable/logs
mkdir -p $BUILD_DIR/writable/session/
cp writable/session/index.html $BUILD_DIR/writable/session
mkdir -p $BUILD_DIR/writable/uploads/
cp writable/uploads/index.html $BUILD_DIR/writable/uploads
cp writable/.htaccess $BUILD_DIR/writable

# ROOT files
cp composer.json $BUILD_DIR
cp env $BUILD_DIR
cp htaccess $BUILD_DIR
cp index.php $BUILD_DIR
cp LICENSE $BUILD_DIR
cp license.txt $BUILD_DIR
cp README.md $BUILD_DIR
cp spark $BUILD_DIR