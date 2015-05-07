<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Vkontakte' => array(
            'client_id'     => $_ENV['VK_APP_ID'],
            'client_secret' => $_ENV['VK_APP_SECRET'],
            'scope'         => array(),
        ),		

	)

);
