<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class App extends CI_Controller {
	
	public function check_email()
	{
		error_reporting(0);
		$email = $this->input->post('email');
		$this->load->model('model_app');
		$result = $this->model_app->get_row($email);
		$response = array();
		if($result)
		{
			$response = array("exist" => "yes");
		}

		echo json_encode(array("user_data"=>$response));
	}

	public function login()
	{
		error_reporting(0);
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$this->load->model('model_app');
		$response = $this->model_app->get_details($email, $password);
		echo json_encode(array("user_data"=>$response));
	}

	public function login_from_email()
	{
		error_reporting(0);
		$email = $this->input->post('email');
		$this->load->model('model_app');
		$response = $this->model_app->get_details_email($email);
		echo json_encode(array("user_data"=>$response));
	}

	public function register_beautician()
	{
		error_reporting(0);
		$name = $this->input->post('name');
		$password = $this->input->post('password');
		$email = $this->input->post('email');
		$role = $this->input->post('role');
		$mobile = $this->input->post('mobile');
		$street = $this->input->post('street');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$pincode = $this->input->post('pincode');
		$jobset = $this->input->post('jobset');
		$certification = $this->input->post('certification');
		$lat = $this->input->post('lat');
		$lng = $this->input->post('lng');

		$data_login = array(
			'password_hash' => $password,
			'email' => $email,
			'role' => $role
			);

		$data_details = array(
			'name' => $name,
			'street' => $street,
			'city' => $city,
			'state' => $state,
			'pincode' => $pincode,
			'mobileno' => $mobile,
			'email' => $email,
			'jobset' => $jobset,
			'certification' => $certification,
			'lat' => $lat,
			'lng' => $lng
			);

		$this->load->model('model_app');
		$status = $this->model_app->insert_beautician($data_login, $data_details);
		if($status == 1)
		{
			$response = array("succ"=>"true");
			echo json_encode(array("user_data"=>$response));
		}
		elseif($status == 2)
		{
			echo '{"message":"Unable to save the data to the database."}';
		}
	}

	public function register_customer()
	{
		error_reporting(0);
		$name = $this->input->post('name');
		$password = $this->input->post('password');
		$email = $this->input->post('email');
		$role = $this->input->post('role');
		$mobile = $this->input->post('mobile');
		$street = $this->input->post('street');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$pincode = $this->input->post('pincode');
		$lat = $this->input->post('lat');
		$lng = $this->input->post('lng');

		$data_login = array(
			'password_hash' => $password,
			'email' => $email,
			'role' => $role
			);

		$data_details = array(
			'name' => $name,
			'street' => $street,
			'city' => $city,
			'state' => $state,
			'pincode' => $pincode,
			'mobileno' => $mobile,
			'email' => $email,
			'lat' => $lat,
			'lng' => $lng
			);

		$this->load->model('model_app');
		$status = $this->model_app->insert_customer($data_login, $data_details);
		if($status == 1)
		{
			$response = array("succ"=>"true");
			echo json_encode(array("user_data"=>$response));
		}
		elseif($status == 2)
		{
			echo '{"message":"Unable to save the data to the database."}';
		}

	}

	public function accept_request()
	{
		error_reporting(0);
		$email_beautician = $this->input->post('email_beautician');
		$id = $this->input->post('id');
		$data = array("email_beautician" => $email_beautician);
		$this->load->model('model_app');
		$status = $this->model_app->accept_request($data, $id);
		$response = array();
		if($status == 1)
		{
			$response = array("succ"=>"true");
		}
		echo json_encode(array("user_data"=>$response));
	}

	public function get_requests()
	{
		error_reporting(0);
		require "init.php";
		 
		$lat = $_POST["lat"];
		$lng = $_POST["lng"];

		//$lat = 30.7609018563206;
		//$lng = 76.7885863780975;

		$rad = 10;

		$lowLat = $lat - ($rad/110.574);
		$highLat = $lat + ($rad/110.574);

		$lowLng = $lng - ($rad/(111.32 * cos($lat)));
		$highLng = $lng + ($rad/(111.32 * cos($lat)));

		//echo $date = date('Y-m-d H:i:s');
		//echo $lowLat."\n";
		//echo $highLat."\n";
		//echo $lowLng."\n";
		//echo $highLng."\n";
		 
		$sql = "SELECT * FROM `request` WHERE ".
			"( `lat` BETWEEN ".$lowLat." AND ".$highLat." ) AND ".
			"( `lng` BETWEEN ".$lowLng." AND ".$highLng.");";
		 
		$result = mysqli_query($con, $sql);
		 
		$response = array();
		 
		while($row = mysqli_fetch_array($result)){
			if ($row['email_beautician'] == ''){
				$email = $row['email_customer'];
				$sqlC = "SELECT * FROM `customer` WHERE `email`='".$email."';";
				$resultC = mysqli_query($con, $sqlC);
				while($rowC = mysqli_fetch_array($resultC)){
					array_push($response, array("id"=>$row['id'],"name"=>$rowC['name'],"mobile"=>$rowC['mobileno'],"email"=>$row['email_customer'],"date_time"=>$row['date_time'],"street"=>$row['street'],"city"=>$row['city'],"state"=>$row['state'],"pincode"=>$row['pincode'],"lat"=>$row['lat'],"lng"=>$row['lng'],"service"=>$row['service'],"succ"=>"true"));
				}
			}
		}
		 
		echo json_encode(array("user_data"=>$response));
	}

}
