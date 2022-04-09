#!/bin/bash

release=1
update=0
BUILD_DIR="build"
VERSION=$(sed 's/.*"version": "\(.*\)".*/\1/;t;d' composer.json)

while [[ $# -gt 0 ]]; do
  key="$1"

  case $key in
    -u|--update)
      release=0
      update=1
      shift
      shift
      ;;
    *) printf "Illegal option '-%s'\n" "$key" && exit 1 ;;
  esac
done

clear
echo $VERSION

if [ ! -d $BUILD_DIR ]; then
  mkdir $BUILD_DIR
else
  rm -R $BUILD_DIR
  mkdir $BUILD_DIR
fi

# NPM create the JS bundle
npm upgrade
npm run copy
npm run build

# Admin-Section
cp -R admin/ $BUILD_DIR

# App-Section
cp -R app/ $BUILD_DIR

# public folder for update and release
mkdir -p ./$BUILD_DIR/public/css/
cp -R public/css/ $BUILD_DIR/public
mkdir -p $BUILD_DIR/public/fonts/
cp -R public/fonts/ $BUILD_DIR/public
mkdir -p $BUILD_DIR/public/js/
cp -R public/js/ $BUILD_DIR/public
mkdir -p $BUILD_DIR/public/themes/
cp -R public/themes $BUILD_DIR/public

# ROOT files
cp composer.json $BUILD_DIR
cp env $BUILD_DIR
cp htaccess $BUILD_DIR
cp index.php $BUILD_DIR
cp LICENSE $BUILD_DIR
cp license.txt $BUILD_DIR
cp README.md $BUILD_DIR
cp robots.txt $BUILD_DIR
cp spark $BUILD_DIR

if [ $release -eq 1 ]
then
  # Install-Section
  cp -R install/ $BUILD_DIR

  # Database
  mkdir $BUILD_DIR/database
  cp database/cmsqlite.db $BUILD_DIR/database
  cp database/index.html $BUILD_DIR/database
  cp database/.htaccess $BUILD_DIR/database

  cp -R public/media $BUILD_DIR/public
  cp -R public/.htaccess $BUILD_DIR/public
  cp -R public/favicon.ico $BUILD_DIR/public
  cp -R public/index.php $BUILD_DIR/public
  cp -R public/robots.txt $BUILD_DIR/public

  # writable folder
  mkdir -p $BUILD_DIR/writable/cache/
  cp writable/cache/index.html $BUILD_DIR/writable/cache
  mkdir -p $BUILD_DIR/writable/logs/
  cp writable/logs/index.html $BUILD_DIR/writable/logs
  mkdir -p $BUILD_DIR/writable/media/
  cp -R writable/media/.gitignore $BUILD_DIR/writable/media
  cp -R writable/media/index.html $BUILD_DIR/writable/media
  mkdir -p $BUILD_DIR/writable/session/
  cp writable/session/index.html $BUILD_DIR/writable/session
  mkdir -p $BUILD_DIR/writable/uploads/
  cp writable/uploads/index.html $BUILD_DIR/writable/uploads
  cp writable/.htaccess $BUILD_DIR/writable
fi

# Install dependencies
cd $BUILD_DIR && composer install --no-dev
