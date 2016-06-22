<?php

//session_start();

class Google_oauth extends CI_Controller
{
	// public function __construct()
	// {
	// 	parent::__construct();
	// }

	public function index()
	{
		require_once FCPATH . "vendor/autoload.php";
		//require_once FCPATH . "vendor/google/apiclient/src/Google/autoload.php";
		//include_once FCPATH . "vendor/google/apiclient/src/Google/Client.php";
		//include_once FCPATH . "vendor/google/apiclient/src/Google/Oauth2.php";


		$client_id = '833350554032-376beiugltt4cqvo5a1789f3jn2algd7.apps.googleusercontent.com';
		$client_secret = 'lMUFe99wqp7ClEwKL88vsd-K';
		//$redirect_uri = 'http://mgdevx.ultimatefreehost.in/saundarya/google_oauth';
		$redirect_uri = base_url() . 'google_oauth';
		$simple_api_key = 'AIzaSyCo5IHpcilmXnYqQnmeQu8B5EDkeZvI4EE';

		$client = new Google_Client();
		$client->setApplicationName("Saundarya Project");
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);
		$client->setDeveloperKey($simple_api_key);
		$client->addScope("https://www.googleapis.com/auth/userinfo.email");

		$objOAuthService = new Google_Service_Oauth2($client);

		if(isset($_GET['code']))
		{
			$client->authenticate($_GET['code']);
			$_SESSION['access_token'] = $client->getAccessToken();
			header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		}

		if(isset($_SESSION['access_token']) && $_SESSION['access_token'])
		{
			$client->setAccessToken($_SESSION['access_token']);
		}

		if($client->getAccessToken())
		{
			$userdata = $objOAuthService->userinfo->get();
			$data['userData'] = $userdata;
			$_SESSION['access_token'] = $client->getAccessToken();
		}
		else
		{
			$authUrl = $client->createAuthUrl();
			$data['authUrl'] = $authUrl;
		}
		if(isset($data['userData']))
		{
			$this->load->model('model_users');
			$status = $this->model_users->getStatus($data['userData']->email);
			$data['status'] = $status;
		}

		$this->load->view('google_signup', $data);
		// if(isset($data['authUrl']))
		// {
		// 	$this->load->view('')
		// }
	}

	public function logout()
	{
		unset($_SESSION['access_token']);
		redirect(base_url());
	}

}

?>
