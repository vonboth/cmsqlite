<?php


namespace Install\Filters;


use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\SiteURIFactory;

class InstallationFilter implements FilterInterface
{
    /**
     * @inheritdoc
     * Filter denies accessing the installation-folder once the .env file is set up
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $factory = new SiteURIFactory(new \Config\App(), new \CodeIgniter\Superglobals());
        $route = $factory->detectRoutePath();
        if (strpos($route, 'install') === false
            && is_dir(ROOTPATH . 'install')
            && !file_exists(ROOTPATH . '.env')) {
            return redirect()->to("/install");
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
