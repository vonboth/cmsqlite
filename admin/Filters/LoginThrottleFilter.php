<?php


namespace Admin\Filters;


use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\SiteURI;
use CodeIgniter\HTTP\SiteURIFactory;

/**
 * Class BruteForceFilter
 * @package Admin\Filters
 *
 * Saves the number of requests on the login-page
 */
class LoginThrottleFilter implements FilterInterface
{
    public const SESSION_KEY = 'LOGIN_THROTTLE';

    /**
     * @inheritdoc
     *
     * @return void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if ($request->detectPath() === 'admin/authenticate/login'
            && $request->getMethod() === 'POST') {
            $session = session();
            $ipAddress = $request->getIPAddress();
            $sleep = 0;

            if ($loginAttack = $session->get(self::SESSION_KEY)) {
                if ($ipAddress == $loginAttack['IP_ADDRESS']) {
                    $sleep = $loginAttack['SLEEP'] + 1;
                }
            }
            $session->set([self::SESSION_KEY => ['IP_ADDRESS' => $ipAddress, 'SLEEP' => $sleep]]);
        }
    }

    /**
     * @inheritdoc
     *
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
