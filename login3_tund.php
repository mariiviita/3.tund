<?php
	//võtab ja kopeerib faili sisu
	require("../../config.php");
	
	//$random = " ";
	//var_dump(empty($random));
	
	//var_dump("Marii"); //näitab muutuja andmetüüpi, selle väärtust ja stringi pikkust
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	//muutujad
	$SignupEmailError="";
	$SignupPasswordError="";
	$SignupAgeError="";
	$signupgenderError="";
	$SignupEmail="";

	//kas e-post oli olemas
	if (isset ($_POST["SignupEmail"]) ) {
	
		if (empty ($_POST["SignupEmail"]) ) {
		
			//oli email, kuid see oli tühi
		
		$SignupEmailError="See väli on kohustuslik!";
		
		} else{
			//email on õige
			$signupEmail=$_POST["signupEmail"];
		}
		
	
	}

	if (isset ($_POST["SignupPassword"] ) ) {
		
		if (empty($_POST["SignupPassword"] ) ) {
		
			//oli password, kuid see oli tühi
			$SignupPasswordError="See väli on kohustuslik!";
			
		} else {
			
			//tean, et on parool ja see ei olnud tühi
			//vähemalt 8 tähemärki
			
			if (strlen($_POST["SignupPassword"] ) <8 ) {
				
					$SignupPasswordError="Parool peab olema vähemalt 8 tähemärki pikk";
					
			}
			
		}
		
	}
	
	$gender="male";
	// kui tühi
	//$gender="";
	
	if (isset ($_POST["signupAge"])) {
		if (empty($_POST["signupAge"])) {
			$signupAgeError="See väli on kohustuslik!";
		}
	}
	
	if (isset ($_POST["gender"])) {
		if (empty ($_POST["gender"])) {
			$genderError="See väli on kohustuslik!";
		} else{
			$gender=$_POST["gender"];
		}
	}

	//tean, et ühtegi viga ei olnud ja saan kasutaja andmed salvestada
	if(isset($_POST["SignupEmail"])&& isset($_POST["SignupPassword"]) && empty($SignupEmailError) && empty($SignupPasswordError)){
		
		echo "Salvestan...<br>";
		echo "email ".$SignupEmail."<br>";
		
		$password=hash("sha512", $_POST["SignupPassword"]);
		
		echo "parool ".$_POST["SignupPassword"]."<br>";
		echo "räsi ".$password."<br>";
		
		//echo $serverPassword;
		
		$database="if16_mariiviita";
		
		//ühendus
		$mysqli=new mysqli($serverHost, $serverUsername, $serverPassword, $database);
		
		//käsk
		$stmt=$mysqli->prepare("INSERT INTO user_sample (email, password) VALUES(?,?)");
		
		echo $mysqli->error;
		
		//asendan küsimärgi väärtustega
		//iga muutuja kohta üks täht, mis tüüpi muutuja on
		//s-stringi
		//i-integer
		//d-double/float
		$stmt->bind_param("ss",$SignupEmail, $password);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
			
		}else {
				echo "ERROR ".$stmt->error;
		
		}
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise lehekülg</title>
	</head>
	<body>

		<h1>Logi sisse</h1>

		<form method="POST">
		
			<label>E-post</label><br>
			<input name="LoginEmail" type="email">
		
			<br><br>
		
			<input name="LoginPassword" type="password" placeholder="Parool">
		
			<br><br>
		
			<input type="submit" value="Logi sisse">
			
		</form>
	
		<h1>Loo kasutaja</h1>
		<form method="POST">
		
			<input name="SignupAge" type="age" placeholder="Vanus"><?php echo $SignupAgeError;?>
			
			<br><br>
			
			<input name="SignupEmail" type="email" placeholder="E-post" value="<?=$SignupEmail;?>"> <?php echo $SignupEmailError; ?>
		
			<br><br>
		
			<input name="SignupPassword" type="password" placeholder="Parool"><?php echo $SignupPasswordError; ?>
			
			<br><br>
			
			<?php if($gender=="male"){ ?>
				<input type="radio" name="gender" value="male" checked> Male<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="male" checked> Male<br>
			<?php } ?>
			<?php if ($gender=="female") { ?>
				<input type="radio" name="gender" value="female" checked> Female<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="female" > Female<br>
			 <?php } ?>
			 
			 <?php if($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked> Other<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="other" > Other<br>
			 <?php } ?>
				
			<input type="submit" value="Loo kasutaja">
			
		</form>

	</body>
</html>