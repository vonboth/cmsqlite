<?php


namespace Admin\Filters;


use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthorizeFilter implements FilterInterface
{
    /**
     * @inheritDoc
     * @param IncomingRequest|RequestInterface $request
     */
    public function before(RequestInterface $request)
    {
        return $request;
        /*$current = explode('/', $request->detectPath());

        if (in_array('login', $current) || in_array('logout', $current)) {
            return $request;
        }
        return redirect('admin/authenticate/login');*/
    }

    /**
     * @inheritDoc
     */
    public function after(RequestInterface $request, ResponseInterface $response)
    {
    }
}