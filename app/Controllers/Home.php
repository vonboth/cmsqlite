<?php namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\View\View;
use Psr\Log\LoggerInterface;

/**
 * Class Home
 * @package App\Controllers
 */
class Home extends Base
{
    public function index($name = null)
    {
        return view('Themes\default\home', [
            'description' => 'Hallo',
            'author' => 'Hallo',
            'title' => 'Hallo Title',
        ]);
    }
}
