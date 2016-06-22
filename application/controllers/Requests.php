<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requests extends CI_Controller {

	public function new_req()
	{
		$this->load->model('model_users');
		$object = $this->model_users->getRow($this->session->userdata('email'));
		//var_dump($object);die();
		$data['street'] = $object[0]->street;
		$data['city'] = $object[0]->city;
		$data['state'] = $object[0]->state;
		$data['pincode'] = $object[0]->pincode;
		$this->session->set_userdata('data', $data);
		$this->load->view('new_request', $data);
	}

	public function new_function()
	{
		if($this->input->post('yesno') == "myadd")
		{
			$street = $this->session->userdata('data')['street'];
			$city = $this->session->userdata('data')['city'];
			$state = $this->session->userdata('data')['state'];
			$pincode = $this->session->userdata('data')['pincode'];
		}
		else
		{
			$this->form_validation->set_rules('street', 'Street', 'required');
			$this->form_validation->set_rules('city', 'City', 'required');
			$this->form_validation->set_rules('state', 'State', 'required');
			$this->form_validation->set_rules('pincode', 'Pincode', 'required');
			$street = $this->input->post('street');
			$city = $this->input->post('city');
			$state = $this->input->post('state');
			$pincode = $this->input->post('pincode');
		}
		$this->form_validation->set_rules('service[]', 'Service', 'required');
		$this->form_validation->set_rules('time', 'Time', 'required|regex_match[/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/]');
		$this->form_validation->set_rules('date', 'Date', 'required|regex_match[/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/]');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_checkCaptcha');
		$date = $this->input->post('date');
		$time = $this->input->post('time');
		$date_time = nice_date($date, 'Y-m-d') . " " . $time;
		$service = implode(',' , $this->input->post('service[]'));
		$address = $this->formatted($street) . '+' . $this->formatted($city) . '+' . $this->formatted($state) . '+' . $this->formatted($pincode);
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=AIzaSyCo5IHpcilmXnYqQnmeQu8B5EDkeZvI4EE";
		$json = file_get_contents($url);
		$details = json_decode($json, true);
		$lat = $details['results'][0]['geometry']['location']['lat'];
		$lng = $details['results'][0]['geometry']['location']['lng'];
		$data = array(
			'email_customer' => $this->session->userdata('email'),
			'service' => $service,
			'date_time' => $date_time,
			'street' => $street,
			'city' => $city,
			'state' => $state,
			'pincode' => $pincode,
			'lat' => $lat,
			'lng' => $lng,
			);
		$this->load->model('model_users');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('new_request');
		}
		else
		{
			$this->model_users->insert_request($data);
			redirect('main/members');
		}

	}

	public function old_req()
	{

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

}
