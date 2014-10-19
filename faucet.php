<?php
include_once 'dbcon.php';
include_once 'functions.php';
sec_session_start(); 
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DOGE.CARDS - Dogecoin Giftcards</title>
<link href="style.css?v29" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Old+Standard+TT:700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
<link href="css/uniform.css" media="screen" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.tools.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</head>

<body style="background-image: url(bodybg.png);">
	<?php include 'header.php' ?>
	<div id="contentContainer">
	  <div id="content">
      <?php if(isset($_GET['reg']))
				{
					if($_GET['reg'] == "success")
					{
						echo "<p id='success'>Registration successful! You may now log in!</p>";	
						echo "<br/>";
					}
				}
				?>   
      	<?php include 'navigationus.php'; ?><br>
<br>

<?php
	if(login_check($mysqli) == true)
	{
		echo '<b>You are logged in and your maximum faucet claim has increased. Thanks!</b><br/><br/>';
	}
	else
	{
		echo '<b>Being logged in triples your maximum faucet claim! Register for free now.</b><br/><br/>';
	}
	$balance = file_get_contents('https://www.dogeapi.com/wow/v2/?api_key=APIKEY&a=get_user_balance&user_id=USERID');
	$json_a = json_decode($balance,true); 
	$new_balance = $json_a['data'][balance];
	echo "<b>Ðoge in Faucet: " . $new_balance . "</b>";
	echo "<br/>Donations: DJeB68DD1MJGAYy87u7CujBUD7zJvnTmKZ <br />";
	if(isset($_POST['address']))
	{
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
		  } else {
		$username = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
		$ip = $_SERVER['REMOTE_ADDR'];
		if(!empty($_POST['address'])) {
        if($new_balance < 200){
                echo "<br/>The faucet is dry! Please consider donating.";
        }else{
                if(strlen($username) == 34){
                        $link = new mysqli("HOST", "USERNAME", "PASSWORD", "DB");
                        $time=time();
                        $time_check=$time-43200;
                        $sql4="DELETE FROM faucet WHERE time<$time_check";
                        $result4=mysqli_query($link, $sql4);
                        $sql=sprintf("SELECT * FROM faucet WHERE address='%s' OR ip='$ip'", $username);
                        $result=mysqli_query($link,$sql);
                        $count=mysqli_num_rows($result);
                        if($count=="0"){
								ob_start();
								echo '<b><br/>Please be patient while your faucet request is processed.. Do not leave or close this page.</b>';
								if(login_check($mysqli) == true)
								{
									$sql1=sprintf("INSERT INTO faucet(address, time, ip, loggedIn)VALUES('$username', '$time', '$ip', '1')");
								}
								else
								{
									$sql1=sprintf("INSERT INTO faucet(address, time, ip, loggedIn)VALUES('$username', '$time', '$ip', '0')");	
								}
                                $result1=mysqli_query($link,$sql1);
								if(login_check($mysqli) == true)
								{
									$amount = rand(5,75);
								}
                                $amount = rand(5,25);
                                $withdraw = file_get_contents('https://www.dogeapi.com/wow/v2/?api_key=APIKEY&a=withdraw_from_user&user_id=USERID&pin=PIN&amount_doge='.$amount.'&payment_address='.$username);
								ob_end_clean();
                                echo "<br/>You've got ";
                                echo $amount;
                                echo " ÐOGE! It may take a while (up to an hour) for this to process. Please be patient!<br/><br/><img src='faucet.png' />";
								mysqli_close($link);
 
                        }else{
								$sql=sprintf("SELECT time FROM faucet WHERE address='%s' OR ip='$ip'", $username);
								$result=mysqli_query($link,$sql);
                        		$count=mysqli_num_rows($result);
								mysqli_close($link);
                                echo "<br/>Wow, such faucet request, many wait. Please wait 12 hours before requesting from the faucet again!<br/>";
								echo "You last claimed from the faucet: " . date('H:i', $count['time']->timestamp) . ", please wait until " . date('H:i', $count['time']->timestamp-43200);
                        }
                }
        }
	}
	}
	}
	else
	{
		echo '<form action="faucet.php" class="TTWForm clearfix" method="post">';
		echo '<div id="field1-container" class="field f_100">
                           <label for="field1">
                                Address
                           </label>
                           <input type="text" name="address" id="field2" pattern=".{34,34}" required>
                      </div>';
		echo '<div id="field3-container" class="field f_100">
						<label for="field3">
							Are you a human/shibe?
						</label>';
		  require_once('recaptchalib.php');
		  $publickey = "6Lesc_YSAAAAAP2zKy_KXtvmxCW350HATBH1gaPY";
		  echo ' <div align="center"> ' .recaptcha_get_html($publickey). '</div>';
		  echo '</div><div id="form-submit" class="field f_100 clearfix submit">
                           <input type="submit" name="submitButton" value="Claim from Faucet" onClick="if(this.value == \'Claim from Faucet\' && document.getElementById("field1").value != "") this.value = \'Claiming..\'; this.form.submit();">
                      </div></form>';
					  
	}
?>
<br /></div>
    </div>
    <?php include 'footer.php' ?>
</body>
</html>