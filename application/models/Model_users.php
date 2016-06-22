<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_users extends CI_Model {


	public function getRow($email)
	{
		$query_str = "SELECT * FROM `customer` WHERE `email`= '$email'";
		$object = $this->db->query($query_str)->result();
		return $object;
	}

	public function insert_customer($data_login, $data_customer)
	{
		$this->db->insert('login', $data_login);
		$this->db->insert('customer', $data_customer);
		return true;
	}

	public function insert_beautician($data_login, $data_beautician)
	{
		$this->db->insert('login', $data_login);
		$this->db->insert('beautician', $data_beautician);
		return true;
	}

	public function insert_request($data)
	{
		$this->db->insert('request', $data);
	}

	public function updateLoginid($email)
	{
		$query_str = "SELECT `id` FROM `login` WHERE `email` = '$email'";
		$query = $this->db->query($query_str);
		foreach($query->result() as $row)
		{
			$loginid = $row->id;
			$this->db->where('email', $email);
			$this->db->update('customer', array('loginid' => $loginid));
		}
	}

	public function getStatus($email)
	{
		$query_str = "SELECT `status` FROM `login` WHERE `email` = '$email'";
		$query = $this->db->query($query_str);
		// $result = $query->num_rows();
		// if($result == 0 || $result == NULL)
		// {
		// 	return 0;
		// }
		// else
		// {
		// 	return 1;
		// }
		$query_result = $query->result();
		$status = $query_result[0]->status;
		if($status == 0 || !$status)
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}

	public function validateLogin($email, $password)
	{
		$query_str = "SELECT `password_hash` FROM `login` WHERE `email` = '$email'";
		$query = $this->db->query($query_str);
		//var_dump($query->result());die();
		if($query->result()!=NULL && $query->result()[0]->password_hash == md5($password))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function getRole($email)
	{
		$query_str = "SELECT `role` FROM `login` WHERE `email` = '$email'";
		$query_result = $this->db->query($query_str)->result();
		if($query_result != NULL)
		{
			$role = $query_result[0]->role;
			return $role;
		}
		
	}

	public function get_my_address()
	{
		$logged_email = $this->session->userdata('email');
		$query_str = "SELECT `street`, `city`, `state`, `pincode` FROM `beautician` WHERE `email` = '$logged_email'";
		$query = $this->db->query($query_str);
		$address = $query->row_array()['street'] . ',' . $query->row_array()['city'] . ',' . $query->row_array()['state'] . ',' . $query->row_array()['pincode'];
		return $address;
	}

	public function get_customer_addresses()
	{
		$my_email = $this->session->userdata('email');
		$query_str2 = "SELECT `jobset` FROM `beautician` WHERE `email` = '$my_email'";
		$query2 = $this->db->query($query_str2);
		foreach($query2->result() as $slow)
		{
			$jobset = $slow->jobset;
			$this->session->set_userdata(['jobset' => $jobset]);
		}

		$query_str = "SELECT `email_customer`, `service` FROM `request`";
		$query = $this->db->query($query_str);
		$address_sim = $query->result();
		$a=0;
		foreach($address_sim as $mediator)
		{
			$service = $mediator->service;
			$pattern = '/' . $service . '/';
			$subject = $this->session->userdata('jobset');
			if(preg_match($pattern, $subject) == 1)
			{
				$email[$a] = $mediator->email_customer;
				$email_one = $mediator->email_customer;
				$query_str3 = "SELECT `street`, `city`, `state`, `pincode` FROM `customer` WHERE `email` = '$email_one'";
				$query3 = $this->db->query($query_str3);
				$address_one = $query3->row_array()['street'] . ',' . $query3->row_array()['city'] . ',' . $query3->row_array()['state'] . ',' . $query3->row_array()['pincode'];
				$address[$a] = $address_one;
				$a++;
			}

		}
		
		//Format the beautician as well as customer addresses

		$b = count($address);
		for($p=0; $p<$b; $p++)
		{
			$format_customer_add[$p] = str_replace(' ', '+', $address[$p]);
		}
		$format_my_add = str_replace(' ', '+', $this->session->userdata('my_address'));
		
		//make a distance array
		for($f = 0; $f<count($address); $f++)
		{
			$url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=" . $format_my_add . "&destinations=" . $format_customer_add[$f] . "&key=AIzaSyBrbRiH6PEBI7RatZcBwnokKyfdeVT-h9s";
			$json = file_get_contents($url);
			$details = json_decode($json, true);
			$distance_array[$f] = $details['rows'][0]['elements'][0]['distance']['value'];
		}

		//Now we will sort distance array in ascending order and simultaneously swap address and email array
		//Apply selection sort
		$n = count($distance_array);
		for($c=0; $c<($n-1); $c++)
		{
			$position = $c;
			for($d=($c+1); $d<$n; $d++)
			{
				if($distance_array[$position] > $distance_array[$d])
				{
					$position = $d;

				}
			}
			if($position != $c)
			{
				$swap = $distance_array[$c];
				$distance_array[$c] = $distance_array[$position];
				$distance_array[$position] = $swap;

				$swap = $address[$c];
				$address[$c] = $address[$position];
				$address[$position] = $swap;

				$swap = $email[$c];
				$email[$c] = $email[$position];
				$email[$position] = $swap;
			}
		}
		$final_addresses = array();
		for($m =0; $m<4; $m++)
		{
			$final_addresses[$m] = $address[$m];
		}

		return $final_addresses;
	}

}
