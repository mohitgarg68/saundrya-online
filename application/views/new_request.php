<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>New Request</title>
	<script type="text/javascript">
	 window.onload = function() {
	    document.getElementById('ifYes').style.display = 'none';
	    document.getElementById('ifNo').style.display = 'none';
	}
	function yesnoCheck() {
	    if (document.getElementById('yesCheck').checked) {
	    	//document.getElementById("street").value = $street;
	        document.getElementById('ifYes').style.display = 'block';
	        document.getElementById('ifNo').style.display = 'none';
	    } 
	    else if(document.getElementById('noCheck').checked) {
	        document.getElementById('ifNo').style.display = 'block';
	        document.getElementById('ifYes').style.display = 'none';
	   }
	}
	
	</script>

</head>
<body>
	<h3>Make a new Request!</h3>

	<?php
		echo form_open('requests/new_function');
		echo validation_errors();
		echo form_label('Service : ', 'service[]');
		$options = array(
			'facial' => 'Facial',
			'threading' => 'Threading',
			'spa' => 'Spa',
			'service' => 'Service'
			);
		echo "<br>";
		echo form_multiselect('service[]', $options);
		echo "<br>";
		echo form_label('Time(hh:mm:ss) : ', 'time');
		echo form_input('time', '');
		echo "<br>";
		echo form_label('Date(dd-mm-yyyy) : ', 'date');
		echo form_input('date', '');
		echo "<br>";

		echo form_label('Address : ', 'address');
		?>
		My Address
		<input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="yesCheck" value="myadd"/>
		New Address
		<input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="noCheck" value="newadd"/>
		<br>
		<div id="ifYes" style="display:none">
			<?php
			echo form_label('Street : ', 'street');
			$setting_street = array(
				'name' => 'street',
				'value' => $street,
				'readonly' => true
				);
			$setting_city = array(
				'name' => 'city',
				'value' => $city,
				'readonly' => true
				);
			$setting_state = array(
				'name' => 'state',
				'value' => $state,
				'readonly' => true
				);
			$setting_pincode = array(
				'name' => 'pincode',
				'value' => $pincode,
				'readonly' => true
				);
			echo form_input($setting_street);
			echo "<br>";
			echo form_label('City : ', 'city');
			echo form_input($setting_city);
			echo "<br>";
			echo form_label('State : ', 'state');
			echo form_input($setting_state);
			echo "<br>";
			echo form_label('PinCode : ', 'pincode');
			echo form_input($setting_pincode);
			echo "<br>";
			?>
		</div>

		<div id="ifNo" style="display:none">
			<?php
			echo form_label('Street : ', 'street');
			echo form_input('street', '');
			echo "<br>";
			echo form_label('City : ', 'city');
			echo form_input('city', '');
			echo "<br>";
			echo form_label('State : ', 'state');
			echo form_input('state', '');
			echo "<br>";
			echo form_label('PinCode : ', 'pincode');
			echo form_input('pincode', '');
			echo "<br>";
			?>
		</div>

		<?php
		
	

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
			
			echo form_submit('submit', 'Submit');
		echo form_close();
	?>


</body>
</html>