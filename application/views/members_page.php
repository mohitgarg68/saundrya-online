<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Member's Area|Saundarya</title>
</head>
<body>
	<h3>Member's Area</h3>
	<?php
		if($role == 'customer')
		{
			echo form_open('requests/new_req');
			echo form_submit('submit1', 'New Request');
			echo form_close();

			echo "<br>";

			echo form_open('requests/old_req');
			echo form_submit('submit2', 'Old Requests');
			echo form_close();

			echo "<br>";

			echo form_open('normal_login/logout');
			echo form_submit('submit-logout', 'Logout');
			echo form_close();
		}
		elseif($role == 'beautician')
		{
			redirect('beautician/showrequests');
		}

		
	?>
</body>
</html>