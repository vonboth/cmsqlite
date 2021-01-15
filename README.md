# CMSQLite Simple CMS based on SQLite

## What is this?

## Setup
### Writable Folders
Make sure that the following folders are writable for the server either by 
changing ownership of the folders, or by changing the rights to 777:
- /writeable: please allow access to all folders in this directory (recursively)
- /public/media: you media files uploaded to via the CMS will be stored here

## Server Requirements

PHP version 7.4 or higher is required, with the following extensions installed: 

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- json (usually enabled by default - don't turn it off)
- xml (usually enabled by default - don't turn it off)

## Testing
- TODO: setup testing!

## Planned Features

### General
- Translations for Articles
- Tour for Backend
  - [uxTour](https://github.com/lyngbach/uxTour)
  - [tiny-tour](https://github.com/callahanrts/tiny-tour)

### View Cells:
- Breadcrumb
- Contact form
- Gallery
- Latest news
- Sitemap

### Other
- switch to [jodit](https://xdsoft.net/jodit/) editor?

# Developers
CMSQLite is based on SQLite as database and [CodeIgniter 4](https://codeigniter.com/) (CI) as MVC-Framework.

What ever is possible with CI is possible with CMSQLite.

Feel free to Fork and send me your suggestions / pull requests.