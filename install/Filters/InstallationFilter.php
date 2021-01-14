<?php


namespace Install\Filters;


use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class InstallationFilter implements FilterInterface
{
    /**
     * @inheritdoc
     * Filter denies accessing the installation-folder once the .env file is set up
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $route = $request->detectPath();
        if (strpos($route, 'install') === false
            && is_dir(ROOTPATH . 'install')
            && !file_exists(ROOTPATH . '.env')) {
            return redirect()->to("//{$_SERVER['HTTP_HOST']}/install");
        } elseif (strpos($route, 'install') !== false
            && file_exists(ROOTPATH . '.env')) {
            return redirect()->to('/admin/authenticate/login');
        } elseif (strpos($route, 'install') !== false
            && !file_exists(ROOTPATH . '.env')
            && !is_dir(ROOTPATH . 'install')) {
            throw new PageNotFoundException();
        }
    }

    /**
     * @inheritdoc
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}