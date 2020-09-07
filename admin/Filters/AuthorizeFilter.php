<?php


namespace Admin\Filters;


use Admin\Config\Acl;
use App\Exceptions\ForbiddenException;
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
        $Acl = new Acl();
        $AuthService = service('auth');
        $role = $AuthService->getUserRole() ?? 'public';
        $access = $Acl->$role;

        // pass generally allowed URLs
        if (!$AuthService->passTrough($request->detectPath())) {
            throw new ForbiddenException(lang('Error.not_authorized'));
        }
    }

    /**
     * @inheritDoc
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}