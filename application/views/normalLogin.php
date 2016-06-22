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
	<h3>Login Page</h3>
	<?php
		echo form_open('normal_login');

		echo validation_errors();

		echo form_label('Email : ', 'email');
		echo form_input('email', '');

		echo "<br>";

		echo form_label('Password : ', 'password');
		echo form_password('password', '');

		echo "<br>";

		echo form_submit('submit-button', 'Login!');
	?>
</body>
</html>