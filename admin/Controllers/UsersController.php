<?php


namespace Admin\Controllers;

use Admin\Models\Entities\User;
use Admin\Models\UsersModel;

/**
 * Class Users
 * @package Admin\Controllers
 * @property UsersModel $Users
 */
class UsersController extends BaseController
{
    /** @var UsersModel $Users */
    protected $Users;

    /**
     * @inheritdoc
     */
    public function initialize(): void
    {
        $this->Users = new UsersModel();
    }

    /**
     * view all users / starting point
     * @return string
     */
    public function index()
    {
        return view(
            'Admin\Users\index',
            ['users' => $this->Users->findAll()]
        );
    }

    /**
     * view single user
     * @param null $id
     * @return string
     */
    public function view($id = null)
    {
        return view(
            'Admin\Users\view',
            ['user' => $this->Users->find($id)]
        );
    }

    /**
     * add a new user
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \ReflectionException
     */
    public function add()
    {
        $user = new User();
        if ($this->request->getMethod() == 'post') {
            if ($this->validate(
                [
                    'username' => 'required',
                    'firstname' => 'required',
                    'password' => 'required|matches[password_confirm]|password_rule[8]',
                    'password_confirm' => 'required',
                    'email' => 'required|valid_email',
                    'role' => 'required',
                ]
            )) {
                $user->fill($this->request->getPost());
                if ($this->Users->insert($user) !== false) {
                    return redirect()
                        ->to('/admin/users/edit/' . $this->Users->getInsertID())
                        ->with('flash', lang('General.saved'));
                } else {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('flash', lang('Genreal.save_error'));
                }
            } else {
                return redirect()
                    ->back()
                    ->withInput();
            }
        }

        return view(
            'Admin\Users\add',
            [
                'validator' => $this->validator,
                'user' => $user
            ]
        );
    }

    /**
     * edit a user
     * @param null $id
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function edit($id = null)
    {
        $user = $this->Users->find($id);
        if ($this->request->getMethod() == 'post') {
            if ($this->validate(
                [
                    'username' => 'required',
                    'firstname' => 'required',
                    'password' => 'required_with[password,password_confirm]|matches[password_confirm]|password_rule[8]',
                    'email' => 'required|valid_email',
                    'role' => 'required',
                ]
            )) {
                $user->username = $this->request->getPost('username');
                $user->email = $this->request->getPost('email');
                $user->firstname = $this->request->getPost('firstname');
                $user->lastname = $this->request->getPost('lastname');
                $user->role = $this->request->getPost('role');
                if ($this->request->getPost('password') && $this->request->getPost('password_confirm')) {
                    $user->password = $this->request->getPost('password');
                }

                try {
                    if ($this->Users->save($user)) {
                        return redirect()
                            ->to('/admin/users/edit/' . $id)
                            ->with('flash', lang('General.saved'));
                    } else {
                        return redirect()
                            ->to('/admin/users/edit/' . $id)
                            ->withInput()
                            ->with('flash', lang('General.save_error'));
                    }
                } catch (\Exception $exception) {
                    return redirect()
                        ->to('/admin/users/edit/' . $id)
                        ->with('flash', $exception->getMessage());
                }
            } else {
                return redirect()
                    ->to('/admin/users/edit/' . $id)
                    ->withInput();
            }
        }

        return view(
            'Admin\Users\edit',
            [
                'validator' => $this->validator,
                'user' => $user,
            ]
        );
    }

    /**
     * delete single user
     * @param null $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($id = null)
    {
        if ($this->Users->delete($id)) {
            return redirect()
                ->back()
                ->with('flash', lang('General.deleted'));
        } else {
            return redirect()
                ->back()
                ->with('flash', lang('General.delete_error'));
        }
    }
}
