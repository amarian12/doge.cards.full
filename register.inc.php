<?php
if ($_POST['csrftoken'] == $_SESSION['token']) {
	unset($_SESSION['token']);
}
	if(!isset($_POST['p']))
	{
		header('Location: register.php?error=4');	
	}
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
	include_once 'dbcon.php';
	include_once 'dbinfo.php';
	$error_msg = "";
	if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$ip = $_SERVER["REMOTE_ADDR"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }
	
	if(!strlen($username) >= 5 && !strlen($username) <= 20)
	{
		$error_msg .=  '<p class="error">Username needs to be between 5 and 20 characters in length!</p>';
		header('Location: register.php?error=4');
	}

    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
		header('Location: register.php?error=5');
    }
 
    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //
 	
 	$prep_stmt = "SELECT IPAddress from users WHERE IPAddress = ? LIMIT 1";
	$stmt = $mysqli->prepare($prep_stmt);
	
	if ($stmt) {
        $stmt->bind_param('s', $ip);
        $stmt->execute();
        $stmt->store_result();
	
		if($stmt->num_rows == 1) {
			$error_msg .= '<p class="error">This IP address already has an account!</p>';
			header('Location: register.php?error=1');
				$stmt->close();	
		}
	 } else {
        $error_msg .= '<p class="error">Error line 30</p>';
                $stmt->close();
    }
 
    $prep_stmt = "SELECT userID FROM users WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
   // check existing email  
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
			header('Location: register.php?error=2');
                        $stmt->close();
        }
                $stmt->close();
    } else {
        $error_msg .= '<p class="error">Database error Line 39</p>';
                $stmt->close();
    }
 
    // check existing username
    $prep_stmt = "SELECT userID FROM users WHERE username = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
 
                if ($stmt->num_rows == 1) {
                        // A user with this username already exists
                        $error_msg .= '<p class="error">A user with this username already exists</p>';
						header('Location: register.php?error=3');
                        $stmt->close();
                }
                $stmt->close();
        } else {
                $error_msg .= '<p class="error">Database error line 55</p>';
                $stmt->close();
        }
    // TODO: 
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.
    if (empty($error_msg)) {
        // Create a random salt
        //$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
		
		$date = new DateTime();
		$uniqueDate = $date->getTimestamp();
		$nusername = $uniqueDate . "DC-" . $username;
		$address = file_get_contents('https://www.dogeapi.com/wow/v2/?api_key=APIKEY&a=create_user&user_id=' . $nusername);
		$json_a = json_decode($address,true); 
		$new_address = $json_a['data'][address];
        // Insert the new user into the database 
        if ($insert_stmt = $mysqli->prepare("INSERT INTO users (username, email, password, salt, ipaddress, walletAddress, walletUser) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
            $insert_stmt->bind_param('sssssss', $username, $email, $password, $random_salt, $ip, $new_address, $nusername);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../index.php?page=register&err=Registration failure: INSERT');
            }
        }
        header('Location: ./index.php?reg=success');
    }
}
else
{
	echo 'This form has already been submitted! Click <a href="index.php">here</a> to return.';	
}
?>