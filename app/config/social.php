<?php

return array(
    'providers' => array(
        'vk'    => array(
            'appId'         => $_ENV['VK_APP_ID'],
            'secret'        => $_ENV['VK_APP_SECRET'],
            'scope'         => 'notify,email',
            'redirectUrl'   => 'http://www.sbshare.ru/social-auth/vk',
            'fields'        => array(
                'uid',
                'first_name',
                'last_name',
                'screen_name',
            ),
        ),
    ),
);
