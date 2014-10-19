<?php
include_once 'dbcon.php';
include_once 'dbinfo.php';
include_once 'functions.php';
sec_session_start(); 
define('MyConst', TRUE);
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DOGE.CARDS - Dogecoin Giftcards</title>
<link href="style.css?v63" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Old+Standard+TT:700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
<link href="css/uniform.css" media="screen" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.tools.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script src="http://cdn.bitmindo.com/dogecoin.min.js"></script>
<script type="text/javascript">
    function updateTextInput(val) {
      document.getElementById('styleVal').innerHTML=val; 
    }
	function updateTextInput2(val) {
		val *= 1 - 0.005;
      document.getElementById('feeVal').innerHTML=val; 
    }
  </script>
</head>

<body style="background-image: url(bodybg.png);">
	<?php include 'header.php' ?>
	<div id="contentContainer">
	  <div id="content">
      	<?php include 'navigation.php' ?>
        <SCRIPT LANGUAGE="JavaScript"><!--
			function codename() {
			
			if(document.formname.expirecheck.checked)
			{
			document.formname.expiry.disabled=false;
			}
			
			else
			{
			document.formname.expiry.disabled=true;
			}
			}
			
			//-->
		</SCRIPT>
        <form action="dogecard.inc.php" name="formname" class="TTWForm clearfix" method="post">
                      
                      
                      <div id="field1-container" class="field f_100">
                      <?php
					  $link = new mysqli("HOST", "USERNAME", "PASSWORD", "DB");
		$query = "SELECT walletAddress, walletUser, debt from users WHERE username = '" . $_SESSION['username'] . "' LIMIT 1";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_assoc($result);
					  $balance = file_get_contents('https://www.dogeapi.com/wow/v2/?api_key=APIKEY&a=get_user_balance&user_id=' . $row['walletUser']);
		$json_a = json_decode($balance,true); 
		$new_balance = $json_a['data'][balance] - $row['debt'];
		echo "Available Balance: " . $new_balance . " Ðoge"; mysqli_close($link);	$_SESSION['token'] = uniqid('', true); ?><br><br>

                           <label for="field1">
                                Amount (Including 0.5% API fees: <b><a id='feeVal'>0</a></b>)
                           </label>
                           <?php if($new_balance < 5)
						   {
							   echo '<input type="number" name="amount" value="5" disabled id="field1" onchange="updateTextInput2(this.value);" onkeydown="updateTextInput2(this.value);" onpaste="updateTextInput2(this.value);" oninput="updateTextInput2(this.value);" required min="5" max="'.$new_balance.'">';
						   }
						   else
						   {
							   echo '<input type="number" name="amount" value="5" id="field1" onchange="updateTextInput2(this.value);" onkeydown="updateTextInput2(this.value);" onpaste="updateTextInput2(this.value);" oninput="updateTextInput2(this.value);" required min="5" max="'.$new_balance.'">';   
						   }
						   ?>
                      </div>
                      
                      <div id="field2-container" class="field f_25">
                      	<label for="field2">
                                Should it expire?
                           </label>
                           <?php if($new_balance < 5)
						   {
							   echo '<input type="checkbox" onclick="codename()" disabled name="expirecheck" value="ON">';
						   }
						   else
						   {
							   echo '<input type="checkbox" onclick="codename()" name="expirecheck" value="ON">';   
						   }
						   ?>
                      </div>
                      
                      <div id="field3-container" class="field f_100">
                           <label for="field3">
                                Expiry Date
                           </label>
                           <input type="date" disabled name="expiry" id="field3" min="<?php date('Y-m-d') ?>" required>
                      </div>
                      
                      <div id="field4-container" class="field f_100">
                           <label for="field4">
                                Style No. <b><a id='styleVal'>0</a></b> (<a href="styles.php" onClick="window.open(this.href, 'mywin',
'left=20,top=20,width=960,height=640,toolbar=1,resizable=0'); return false;">Click here for a list!</a>)
                           </label>
                           <?php if($new_balance < 5)
						   {
							   echo '<input type="range" disabled name="style" id="field4" min="0" max="5" step="1" value="0" onchange="updateTextInput(this.value);" required>';
						   }
						   else
						   {
							   echo '<input type="range" name="style" id="field4" min="0" max="5" step="1" value="0" onchange="updateTextInput(this.value);" required>';   
						   }
						   ?>
                      </div>
                      
                      <div id="field5-container" class="field f_100">
						<label for="field5">
							Are you a human/shibe?
						</label>
                      
                      <?php require_once('recaptchalib.php');
		  $publickey = "6Lesc_YSAAAAAP2zKy_KXtvmxCW350HATBH1gaPY";
		  echo ' <div align="center"> ' .recaptcha_get_html($publickey). '</div>'; ?>
          
          				</div>
                      
                      <div id="form-submit" class="field f_100 clearfix submit">
                      		<input type="hidden" name="csrftoken" value="<?php echo $_SESSION['token']; ?>" />
                      		<?php if($new_balance < 5)
						   {
							   echo 'You need at least 5 dogecoins to be able to create a dogecard!';
						   }
						   else
						   {
							   echo '<input type="submit" name="submitButton" value="Create Dogecard"/>';   
						   }
						   ?>
                      </div>
                 </form>
            </div>
            </div>
    </div>
    <?php include 'footer.php' ?>
</body>
</html>