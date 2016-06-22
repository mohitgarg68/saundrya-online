<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Saundarya</title>
</head>
<body>
	<h2>Welcome to the new Age!</h2>
	<?php
		echo form_open('main/login');
		echo form_submit('login_view', 'Login!');
		echo form_close();
	?>
	<br>
	<h3>Not a member? Signup below!</h3>
	<?php
		echo form_open('main/customer_signup_first');
		echo form_submit('customer_signup', 'Customers Here!');
		echo form_close();
	?>
	<br>
	<?php
		echo form_open('main/beautician_signup_first');
		echo form_submit('beautician_signup', 'Beauticians Here!');
		echo form_close();
	?>
</body>
</html>
