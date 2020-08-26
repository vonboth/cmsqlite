<?php


namespace Admin\Controllers;

use Admin\Models\UsersModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Tests\Support\Models\UserModel;

/**
 * Class Profile
 * @package Admin\Controllers
 * @property UserModel $Users;
 */
class Profile extends Base
{
    /** @var UserModel $Users */
    private $Users;

    /**
     * Init Controller
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Users = new UsersModel();
    }

    /**
     * Edit my profile
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \ReflectionException
     */
    public function edit()
    {
        $user = $this->AuthService->getUser();
        if ($this->request->getMethod() == 'post') {
            if ($this->validate(
                [
                    'firstname' => 'required',
                    'password' => 'required_with[password,password_confirm]|matches[password_confirm]',
                    'email' => 'required|valid_email'
                ]
            )) {
                $userEntity = $this->Users->find($user['id']);
                $userEntity->firstname = $this->request->getPost('firstname');
                $userEntity->lastname = $this->request->getPost('lastname');
                $userEntity->email = $this->request->getPost('email');
                if ($this->request->getPost('password') && $this->request->getPost('password_confirm')) {
                    $userEntity->password = $this->request->getPost('password');
                }

                try {
                    if ($this->Users->save($userEntity)) {
                        $this->AuthService->updateUser(
                            $this->Users->asArray()->find($userEntity->id)
                        );
                        return redirect()
                            ->back()
                            ->with('flash', lang('General.saved'));
                    } else {
                        return redirect()
                            ->back()
                            ->withInput()
                            ->with('flash', lang('General.save_error'));
                    }
                } catch (\Exception $exception) {
                    return redirect()
                        ->back()
                        ->with('flash', lang($exception->getMessage()));
                }
            } else {
                return redirect()
                    ->back()
                    ->withInput();
            }
        }

        return view(
            'Admin\Profile\edit',
            [
                'section' => lang('User.my_profile'),
                'user' => $user,
                'validator' => $this->validator
            ]
        );
    }
}