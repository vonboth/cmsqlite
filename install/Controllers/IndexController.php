<?php


namespace Install\Controllers;


use Admin\Models\Entities\User;
use Admin\Models\UsersModel;
use App\Controllers\BaseController;
use Config\App;
use Config\Services;

/**
 * Class Index
 * @package Install\Controllers
 *
 * Start controller for installation process
 */
class IndexController extends BaseController
{
    /** @var UsersModel $Users */
    protected UsersModel $Users;

    /**
     * Index constructor.
     */
    public function __construct()
    {
        $this->Users = new UsersModel();
    }

    /**
     * view to start installation
     * @return string
     */
    public function index(): string
    {
        $db_writable = is_writable(ROOTPATH . '/database/cmsqlite.db');
        $server = strtolower($_SERVER['HTTP_HOST']);
        $scheme = $_SERVER['REQUEST_SCHEME'] ? strtolower($_SERVER['REQUEST_SCHEME']) : 'http';
        $validator = Services::validation();
        if ($_SESSION['_ci_validation_errors']) {
            $errors = unserialize($_SESSION['_ci_validation_errors']);
            foreach ($errors as $key => $error) {
                $validator->setError($key, $error);
            }
        }

        $permissions = [
            'database' => [
                'writable' => is_writable(ROOTPATH . 'database'),
                'permission' => substr(sprintf('%o', fileperms(ROOTPATH . 'database')), -3)
            ],
            'writable' => [
                'writable' => is_writable(ROOTPATH . 'writable'),
                'permission' => substr(sprintf('%o', fileperms(ROOTPATH . 'writable')), -3)
            ],
            'writable/cache' => [
                'writable' => is_writable(ROOTPATH . 'writable/cache'),
                'permission' => substr(sprintf('%o', fileperms(ROOTPATH . '/writable/cache')), -3)
            ],
            'writable/logs' => [
                'writable' => is_writable(ROOTPATH . 'writable/logs'),
                'permission' => substr(sprintf('%o', fileperms(ROOTPATH . '/writable/logs')), -3)
            ],
            'writable/session' => [
                'writable' => is_writable(ROOTPATH . 'writable/session'),
                'permission' => substr(sprintf('%o', fileperms(ROOTPATH . '/writable/session')), -3)
            ],
            'writable/uploads' => [
                'writable' => is_writable(ROOTPATH . 'writable/uploads'),
                'permission' => substr(sprintf('%o', fileperms(ROOTPATH . '/writable/uploads')), -3)
            ],
            'public/media' => [
                'writable' => is_writable(ROOTPATH . 'public/media'),
                'permission' => substr(sprintf('%o', fileperms(ROOTPATH . '/public/media')), -3)
            ],
        ];

        $insufficient = $this->_insufficientPermissions($db_writable, $permissions);

        return view(
            'Install\Index\index',
            compact(
                'db_writable',
                'permissions',
                'insufficient',
                'server',
                'scheme',
                'validator'
            )
        );
    }

    /**
     * Install data to DB and filesystem
     * to ensure propper work of CMSQLite
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \ReflectionException
     */
    public function install()
    {
        if ($this->request->getMethod() == 'post') {
            $valid = $this->validate(
                [
                    'base_url' => 'regex_match[/^http(s?):\/\/(\w{3}?\.)?[a-z]+\.[[a-z]{2,}$/]',
                    'username' => 'required',
                    'firstname' => 'required',
                    'password' => 'required|matches[password_confirm]|password_rule[8]',
                    'password_confirm' => 'required',
                    'email' => 'required|valid_email|is_unique[users.email]',
                ]
            );
            if (!$valid) {
                return redirect()
                    ->withInput()
                    ->with('flash', lang('Install.invalid_data'))
                    ->redirect("//{$_SERVER['HTTP_HOST']}/install");
            }

            $user = new User();
            $user->username = $this->request->getPost('username');
            $user->password = $this->request->getPost('password');
            $user->firstname = $this->request->getPost('firstname');
            $user->lastname = $this->request->getPost('lastname');
            $user->email = $this->request->getPost('email');
            $user->role = 'admin';

            // cannot create a user -> redirect
            if (!$this->Users->save($user)) {
                return redirect()
                    ->withInput()
                    ->with('flash', lang('Install.save_error'))
                    ->to("//{$_SERVER['HTTP_HOST']}/install");
            }

            $content = "app.baseURL = \"{$this->request->getPost('base_url')}\"\r\n" .
                "app.defaultLocale = {$this->request->getPost('language')}\r\n" .
                "app.appTimezone = {$this->request->getPost('timezone')}\r\n" .
                "cache.handler = file";
            if (!is_writable(ROOTPATH)) {
                $this->session->setFlashdata('flash', lang('Install.success'));
                return view(
                    'Install\Index\env',
                    [
                        'content' => $content
                    ]
                );
            } else {
                file_put_contents(ROOTPATH . '.env', $content);
            }

            // SUCCESS ALL DONE!
            return redirect()->to('/admin')
                ->with('flash', lang('Install.success'));
        }
    }

    /**
     * check permissions are sufficient to install the CMS
     * @param bool $db_writable
     * @param array $permissions
     * @return bool
     */
    private function _insufficientPermissions(bool $db_writable, array $permissions)
    {
        if (!$db_writable) {
            return true;
        }
        foreach ($permissions as $permission) {
            if (!$permission['writable']) {
                return true;
            }
        }

        return false;
    }
}