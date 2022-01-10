# Simple CMS based on SQLite

## What is this?

## Setup
### Writable Folders
Make sure that the following folders are writable for the server either by 
changing ownership of the folders, or by changing the rights to 777:
- /writeable: please allow access to all folders in this directory (recursively)

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
- Sending E-Mails (contact form)
- Translations for Articles
- SEO URLs

### View Cells:
- Breadcrumb
- Contact form
- Gallery
- Latest news
- Sitemap

### Other
- switch to [jodit](https://xdsoft.net/jodit/) editor?

# Developers
This CMS is based on SQLite as database and [CodeIgniter 4](https://codeigniter.com/) (CI) as MVC-Framework.

What ever is possible with CI is possible with this CMS.

Feel free to fork it and send me your suggestions / pull requests.

## Environment .evn files
Use your own .env file to customize your local settings. Do not check in your .env file!

You can use the env-file as a blue print for your own .env-file.

## Database
- While developing use the cmsqlite_dev.db database
- If you want to build the final release use the file "build.sh" which will create a CMSQLite-Build
  - Check if your newly created files and folders are in the list of files to be copied
