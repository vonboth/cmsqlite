# CMSQLite Simple CMS based on SQLite

## What is this?

## Setup
###Writable Folders
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

## Planned Features
- General Parser for replacement of cells and content replacements
### Content Replacements:
- Read on link
### View Cells:
- Breadcrumb
- Contact form
- Gallery
- Latest news
- Sitemap