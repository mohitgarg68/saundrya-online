<?php

require_once FCPATH . '/vendor/autoload.php';

class Fb_oauth extends CI_Controller
{
	
	public function index()
	{
		$fb = new Facebook\Facebook([
  		'app_id' => '142798826131089', // Replace {app-id} with your app id
  		'app_secret' => 'a6af1c093b1f892488219ce58260324d',
  		'default_graph_version' => 'v2.2',
  		]);

		$helper = $fb->getRedirectLoginHelper();

		$permissions = ['email']; // Optional permissions
		$string = base_url() . 'fb_init';
		$loginUrl = $helper->getLoginUrl($string, $permissions);

		echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
	}
}

?>