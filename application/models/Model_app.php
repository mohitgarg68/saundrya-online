<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_app extends CI_Model 
{
	public function get_row($email)
	{
		$query_str = "SELECT * FROM `login` WHERE `email`='$email'";
		$query = $this->db->query($query_str);
		return $query->result();
	}

	public function get_details($email, $password)
	{
		$query_str = "SELECT * FROM `login` WHERE `email` = '$email' AND `password_hash`='$password'";
		$query = $this->db->query($query_str);
		$result = $query->result();
		$role = $result[0]->role;
		//var_dump($role);die();
		$response = array();
		while($result)
		{
			if($role == 'customer')
			{
				$query_cust = "SELECT * FROM `customer` WHERE `email`='$email'";
				$customer = $this->db->query($query_cust)->result()[0];
				while($customer)
				{
					$response = array(
					"name" => $customer->name,
					"email" => $result[0]->email,
					"role" => $result[0]->role,
					"mobile" => $customer->mobileno,
					"street" => $customer->street,
					"city" => $customer->city,
					"state" => $customer->state,
					"pincode" => $customer->pincode,
					"lat" => $customer->lat,
					"lng" => $customer->lng,
					"succ" => "true"
					);
				}
			}

			elseif($role == 'beautician')
			{
				$query_str = "SELECT * FROM `beautician` WHERE `email`='$email'";
				$beautician = $this->db->query($query_str)->result()[0];
				while($beautician)
				{
					$response = array(
						"name" => $beautician->name,
						"email" => $result[0]->email,
						"role" => $result[0]->role,
						"mobile" => $beautician->mobileno,
						"street" => $beautician->street,
						"city" => $beautician->city,
						"state" => $beautician->state,
						"pincode" => $beautician->pincode,
						"lat" => $beautician->lat,
						"lng" => $beautician->certification,
						"jobset" => $beautician->jobset,
						"succ" => "true"
						);
				}
			}
		}
		return $response;	
	}

	public function get_details_email($email)
	{
		$query_str = "SELECT * FROM `login` WHERE `email` = '$emexist";
		$query = $this->db->query($query_str);
		$result = $query->result();
		$role = $result[0]->role;
		//var_dump($role);die();
		$response = array();
		while($result)
		{
			if($role == 'customer')
			{
				$query_cust = "SELECT * FROM `customer` WHERE `email`='$email'";
				$customer = $this->db->query($query_cust)->result()[0];
				while($customer)
				{
					$response = array(
					"name" => $customer->name,
					"email" => $result[0]->email,
					"role" => $result[0]->role,
					"mobile" => $customer->mobileno,
					"street" => $customer->street,
					"city" => $customer->city,
					"state" => $customer->state,
					"pincode" => $customer->pincode,
					"lat" => $customer->lat,
					"lng" => $customer->lng,
					"exist" => "yes"
					);
				}
			}

			elseif($role == 'beautician')
			{
				$query_str = "SELECT * FROM `beautician` WHERE `email`='$email'";
				$beautician = $this->db->query($query_str)->result()[0];
				while($beautician)
				{
					$response = array(
						"name" => $beautician->name,
						"email" => $result[0]->email,
						"role" => $result[0]->role,
						"mobile" => $beautician->mobileno,
						"street" => $beautician->street,
						"city" => $beautician->city,
						"state" => $beautician->state,
						"pincode" => $beautician->pincode,
						"lat" => $beautician->lat,
						"lng" => $beautician->certification,
						"jobset" => $beautician->jobset,
						"exist" => "yes"
						);
				}
			}
		}
		return $response;
	}

	public function insert_beautician($data_login, $data_details)
	{
		if($this->db->insert('login', $data_login))
		{
			if($this->db->insert('beautician', $data_details))
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}
		else
		{
			return 2;
		}
		
	}

	public function insert_customer($data_login, $data_details)
	{
		if($this->db->insert('login', $data_login))
		{
			if($this->db->insert('customer', $data_details))
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}
		else
		{
			return 2;
		}
	}

	public function accept_request($data, $id)
	{
		$this->db->where('id', $id);
		if($this->db->update('request', $data))
		{
			return 1;
		}
		else
		{
			return 2;
		};
	}
}
