<?php

namespace Admin\Config;

use CodeIgniter\Config\BaseConfig;

class Media extends BaseConfig
{
    public $allowedExtensions = [
        'jpg',
        'jpeg',
        'png',
        'bmp',
        'webp',
        'svg',
        'tiff',
        'pdf',
        'doc',
        'docx',
        'odt',
        'zip',
        'xls',
        'xlsx',
        'mpeg',
        'mpg',
        'mpe'
    ];
    public $allowedImages = ['jpg', 'jpeg', 'png', 'bmp', 'webp', 'tiff', 'svg'];

    public $allowedMimeTypes = [
        'image/jpg',
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/bmp',
        'application/pdf',
        'application/msword',
        'application/vnd.ms-office',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/zip',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-excel',
        'application/msword',
        'video/mpeg',
        'video/mpeg',
        'video/mpeg',
        'image/svg+xml',
        'application/xml',
        'text/xml',
    ];

    public $doNotDisplay = ['html', 'gitkeep', 'gitignore'];
}
