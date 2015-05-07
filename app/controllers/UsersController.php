<?php

class UsersController extends BaseController {
    public function getRegister() {
        if (!Config::get('app.isRegistrationEnabled')) {
            return $this->getMessage("На данный момент регистрация закрыта.");
        }

        return View::make('users/register');
    }

    public function getRegisterVk() {
        if (!Session::has(SocialAuthController::VK_USER_DATA_KEY)) {
            App::abort(403, "Access denied");
        }

        $userData = Session::get(SocialAuthController::VK_USER_DATA_KEY);

        return View::make('users/register-vk', array(
            'userData'  => $userData,
        ));
    }

    public function postRegister() {
        $rules = User::$validation['register'];

        $validation = Validator::make(Input::all(), $rules);

        if ($validation->fails()) {
            return Redirect::to('users/register')->withErrors($validation)->withInput();
        }

        $user = new User();
        $user->fill(Input::all());
        $id = $user->register();
        return $this->getMessage("Регистрация почти завершена. Вам необходимо подтвердить e-mail, указанный при регистрации, перейдя по ссылке в письме.");
    }

    public function postRegisterVk() {
        $rules = User::$validation['register-vk'];

        $validation = Validator::make(Input::all(), $rules);

        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        $userData = Session::get(SocialAuthController::VK_USER_DATA_KEY);
        $vkId = $userData['uid'];

        $user = new User();
        $user->email = Input::get('email');
        $user->username = Input::get('username');
        $user->isActive = true;
        $user->vkid = $vkId;
        $result = $user->save();

        if ($result) {
            Auth::login($user);
            Session::forget(SocialAuthController::VK_USER_DATA_KEY);
        }

        return Redirect::to('/');
    }

    public function getActivate($userId, $activationCode) {
        $user = User::find($userId);
        if (!$user) {
            return $this->getMessage("Неверная ссылка на активацию акаунта (1)");
        }

        if ($activationCode == $user->activationCode) {
            $user->activate();
            Auth::login($user);
            return $this->getMessage("Аккаунт активирован", "/");
        }

        return $this->getMessage("Невернаяя ссылка на активацию аккаунта (2)");
    }

    public function getResendActivationLetter($username) {
        $user = User::where('username', '=', $username)->limit(1)->first();
        if ($user)
        {
            $user->sendActivationMail();
            return $this->getMessage('Письмо со ссылкой для активации было выслано.');
        }

        return $this->getMessage('Пользователь с таким адресом не зарегистрирован.');
    }

    public function getLogin() {
        return View::make('users/login');
    }

    public function postLogin() {
        $creds = array(
            //'username' => Input::get('username'),
            'password' => Input::get('password'),
            'isActive'  => 1,
        );

        $username = Input::get('username');
        if (strpos($username, '@')) {
            $creds['email'] = $username;
        } else {
            $creds['username'] = $username;
        }

        if (Auth::attempt($creds, Input::has('remember'))) {
            Log::info("User [{$username}] successfully logged in.");
            return Redirect::intended();
        } else {
            Log::info("User [{$username}] failed to login.");
        }

        $link = action('UsersController@getResendActivationLetter', array($creds['username']));

        $alert = "Неверная комбинация email/пароль. <a href='/password/remind'>Забыли пароль?</a><br />";
        $alert .= "Либо учетная запись еще не активирована. <a href='{$link}'>Выслать повторно письмо с активацией</a>?";

        return Redirect::back()->withAlert($alert);
    }

    public function getLogout() {
        Auth::logout();
        return Redirect::intended();
    }
}
