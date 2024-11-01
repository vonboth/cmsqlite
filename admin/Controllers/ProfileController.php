<?php


namespace Admin\Controllers;

use Admin\Models\UsersModel;

/**
 * Class Profile
 * @package Admin\Controllers
 * @property UsersModel $Users;
 */
class ProfileController extends BaseController
{
  /** @var UsersModel $Users */
  private $Users;

  /**
   * Init Controller
   */
  public function initialize(): void
  {
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
    if ($this->request->getMethod() === 'POST') {
      if ($this->validate(
        [
          'firstname' => 'required',
          'password' => 'required_with[password,password_confirm]|matches[password_confirm]|password_rule[8]',
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
              ->with('flash', lang('admin.saved'));
          } else {
            return redirect()
              ->back()
              ->withInput()
              ->with('flash', lang('admin.save_error'));
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
        'section' => lang('admin.user.my_profile'),
        'user' => $user,
        'validator' => $this->validator
      ]
    );
  }
}
