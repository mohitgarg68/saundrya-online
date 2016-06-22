<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Make a choice</title>
</head>
<body>
	<?php
		$this->session->set_userdata('login_service', 'google');
	?>
	<?php
		echo form_open('main/set_role_customer');
		echo form_submit('customer', 'Customer');
		echo form_close();
	?>
	<br>
	<?php
		echo form_open('main/set_role_beautician');
		echo form_submit('beautician', 'Beautician');
		echo form_close();
	?>
	<br>
</body>
</html>
