<?php


namespace Admin\Validator;


use Admin\Services\AuthService;

/**
 * Class AuthenticationRules
 * @package Admin\Validator
 */
class AuthenticationRules
{
    /** @var AuthService $AuthService */
    protected $AuthService;

    public function __construct()
    {
        $this->AuthService = service('auth');
    }

    /**
     * @param string $str
     * @param string $args
     * @param array $data
     * @param null|string $error
     * @return bool
     */
    public function authenticate(string $str, string $args, array $data, &$error = null)
    {
        if ($this->AuthService->authenticate($data['username'], $data['password'])) {
            return true;
        } else {
            $error = lang('Validation.auth_failed');
            return false;
        }
    }

}