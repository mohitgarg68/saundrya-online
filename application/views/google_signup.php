<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Continue|User</title>
</head>
<body>
	<?php 
		if (isset($authUrl)){ ?>
		<h2>CodeIgniter Login With Google Oauth PHP</h2>
		<a href="<?php echo $authUrl; ?>"><img id="google_signin" src="<?php echo base_url(); ?>images/google_login.png" width="10%" ></a>
		<?php }
		elseif(isset($userData) && $status == 0 && $this->session->userdata('signup_role') == 'customer') 
		{

			$this->session->set_userdata('name', $userData->name);
			$this->session->set_userdata('email', $userData->email);
			redirect('main/google_customer_view_signup');
		}
		elseif(isset($userData) && $status == 0 && $this->session->userdata('signup_role') == 'beautician')
		{
			$this->session->set_userdata('name', $userData->name);
			$this->session->set_userdata('email', $userData->email);
			redirect('main/google_beautician_view_signup');
		}
		elseif($status == 1){
			$this->session->set_userdata('name', $userData->name);
			$this->session->set_userdata('email', $userData->email);
			redirect('main/members');
		}
		?>

</body>