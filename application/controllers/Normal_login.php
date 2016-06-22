<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Normal_login extends CI_Controller 
{

	public function first()
	{
		$this->load->view('normalLogin');
	}
	
	public function index()
	{
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$this->load->model('model_users');
		if($this->form_validation->run())
		{	
			if($this->model_users->validateLogin($email, $password))
			{
				$this->session->set_userdata('email', $email);
				redirect('main/members');
			}
			else
			{
				$this->load->view('normalLogin');
			}
		}
		else
		{
			$this->load->view('normalLogin');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('main');
	}

}

?>
