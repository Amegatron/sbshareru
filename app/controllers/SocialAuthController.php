<?php

class SocialAuthController extends BaseController {

    const VK_USER_DATA_KEY = 'vk.userData';

    public function getVk() {
        $redirectUrl = Config::get('app.url') . '/social-auth/vk';
        $vk = OAuth::consumer('Vkontakte', $redirectUrl);

        $code = Input::get('code');

        if (!empty($code)) {
            $token = $vk->requestAccessToken($code);
            $tokenParams = $token->getExtraParams();

            $vkId = $tokenParams['user_id'];
            $user = User::findByVkId($vkId);

            if ($user) {
                Auth::login($user);
                return Redirect::to('/');
            }

            $params = array(
                'user_ids'  => $vkId,
                'fields'    => 'first_name,last_name,screen_name,email',
            );

            $response = json_decode($vk->request('/users.get?' . http_build_query($params)), true);
            $response = $response['response'];

            $userData = $response[0];
            Session::put(self::VK_USER_DATA_KEY, $userData);
            return Redirect::action('UsersController@getRegisterVk');
        } else {
            $url = $vk->getAuthorizationUri();
            return Redirect::to((string)$url);
        }
    }

    public function getCancel() {
        Session::forget(self::VK_USER_DATA_KEY);
        return Redirect::to('/');
    }
}
