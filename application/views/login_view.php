<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login Page</title>
</head>
<body>
	<?php
		//echo base_url();
		//echo form_open('google_oauth');
		echo form_open('main/askRole_google');
		echo form_submit('google_oauth', 'Google+');
		echo form_close();
	?>
	<br>
	<?php
		//echo form_open('fb_oauth');
		echo form_open('main/askRole_facebook');
		echo form_submit('fb_oauth', 'Facebook');
		echo form_close();
	?>
	<br>
	<?php
		echo form_open('normal_login/first');
		echo form_submit('normal_login', 'Login');
		echo form_close();
	?>
</body>
</html>
