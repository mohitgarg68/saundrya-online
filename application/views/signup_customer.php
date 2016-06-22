<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Signup|Customer</title>
</head>
<body>
	<h2>Please fill the form below : </h2>
	<?php
		echo form_open('main/customer_signup');
		
		echo validation_errors();

		echo form_label('Full Name : ', 'name');
		echo form_input('name', '');
	?>
	<br>
	<?php
		echo form_label('Mobile Number : ', 'mobileno');
		echo form_input('mobileno', '');
	?>
	<br>
	<!-- <?php
		echo form_label('Username : ', 'username');
		echo form_input('username', '');
	?> -->
	<br>
	<?php
		echo form_label('Password : ', 'password');
		echo form_password('password', '');
	?>
	<br>
	<?php
		echo form_label('Re-enter Password : ', 'repass');
		echo form_password('repass', '');
	?>
	<br>
	<?php
		echo form_label('Email : ', 'email');
		echo form_input('email', '');
	?>
	<br>
	<?php
		echo form_label('Street Address : ', 'street');
		echo form_input('street', '');
	?>
	<br>
	<?php
		echo form_label('City : ', 'city');
		echo form_input('city', '');
	?>
	<br>
	<?php
		echo form_label('State : ', 'state');
		echo form_input('state', '');
	?>
	<br>
	<?php
		echo form_label('Pincode : ', 'pincode');
		echo form_input('pincode', '');
	?>
	<br>
	<?php
		//adding CAPTCHA
		$random_number = substr(number_format(time() * rand(),0,'',''),0,6);
		$vals = array(
             'word' => $random_number,
             'img_path' => './captcha/',
             'img_url' => base_url().'captcha/',
             'img_width' => 140,
             'img_height' => 32,
             'expiration' => 7200
            );
		$cap = create_captcha($vals);
		echo $cap['image'];
		?>
		<br>
		<?php 
		$this->session->set_userdata('captchaWord', $cap['word']);
		echo form_label('Please fill in the string above : ', 'captcha');
		echo form_input('captcha', '');
	?>
	<br>
	<?= form_submit('submit_customer', 'Signup') ?>

</body>
</html>