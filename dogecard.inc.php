<?php
	include_once 'dbcon.php';
	include_once 'dbinfo.php';
	include_once 'functions.php';
	sec_session_start(); 
	require_once('recaptchalib.php');
		  $privatekey = "RECAPTCHA-PRIVATE-KEY-HERE";
		  $resp = recaptcha_check_answer ($privatekey,
										$_SERVER["REMOTE_ADDR"],
										$_POST["recaptcha_challenge_field"],
										$_POST["recaptcha_response_field"]);
	if (!$resp->is_valid) {
			// What happens when the CAPTCHA was entered incorrectly
			echo ("<br/>The reCAPTCHA wasn't entered correctly. Go back and try it again." .
				 "(reCAPTCHA said: " . $resp->error . ")");
				 die();
		  }
	if ($_POST['csrftoken'] == $_SESSION['token']) {
		unset($_SESSION['token']);
		
		if($_POST['amount'] < 5)
		{
			echo 'Amount needs to be at LEAST 5!';
			die();	
		}
		if(isset($_POST['expiry']))
		{
			$now = date('Y-m-d');
			if ($_POST['expiry'] < $now)
			{
				 echo 'Expiry date can not be in the past!';
				 die();   
			}
			$hasExpiry = true;
		}
		$link = new mysqli("HOST", "USERNAME", "PASSWORD", "DB");
		$query = "SELECT walletAddress, walletUser, userID, debt from users WHERE username = '" . $_SESSION['username'] . "' LIMIT 1";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_assoc($result);
		$balance = file_get_contents('https://www.dogeapi.com/wow/v2/?api_key=APIKEY&a=get_user_balance&user_id=' . $row['walletUser']);
		$json_a = json_decode($balance,true); 
		$new_balance = $json_a['data'][balance] - $row['debt'];
		$userID = $row['userID'];
		mysqli_close($link);
		if($new_balance >= $_POST['amount'])
		{
			$link = new mysqli("HOST", "USERNAME", "PASSWORD", "DB");
			$query = "UPDATE users SET debt=debt+".$_POST['amount']." WHERE username ='".$_SESSION['username']."'";
			$result = mysqli_query($link, $query) or die(mysql_error());
			$card = generateDogeCard();
			if($hasExpiry)
			{
				$query = "INSERT INTO giftcards (userID, gckey, value, expiryDate, style, creatorIP) VALUES ('" . $userID . "', '" . $card . "', '" . $_POST['amount'] . "', '" . $_POST['expiry'] . "', '" . $_POST['style'] . "', '" . $_SERVER["REMOTE_ADDR"] . "')";
				$result = mysqli_query($link, $query) or die(mysql_error());
			}
			else
			{
				$query = "INSERT INTO giftcards (userID, gckey, value, style, creatorIP) VALUES ('" . $userID . "', '" . $card . "', '" . $_POST['amount'] . "', '" . $_POST['style'] . "', '" . $_SERVER["REMOTE_ADDR"] . "')";
				$result = mysqli_query($link, $query) or die(mysql_error());
			}
			mysqli_close($link);
			header('Location: http://doge.cards/result?code=' . $card);
			die();
		}
		else
		{
			echo 'Not enough doge to make a card! Are you messing with post variables?';
			die();	
		}
	}
	else {
		echo 'Nice try - '.$_POST['csrftoken'].'!';
	die();	
	}
?>