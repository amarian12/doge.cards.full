<?php
include_once 'dbcon.php';
include_once 'dbinfo.php';
include_once 'functions.php';
sec_session_start(); 
define('MyConst', TRUE);
?>

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
</head>

<body style="background-image: url(bodybg.png);">
	<?php include 'header.php' ?>
	<div id="contentContainer">
	  <div id="content">
      	<?php if(isset($_GET['error']))
				{
					echo "<br/>";
					if($_GET['error'] == 1)
					{
						echo "<p id='error'>That key doesn't exist!</p>";	
					}
					if($_GET['error'] == 2)
					{
						echo "<p id='error'>That key has already been claimed!</p>";	
					}
					if($_GET['error'] == 3)
					{
						echo "<p id='error'>OOPS. WE'VE FALLEN INTO THE VOID!</p>";	
					}
				}
				?>    
      	<?php include 'navigationus.php'; ?><br>
        <?php
				$_SESSION['token'] = uniqid('', true);
				?>
        <form action="redeem.inc.php" class="TTWForm" method="post">
                      
                      
                      <div id="field1-container" class="field f_100">      
                           <label for="field1">
                                Dogecard Key
                           </label>
                           <input type="text" name="dogecardkey" id="field1" pattern=".{19,19}" required>
                      </div>
                      
                      <div id="field1-container" class="field f_100">
                           <label for="field1">
                                Address to send to (MAKE SURE THIS IS CORRECT, WE CAN'T REFUND TYPOS)
                           </label>
                           <input type="text" name="dogeaddress" id="field2" pattern=".{34,34}" required>
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
                           <input type="submit" name="submitButton" value="Redeem Dogecard - Click Once!" onClick="if(this.value == 'Redeem Dogecard - Click Once!' && document.getElementById("field1").value != "") this.value = 'Redeeming..'; this.form.submit();">
                           
                           <input type="hidden" name="csrftoken" value="<?php echo $_SESSION['token']; ?>" />
                      </div>
                 </form><br>
<br>
Don't have a dogecoin wallet? Get an offline one <a href="http://dogecoin.com/">here</a>, or if you prefer an online wallet, <a href="http://moolah.io">Moolah</a> or <a href="http://www.dogeapi.com">DogeAPI</a>!<br><br>

<script>
  CoinWidgetCom.go({
    /* make sure you update the wallet_address or you will not get your donations */
    wallet_address: "DQjfWhZWSfbCEiAHtezwezNtL4aGPSdh8F"
    , currency: "dogecoin"
    , counter: "amount"
    , alignment: "bl"
    , qrcode: true
    , auto_show: false
    , lbl_button: "Donate"
    , lbl_address: "Tip Dogecoin to this Address:"
    , lbl_amount: "DOGE"
  });
</script><br><br>
            </div>
     </div>
     <?php include 'footer.php' ?>
    </div>
</body>
</html>