<?php


namespace Admin\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Media
 * @package Admin\Controllers
 */
class Media extends Base
{
    protected $mediaPath = WRITEPATH . '/media';
    protected $currentPath = '/';

    /**
     * init controller
     */
    public function initialize()
    {
        $this->currentPath = (session()->get('cmsql_media_currentPath'))
            ? session()->get('cmsql_media_currentPath') : '/';
    }

    /**
     * Index / entry point for the controller
     * @return string
     */
    public function index()
    {
        return view(
            'Admin\Media\index',
            [
                'section' => lang('Menu.media')
            ]
        );
    }
}