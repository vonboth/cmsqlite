<?php


namespace Install\Controllers;


use Admin\Models\Entities\User;
use Admin\Models\UsersModel;
use App\Controllers\Base;

/**
 * Class Index
 * @package Install\Controllers
 *
 * Start controller for installation process
 */
class Index extends Base
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

        $permissions = [
            'root' => substr(sprintf('%o', fileperms(ROOTPATH)), -3),
            'database' => substr(sprintf('%o', fileperms(ROOTPATH . '/database')), -3),
            'writable' => substr(sprintf('%o', fileperms(ROOTPATH . '/writable')), -3),
            'writable/cache' => substr(sprintf('%o', fileperms(ROOTPATH . '/writable/cache')), -3),
            'writable/logs' => substr(sprintf('%o', fileperms(ROOTPATH . '/writable/logs')), -3),
            'writable/session' => substr(sprintf('%o', fileperms(ROOTPATH . '/writable/session')), -3),
            'writable/uploads' => substr(sprintf('%o', fileperms(ROOTPATH . '/writable/uploads')), -3),
            'public/media' => substr(sprintf('%o', fileperms(ROOTPATH . '/public/media')), -3),
        ];

        return view(
            'Install\Index\index',
            compact(
                'db_writable',
                'permissions'
            )
        );
    }

    public function install()
    {
        if ($this->request->getMethod() == 'post') {
            if (!$this->validate(
                [
                    'username' => 'required',
                    'firstname' => 'required',
                    'password' => 'required|matches[password_confirm]|password_rule[8]',
                    'password_confirm' => 'required',
                    'email' => 'required|valid_email',
                    'base_url' => 'required'
                ]
            )) {
                return redirect()
                    ->withInput()
                    ->with('flash', lang('Install.invalid_data'))
                    ->back();
            }

            $user = new User();
            $user->username = $this->request->getPost('username');
            $user->password = $this->request->getPost('password');
            $user->firstname = $this->request->getPost('firstname');
            $user->lastname = $this->request->getPost('lastname');
            $user->email = $this->request->getPost('email');
            $user->role = 'admin';

            if (!$this->Users->save($user)) {
                return redirect()->back()
                    ->withInput()
                    ->with('flash', lang('Install.save_error'));
            }

            // SUCCESS ALL DONE!
            touch(ROOTPATH . 'writable/installed');

            return redirect()->to('/admin')
                ->with('flash', lang('Install.success'));
        }
    }
}