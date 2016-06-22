<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Member's Area</title>
	<?php echo $map['js']; ?>	
</head>
<body>

	<h1>Hello Beautician!</h1>
	<p>Your Address is <b><?php echo $this->session->userdata('my_address');?></b></p>

	<?php 
	echo $map['html']; 
	//print_r($addresses);
	?>
	

	<h2>This is END</h2>

</body>
</html>