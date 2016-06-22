<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome');
	}

	public function login()
	{
		$this->load->view('login_view');
	}
	
	public function customer_signup_first()
	{
		$this->load->view('signup_customer');
	}
	
	public function beautician_signup_first()
	{
		$this->load->view('signup_beautician');
	}

	public function customer_signup()
	{
		$this->form_validation->set_rules('name', 'Name' ,'required');
		$this->form_validation->set_rules('mobileno', 'Mobile Number' ,'required|regex_match[/^\d{10}$/]');
		//$this->form_validation->set_rules('username', 'Username' ,'required');
		$this->form_validation->set_rules('password', 'Password' ,'required');
		$this->form_validation->set_rules('repass', 'Repass' ,'required|callback_checkpass['.$this->input->post('password').']');
		$this->form_validation->set_rules('email', 'Email' ,'required|valid_email|is_unique[login.email]');
		$this->form_validation->set_rules('street', 'Street Address' ,'required');
		$this->form_validation->set_rules('city', 'City' ,'required');
		$this->form_validation->set_rules('state', 'State' ,'required');
		$this->form_validation->set_rules('pincode', 'Pincode' ,'required|regex_match[/^[0-9]{6}$/]');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_checkCaptcha');
		

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('signup_customer');
		}

		else
		{
			//$this->model_users->updateLoginid($this->input->post('email'));
			$address = $this->formatted($this->input->post('street')) . '+' . $this->formatted($this->input->post('city')) . '+' . $this->formatted($this->input->post('state')) . '+' . $this->formatted($this->input->post('pincode'));
			$url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=AIzaSyCo5IHpcilmXnYqQnmeQu8B5EDkeZvI4EE";
			$json = file_get_contents($url);
			$details = json_decode($json, true);
			$lat = $details['results'][0]['geometry']['location']['lat'];
			$lng = $details['results'][0]['geometry']['location']['lng'];
			
			$this->load->model('model_users');

			$data_login = array(
					//'username' => $this->input->post('username'),
					'password_hash' => md5($this->input->post('password')),
					'email' => $this->input->post('email'),
					'role' => 'customer',
					'status' => 1,
				);

			$data_customer = array(
					'name' => $this->input->post('name'),
					'mobileno' => $this->input->post('mobileno'),
					'street' => $this->input->post('street'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'pincode' => $this->input->post('pincode'),
					'email' => $this->input->post('email'),
					'lat' => $lat,
					'lng' => $lng
				);
			$this->model_users->insert_customer($data_login, $data_customer);
			$this->load->view('success');
		}
		
	}

	public function beautician_signup()
	{
		$this->form_validation->set_rules('name', 'Name' ,'required');
		$this->form_validation->set_rules('mobileno', 'Mobile Number' ,'required|regex_match[/^\d{10}$/]');
		//$this->form_validation->set_rules('username', 'Username' ,'required');
		$this->form_validation->set_rules('password', 'Password' ,'required');
		$this->form_validation->set_rules('repass', 'Repass' ,'required|callback_checkpass['.$this->input->post('password').']');
		$this->form_validation->set_rules('email', 'Email' ,'required|valid_email|is_unique[login.email]');
		$this->form_validation->set_rules('street', 'Street Address' ,'required');
		$this->form_validation->set_rules('city', 'City' ,'required');
		$this->form_validation->set_rules('state', 'State' ,'required');
		$this->form_validation->set_rules('pincode', 'Pincode' ,'required|regex_match[/^[0-9]{6}$/]');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_checkCaptcha');
		$this->form_validation->set_rules('jobset[]', 'JobSet', 'required');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('signup_beautician');
		}

		else
		{
			$address = $this->formatted($this->input->post('street')) . '+' . $this->formatted($this->input->post('city')) . '+' . $this->formatted($this->input->post('state')) . '+' . $this->formatted($this->input->post('pincode'));
			$url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=AIzaSyCo5IHpcilmXnYqQnmeQu8B5EDkeZvI4EE";
			$json = file_get_contents($url);
			$details = json_decode($json, true);
			$lat = $details['results'][0]['geometry']['location']['lat'];
			$lng = $details['results'][0]['geometry']['location']['lng'];
			$this->load->model('model_users');

			$data_login = array(
					//'username' => $this->input->post('username'),
					'password_hash' => md5($this->input->post('password')),
					'email' => $this->input->post('email'),
					'role' => 'beautician',
					'status' => 1,
				);
			if(!$this->input->post('certification'))
			{
				$certification = 'NA';
			}
			else
			{
				$certification = $this->input->post('certification');
			}
			if($this->input->post('jobset[]'))
			{
				$jobset_data = implode(", ", $this->input->post('jobset[]'));
			}
			else
			{
				$jobset_data = "null";
			}
			
			$data_beautician = array(
					'name' => $this->input->post('name'),
					'mobileno' => $this->input->post('mobileno'),
					'street' => $this->input->post('street'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'pincode' => $this->input->post('pincode'),
					'email' => $this->input->post('email'),
					'jobset' => $jobset_data,
					'certification' => $certification,
					'lat' => $lat,
					'lng' => $lng,
				);
			$this->model_users->insert_beautician($data_login, $data_beautician);
			$this->load->view('success');
		}
	}

	public function askRole_google()
	{
		$this->load->view('ask_role_google');
	}

	public function askRole_facebook()
	{
		$this->load->view('ask_role_facebook');
	}

	public function set_role_customer()
	{
		$this->session->set_userdata('signup_role', 'customer');
		if($this->session->userdata('login_service') == 'google')
		{
			redirect('google_oauth');
		}
		elseif($this->session->userdata('login_service') == 'facebook')
		{
			redirect('fb_oauth');
		}
	}

	public function set_role_beautician()
	{
		$this->session->set_userdata('signup_role', 'beautician');
		if($this->session->userdata('login_service') == 'google')
		{
			redirect('google_oauth');
		}
		elseif($this->session->userdata('login_service') == 'facebook')
		{
			redirect('fb_oauth');
		}
	}

	public function formatted($string)
	{
		$length = strlen($string);
		for($a=0; $a<$length; $a++)
		{
			if($string[$a] == ' ')
			{
				$string[$a] = '+';
			}
		}
		return $string;
	}

	public function checkpass($pass, $repass)
	{
		if($repass == $pass)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('checkpass', 'Passwords Don\'t match!');
			return FALSE;
		}
	}

	public function checkCaptcha($captcha)
	{
		if($this->session->userdata('captchaWord') == $captcha)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('checkCaptcha', 'Please fill in the Captcha String Correctly!');
			return false;
		}
	}

	public function google_customer_view_signup()
	{
		$this->load->view('signup_customer_google');
	}

	public function google_beautician_view_signup()
	{
		$this->load->view('signup_beautician_google');
	}

	public function facebook_customer_view_signup()
	{
		$this->load->view('signup_customer_facebook');
	}

	public function facebook_beautician_view_signup()
	{
		$this->load->view('signup_beautician_facebook');
	}

	public function facebook_customer_signup()
	{
		$this->form_validation->set_rules('mobileno', 'Mobile Number' ,'required|regex_match[/^\d{10}$/]');
		//$this->form_validation->set_rules('username', 'Username' ,'required');
		$this->form_validation->set_rules('street', 'Street Address' ,'required');
		$this->form_validation->set_rules('city', 'City' ,'required');
		$this->form_validation->set_rules('state', 'State' ,'required');
		$this->form_validation->set_rules('pincode', 'Pincode' ,'required|regex_match[/^[0-9]{6}$/]');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_checkCaptcha');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('signup_customer_facebook');
		}

		else
		{
			$address = $this->formatted($this->input->post('street')) . '+' . $this->formatted($this->input->post('city')) . '+' . $this->formatted($this->input->post('state')) . '+' . $this->formatted($this->input->post('pincode'));
			$url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=AIzaSyCo5IHpcilmXnYqQnmeQu8B5EDkeZvI4EE";
			$json = file_get_contents($url);
			$details = json_decode($json, true);
			$lat = $details['results'][0]['geometry']['location']['lat'];
			$lng = $details['results'][0]['geometry']['location']['lng'];

			$this->load->model('model_users');

			$data_login = array(
					//'username' => $this->input->post('username'),
					'password_hash' => 'NA',
					'email' => $this->session->userdata('email'),
					'role' => 'customer',
					'status' => 1,
				);

			$data_customer = array(
					'name' => $this->session->userdata('name'),
					'mobileno' => $this->input->post('mobileno'),
					'street' => $this->input->post('street'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'pincode' => $this->input->post('pincode'),
					'email' => $this->session->userdata('email'),
					'lat' => $lng,
					'lng' => $lng
				);
			$this->model_users->insert_customer($data_login, $data_customer);
			$status = $this->model_users->getStatus($this->session->userdata('email'));
			$data['status'] = $status;
			$this->load->view('success');
		}
	}

	public function facebook_beautician_signup()
	{
		$this->form_validation->set_rules('mobileno', 'Mobile Number' ,'required|regex_match[/^\d{10}$/]');
		$this->form_validation->set_rules('street', 'Street Address' ,'required');
		$this->form_validation->set_rules('city', 'City' ,'required');
		$this->form_validation->set_rules('state', 'State' ,'required');
		$this->form_validation->set_rules('pincode', 'Pincode' ,'required|regex_match[/^[0-9]{6}$/]');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_checkCaptcha');
		$this->form_validation->set_rules('jobset[]', 'JobSet', 'required');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('signup_beautician_facebook');
		}
		else
		{
			$address = $this->formatted($this->input->post('street')) . '+' . $this->formatted($this->input->post('city')) . '+' . $this->formatted($this->input->post('state')) . '+' . $this->formatted($this->input->post('pincode'));
			$url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=AIzaSyCo5IHpcilmXnYqQnmeQu8B5EDkeZvI4EE";
			$json = file_get_contents($url);
			$details = json_decode($json, true);
			$lat = $details['results'][0]['geometry']['location']['lat'];
			$lng = $details['results'][0]['geometry']['location']['lng'];
			$this->load->model('model_users');

			$data_login = array(
					'password_hash' => 'NA',
					'email' => $this->session->userdata('email'),
					'role' => 'beautician',
					'status' => 1,
				);

			$jobset_data = implode(",", $this->input->post('jobset[]'));

			$data_beautician = array(
					'name' => $this->session->userdata('name'),
					'mobileno' => $this->input->post('mobileno'),
					'street' => $this->input->post('street'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'pincode' => $this->input->post('pincode'),
					'email' => $this->session->userdata('email'),
					'jobset' => $jobset_data,
					'certification' => 'NA',
					'lat' => $lat,
					'lng' => $lng,
				);
			$this->model_users->insert_beautician($data_login, $data_beautician);
			$status = $this->model_users->getStatus($this->session->userdata('email'));
			$data['status'] = $status;
			$this->load->view('success');
		}
	}

	public function google_customer_signup()
	{
		$this->form_validation->set_rules('mobileno', 'Mobile Number' ,'required|regex_match[/^\d{10}$/]');
		//$this->form_validation->set_rules('username', 'Username' ,'required');
		$this->form_validation->set_rules('street', 'Street Address' ,'required');
		$this->form_validation->set_rules('city', 'City' ,'required');
		$this->form_validation->set_rules('state', 'State' ,'required');
		$this->form_validation->set_rules('pincode', 'Pincode' ,'required|regex_match[/^[0-9]{6}$/]');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_checkCaptcha');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('signup_customer_google');
		}

		else
		{
			$address = $this->formatted($this->input->post('street')) . '+' . $this->formatted($this->input->post('city')) . '+' . $this->formatted($this->input->post('state')) . '+' . $this->formatted($this->input->post('pincode'));
			$url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=AIzaSyCo5IHpcilmXnYqQnmeQu8B5EDkeZvI4EE";
			$json = file_get_contents($url);
			$details = json_decode($json, true);
			$lat = $details['results'][0]['geometry']['location']['lat'];
			$lng = $details['results'][0]['geometry']['location']['lng'];

			$this->load->model('model_users');

			$data_login = array(
					//'username' => $this->input->post('username'),
					'password_hash' => 'NA',
					'email' => $this->session->userdata('email'),
					'role' => 'customer',
					'status' => 1,
				);

			$data_customer = array(
					'name' => $this->session->userdata('name'),
					'mobileno' => $this->input->post('mobileno'),
					'street' => $this->input->post('street'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'pincode' => $this->input->post('pincode'),
					'email' => $this->session->userdata('email'),
					'lat' => $lng,
					'lng' => $lng
				);
			// $this->model_users->insert_customer($data_login, $data_customer);
			// $status = $this->model_users->getStatus($this->session->userdata('email'));
			// $data['status'] = $status;
			//$this->load->view('google_signup', $data);
			$this->load->view('success');
		}
	}

	public function google_beautician_signup()
	{
		$this->form_validation->set_rules('mobileno', 'Mobile Number' ,'required|regex_match[/^\d{10}$/]');
		$this->form_validation->set_rules('street', 'Street Address' ,'required');
		$this->form_validation->set_rules('city', 'City' ,'required');
		$this->form_validation->set_rules('state', 'State' ,'required');
		$this->form_validation->set_rules('pincode', 'Pincode' ,'required|regex_match[/^[0-9]{6}$/]');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_checkCaptcha');
		$this->form_validation->set_rules('jobset[]', 'JobSet', 'required');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('signup_beautician_google');
		}
		else
		{
			$address = $this->formatted($this->input->post('street')) . '+' . $this->formatted($this->input->post('city')) . '+' . $this->formatted($this->input->post('state')) . '+' . $this->formatted($this->input->post('pincode'));
			$url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=AIzaSyCo5IHpcilmXnYqQnmeQu8B5EDkeZvI4EE";
			$json = file_get_contents($url);
			$details = json_decode($json, true);
			$lat = $details['results'][0]['geometry']['location']['lat'];
			$lng = $details['results'][0]['geometry']['location']['lng'];
			$this->load->model('model_users');

			$data_login = array(
					'password_hash' => 'NA',
					'email' => $this->session->userdata('email'),
					'role' => 'beautician',
					'status' => 1,
				);

			$jobset_data = implode(",", $this->input->post('jobset[]'));

			$data_beautician = array(
					'name' => $this->session->userdata('name'),
					'mobileno' => $this->input->post('mobileno'),
					'street' => $this->input->post('street'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'pincode' => $this->input->post('pincode'),
					'email' => $this->session->userdata('email'),
					'jobset' => $jobset_data,
					'certification' => 'NA',
					'lat' => $lat,
					'lng' => $lng,
				);
			// $this->model_users->insert_beautician($data_login, $data_beautician);
			// $status = $this->model_users->getStatus($this->session->userdata('email'));
			// $data['status'] = $status;
			//$this->load->view('google_signup', $data);
			$this->load->view('success');
		}
	}

	// public function fb_signup()
	// {
	// 	$this->form_validation->set_rules('mobileno', 'Mobile Number' ,'required|regex_match[/^\d{10}$/]|is_unique[login.mobileno]');
	// 	$this->form_validation->set_rules('username', 'Username' ,'required');
	// 	$this->form_validation->set_rules('street', 'Street Address' ,'required');
	// 	$this->form_validation->set_rules('city', 'City' ,'required');
	// 	$this->form_validation->set_rules('state', 'State' ,'required');
	// 	$this->form_validation->set_rules('pincode', 'Pincode' ,'required|regex_match[/^[0-9]{6}$/]');
	// 	$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_checkCaptcha');
	// 	$this->load->model('model_users');

	// 	$data_login = array(
	// 			'username' => $this->input->post('username'),
	// 			'password_hash' => 'NA',
	// 			'email' => $this->session->userdata('email'),
	// 			'role' => 'customer',
	// 			'status' => 1,
	// 		);

	// 	$data_customer = array(
	// 			'name' => $this->session->userdata('name'),
	// 			'mobileno' => $this->input->post('mobileno'),
	// 			'street' => $this->input->post('street'),
	// 			'city' => $this->input->post('city'),
	// 			'state' => $this->input->post('state'),
	// 			'pincode' => $this->input->post('pincode'),
	// 			'email' => $this->session->userdata('email')
	// 		);
	// 	$this->model_users->insert_customer($data_login, $data_customer);
	// 	$status = $this->model_users->getStatus($this->session->userdata('email'));
	// 	$data['status'] = $status;
	// 	$this->load->view('fb_signup', $data);
	// }

	public function members()
	{
		$email = $this->session->userdata('email');
		$this->load->model('model_users');
		$role = $this->model_users->getRole($email);
		$data['role'] = $role;
		$this->load->view('members_page', $data);
	}

}
