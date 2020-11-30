<?php


namespace Admin\Filters;


use Admin\Services\AuthService;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Class AuthenticateFilter
 * @package Admin\Filters
 */
class AuthenticateFilter implements FilterInterface
{
    /**
     * @inheritdoc
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        /** @var AuthService $AuthService */
        $AuthService = service('auth');

        if (!$AuthService->passTrough($request->detectPath())) {
            if (!$AuthService->isLoggedIn()) {
                return redirect()->to($AuthService->getRedirectUrl());
            }
        }
    }

    /**
     * @inheritdoc
     *
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): void
    {
    }
}