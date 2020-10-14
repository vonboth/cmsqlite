<?php


namespace Admin\Services;


use Admin\Filters\LoginThrottleFilter;
use Admin\Models\UsersModel;
use CodeIgniter\Config\BaseService;

/**
 * Class Auth
 * @package Admin\Services
 * @property UsersModel $Users
 */
class AuthService extends BaseService
{
    /** @var string $redirectUrl */
    public $redirectUrl = '/admin/authenticate/login';

    /** @var UsersModel $Users */
    private $Users;

    /**
     * allowed URLs without login
     * @var string[]
     */
    private $allowedUrls = [
        'admin/authenticate/login',
        'admin/authenticate/logout',
    ];

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        $this->Users = new UsersModel();
    }

    /**
     * get currently logged in user
     * @return mixed|null
     */
    public function getUser()
    {
        return is_null(session('Auth')) ? null : unserialize(session('Auth')['User']);
    }

    /**
     * get role of currently
     * logged in user
     * @return mixed|null
     */
    public function getRole()
    {
        return is_null(session('Auth')) ? null : unserialize(session('Auth')['User'])['role'];
    }

    /**
     * Update User data in session
     * @param array $user
     * @return bool
     */
    public function updateUser(array $user)
    {
        if (!empty($this->getUser())) {
            unset($user['password']);
            session()->set('Auth', ['User' => serialize($user)]);
            return true;
        }

        return false;
    }

    /**
     * returns redirect URL
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * Authenticate a user
     * @param $username
     * @param $password
     * @return false
     */
    public function authenticate($username, $password)
    {
        if (!$username || !$password) {
            return false;
        }

        // get SLEEP from session to prevent BruteForce
        // attacks against the login form
        $sleep = session()
            ->get(LoginThrottleFilter::SESSION_KEY)['SLEEP'];

        $user = $this->Users
            ->where('username', $username)
            ->asArray()
            ->first();

        if ($user && password_verify($password, $user['password'])) {
            $this->_setTries($user, 0);
            $this->_resetLoginAttack();
            unset($user['password']);
            session()->set('Auth', ['User' => serialize($user)]);
            return true;
        } else {
            $this->_setTries($user, $user['tries'] + 1);
        }

        if ($sleep > 0) {
            sleep($sleep * $sleep);
        }

        return false;
    }

    /**
     * log user off the session
     */
    public function logout()
    {
        session()->set('Auth', null);
    }

    /**
     * check if current user is logged in
     * @return mixed
     */
    public function isLoggedIn()
    {
        return !empty(session('Auth')['User']);
    }

    /**
     * some urls should not be protected
     * from the filter. E.g. login page
     * check if the current url is in the array
     * of allowed urls
     *
     * @param string $url
     * @return bool
     */
    public function passTrough($url)
    {
        return in_array($url, $this->allowedUrls);
    }

    /**
     * TODO: AUTHORIZE NEEDS IMPLEMENTATION
     * @return false
     */
    public function authorize()
    {
        $user = $this->getUser();
        if (!$user) {
            return false;
        }
        return false;
    }

    /**
     * reset tries after successfull login
     * @param array|object $user
     * @param $num
     */
    private function _setTries($user, int $num)
    {
        $user['tries'] = $num;
        try {
            $this->Users->save($user);
        } catch (\Exception $exception) {
        }
    }

    /**
     * After successful login: remove the
     * throttle check from the session
     */
    private function _resetLoginAttack()
    {
        session()->remove('LOGIN_ATTACK');
    }
}