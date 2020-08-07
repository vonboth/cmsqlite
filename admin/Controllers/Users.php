<?php


namespace Admin\Controllers;

use Admin\Models\Entities\User;
use Admin\Models\UsersModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Users
 * @package Admin\Controllers
 * @property UsersModel $Users
 */
class Users extends Base
{
    protected $Users;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Users = new UsersModel();
    }

    public function index()
    {
        return view(
            'Admin\Users\index',
            ['users' => $this->Users->findAll()]
        );
    }

    public function view($id = null)
    {
        return view(
            'Admin\Users\view',
            ['user' => $this->Users->find($id)]
        );
    }

    public function add()
    {
        $user = new User();
        if ($this->request->getMethod() == 'post') {
            if ($this->validate(
                [
                    'username' => 'required',
                    'password' => 'required|min_length[8]|matches[password_confirm]',
                    'password_confirm' => 'required',
                    'email' => 'required|valid_email',
                    'role' => 'required',
                ]
            )) {
                $user->fill($this->request->getPost());
                if ($lastId = $this->Users->insert($user) !== false) {
                    return redirect("/admin/users/edit/$lastId")
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

    // TODO: Validation rules for updating a user
    public function edit($id = null)
    {
        $user = $this->Users->find($id);
        if ($this->request->getMethod() == 'post') {
            if ($this->validate(
                [
                    'username' => 'required',
                    //'password' => 'required_with[password,password_confirm]|matches[password_confirm]',
                    'password' => 'password_update[8,password_confirm]',
                    'email' => 'required|valid_email',
                    'role' => 'required',
                ]
            )) {
                $user->fill($this->request->getPost());
                if ($this->Users->save($user)) {
                    return redirect()
                        ->back()
                        ->with('flash', lang('General.saved'));
                } else {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('flash', lang('General.save_error'));
                }
            } else {
                return redirect()
                    ->back()
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