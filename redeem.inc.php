<?php
	include_once 'dbcon.php';
	include_once 'dbinfo.php';
	include_once 'functions.php';
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
	sec_session_start(); 
	$cardkey = filter_input(INPUT_POST, 'dogecardkey', FILTER_SANITIZE_STRING);
	$cardaddress = filter_input(INPUT_POST, 'dogeaddress', FILTER_SANITIZE_STRING);
	if(strlen($cardaddress) != 34)
	{
		echo 'That is not a valid dogecoin wallet!';
		mysqli_close($link);	
		die(); 
	}
	if ($_POST['csrftoken'] == $_SESSION['token']) {
		unset($_SESSION['token']);
		$link = new mysqli("HOST", "USERNAME", "PASSWORD", "DB");
		$query = "SELECT gckey, creatorIP FROM giftcards WHERE gckey = '" . $cardkey . "' LIMIT 1";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_assoc($result);	
		if($row == NULL)
		{
			echo 'That key does not exist!';
			mysqli_close($link);	
			die();
		}
		if($row['creatorIP'] == $_SERVER["REMOTE_ADDR"])
		{
			echo 'You are not allowed to redeem your own dogecard!';
			mysqli_close($link);	
			die();
		}
		else
		{
			$query = "SELECT claimed, expiryDate, userID, value FROM giftcards WHERE gckey = '" . $cardkey . "' LIMIT 1";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_assoc($result);
			$cardValue = $row["value"];
			$creator = $row["userID"];
			if($row["claimed"] == 1)
			{
				echo 'Already claimed!';
				mysqli_close($link);	
				die();
			}
			else
			{
				if($row["expiryDate"] != "0000-00-00")
				{
					$now = date('Y-m-d');
					if ($row["expiryDate"] < $now)
					{
						 echo 'This card has expired!';
						 $query = "DELETE FROM giftcards WHERE gckey = '" . $cardkey . "'";
						 $result = mysqli_query($link, $query);
						 $query = "UPDATE users SET debt=debt-".$cardValue." WHERE userID ='".$creator."'";
						 $result = mysqli_query($link, $query) or die(mysql_error());
						 die();   
					}
				}
				$query = "UPDATE giftcards SET claimed=1 WHERE gckey = '" . $cardkey . "' LIMIT 1";
				$result = mysqli_query($link, $query);
				$query = "UPDATE giftcards SET redeemedTo='" . $cardaddress . "' WHERE gckey = '" . $cardkey . "' LIMIT 1";
				$result = mysqli_query($link, $query);
				$query = "SELECT claimed, value, gckey, userID FROM giftcards WHERE gckey = '" . $cardkey . "' LIMIT 1";
				$result = mysqli_query($link, $query);
				$tuserid = mysqli_fetch_assoc($result);
				$query = "SELECT * FROM users WHERE userID = '" . $tuserid['userID'] . "' LIMIT 1";
				$result = mysqli_query($link, $query);
				$userinfo = mysqli_fetch_assoc($result);
				$withdraw = file_get_contents('https://www.dogeapi.com/wow/v2/?api_key=APIKEY&a=withdraw_from_user&user_id='.$userinfo['walletUser'].'&pin=PIN&amount_doge='.$tuserid['value'].'&payment_address='.$cardaddress);
				$query = "UPDATE users SET debt=debt-".$tuserid['value']." WHERE userID = '" . $tuserid['userID'] . "' LIMIT 1";
				$result = mysqli_query($link, $query);
				mysqli_close($link);
				$finalValue = round($tuserid['value'] * ((100-0.5) / 100), 4);
				$thanksURL = 'Location: thanks?value=' . $finalValue;
				header($thanksURL);
			}
		}
	}
	else {
		echo 'Nice try!';
	die();	
	}
?>