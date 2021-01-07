<?php


namespace Admin\Services;


use Admin\Filters\LoginThrottleFilter;
use Admin\Models\UsersModel;
use CodeIgniter\Config\BaseService;
use CodeIgniter\Events\Events;

/**
 * Class Auth
 * @package Admin\Services
 * @property UsersModel $Users
 */
class AuthService extends BaseService
{
    /** @var string $redirectUrl */
    public string $redirectUrl = '/admin/authenticate/login';

    /** @var UsersModel $Users */
    private UsersModel $Users;

    /**
     * allowed URLs without login
     * @var string[]
     */
    private array $allowedUrls = [
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
    public function updateUser(array $user): bool
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
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * Authenticate a user
     *
     * @param $username
     * @param $password
     *
     * @return bool
     */
    public function authenticate($username, $password): bool
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
            $this->_updateLogin($user);
            unset($user['password']);
            session()->set('Auth', ['User' => serialize($user)]);

            // trigger Event due to convention
            Events::trigger('login', $user);

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
     *
     * @return void
     */
    public function logout(): void
    {
        session()->set('Auth', null);
        // trigger Event due to convention
        Events::trigger('logout');
    }

    /**
     * check if current user is logged in
     * @return bool
     */
    public function isLoggedIn(): bool
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
    public function passTrough(string $url): bool
    {
        return in_array($url, $this->allowedUrls);
    }

    /**
     * reset tries after successfull login
     *
     * @param array|object $user
     * @param $num
     *
     * @return void
     */
    private function _setTries($user, int $num): void
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
     *
     * @return void
     */
    private function _resetLoginAttack(): void
    {
        session()->remove('LOGIN_ATTACK');
    }

    /**
     * Update login time for the user
     *
     * @param array|object $user
     *
     * @return void
     */
    private function _updateLogin($user): void
    {
        $user['lastlogin'] = date('Y-m-d H:i:s');
        try {
            $this->Users->save($user);
        } catch (\Exception $exception) {
        }
    }
}