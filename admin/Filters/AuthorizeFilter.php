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
     *
     * @return void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $Acl = new Acl();
        $AuthService = service('auth');
        $role = $AuthService->getUserRole() ?? 'guest';
        $access = $Acl->$role;

        // pass generally allowed URLs
        if (!$AuthService->passTrough($request->detectPath())) {
            throw new ForbiddenException(lang('app.error.not_authorized'));
        }
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
