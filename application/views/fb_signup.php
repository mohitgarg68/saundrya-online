<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Continue|Customer</title>
</head>
<body>
	<?php 
		if($status == 0) 
		{
			echo 'Name : ' . $this->session->userdata('name');
			echo "<br>";
			echo "Email : " . $this->session->userdata('email');
			echo "<br>";
			
			echo form_open('main/fb_signup');
			
			echo validation_errors();
			
			echo form_label('Username : ', 'username');
			echo form_input('username', '');
			echo "<br>";

			echo form_label('Mobile Number : ', 'mobileno');
			echo form_input('mobileno', '');
			echo "<br>";

			echo form_label('Street Address : ', 'street');
			echo form_input('street', '');
			echo "<br>";

			echo form_label('City : ', 'city');
			echo form_input('city', '');
			echo "<br>";
			
			echo form_label('State : ', 'state');
			echo form_input('state', '');
			echo "<br>";

			echo form_label('Pincode : ', 'pincode');
			echo form_input('pincode', '');
			echo "<br>";

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
			echo "<br>";

			echo form_submit('mySubmit', 'Signup!');

			echo form_close();
		}
		elseif($status == 1)
		{ 
			redirect('main/members');	
		}  
	?>
</body>