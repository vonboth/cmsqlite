<?php


namespace Admin\Validator;


use Admin\Services\AuthService;

/**
 * Class AuthenticationRules
 * @package Admin\Validator
 */
class AuthenticationRules
{
    /**
     * @param string $str
     * @param string $args
     * @param array $data
     * @param null|string $error
     * @return bool
     */
    public function authenticate(string $str, string $args, array $data, &$error = null)
    {
        if (service('auth')->authenticate($data['username'], $data['password'])) {
            return true;
        } else {
            $error = lang('all.validation.auth_failed');
            return false;
        }
    }

}
