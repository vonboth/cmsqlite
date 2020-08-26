<?php


namespace Admin\Services;


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
    public $redirectUrl = 'admin/authenticate/login';

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
     * get current logged in user
     * @return mixed|null
     */
    public function getUser()
    {
        return is_null(session('Auth')) ? null : unserialize(session('Auth')['User']);
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
        $user = $this->Users
            ->where('username', $username)
            ->asArray()
            ->first();

        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            session()->set('Auth', ['User' => serialize($user)]);
            return true;
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
     * @return mixed
     */
    public function isLoggedIn()
    {
        return !empty(session('Auth')['User']);
    }

    /**
     * @param string $url
     * @return bool
     */
    public function passTrough($url)
    {
        return in_array($url, $this->allowedUrls);
    }

    /**
     * @return false
     */
    public function authorize()
    {
        $user = unserialize(session('Auth')['User']);
        if (!$user) {
            return false;
        }
        return false;
    }
}