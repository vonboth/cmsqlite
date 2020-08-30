<?php

namespace Admin\Config;

class Media extends \CodeIgniter\Config\BaseConfig
{
    public $allowedExtensions = ['jpg', 'jpeg', 'png', 'bmp', 'pdf', 'doc', 'docx', 'odt'];

    public $allowedMimeTypes = [
        'image/jpg',
        'image/jpeg',
        'image/png',
        'image/bmp',
        'application/pdf',
        'doc',
        'docx',
        'odt'
    ];

    public $doNotDisplay = ['html', 'gitkeep'];
}
