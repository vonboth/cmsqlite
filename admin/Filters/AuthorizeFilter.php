<?php


namespace Admin\Filters;


use Admin\Config\Acl;
use Admin\Services\AuthService;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthorizeFilter implements FilterInterface
{
    /**
     * @inheritDoc
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $acl = new Acl();
        $auth = service('auth');
        $user = $auth->getUser();

        var_dump($request); exit;
        /*$current = explode('/', $request->detectPath());

        if (in_array('login', $current) || in_array('logout', $current)) {
            return $request;
        }
        return redirect('admin/authenticate/login');*/
    }

    /**
     * @inheritDoc
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}