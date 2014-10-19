<?php
    include_once 'dbcon.php';
    include_once 'functions.php';
	session_start();
    ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DOGE.CARDS - Dogecoin Giftcards</title>
<link href="style.css?v1h" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Old+Standard+TT:700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
<link href="css/uniform.css" media="screen" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.tools.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/main.js?v2"></script>
<script type="text/JavaScript" src="js/sha512.js"></script> 
<script type="text/JavaScript" src="js/forms.js"></script>
</head>

<body style="background-image: url(bodybg.png);">
	<?php include 'header.php' ?>
    <div id="contentContainer">
        <div id="content">
            <div class="TTWForm-container clearfix" style="clear: both;">
                 <?php if(isset($_GET['error']))
				{
					echo "<br/>";
					if($_GET['error'] == 1)
					{
						echo "<p id='error'>This IP already owns an account!</p>";	
					}
					elseif($_GET['error'] == 2)
					{
						echo "<p id='error'>This e-mail address is already in use!</p>";	
					}
					if($_GET['error'] == 3)
					{
						echo "<p id='error'>This username is already in use!</p>";	
					}
					if($_GET['error'] == 4)
					{
						echo "<p id='error'>The username you chose is too long! Needs to be between 5 and 20 characters.</p>";	
					}
					if($_GET['error'] == 5)
					{
						echo "<p id='error'>The password you attempted to register with is invalid!</p>";	
					}
					echo "<br/>";
				}
				?>

                <?php include 'navigationus.php'; ?><br>
                <?php
				$_SESSION['token'] = uniqid('', true);
				?>
                 
                 <form action="register.inc.php" class="TTWForm" method="post">
                      
                      
                      <div id="field1-container" class="field f_100">
                           <label for="field1">
                                Username
                           </label>
                           <input type="text" name="username" id="field1" required pattern="[a-zA-Z0-9]+">
                      </div>
                      
                      
                      <div id="field2-container" class="field f_100">
                           <label for="field2">
                                Email Address
                           </label>
                           <input type="email" name="email" id="field2" required>
                      </div>
                      
                      
                      <div id="field3-container" class="field f_100">
                           <label for="field3">
                                Password
                           </label>
                           <input type="password" name="password" id="field3">
                      </div>
                      
                      <div id="field3-container" class="field f_100">
                           <label for="field4">
                                Confirm Password
                           </label>
                           <input type="password" name="confirmpwd" id="field4">
                      </div>
                      
                      <div id="field5-container" class="field f_100">
						<label for="field5">
							Are you a human/shibe?
						</label>
                      
                      <?php require_once('recaptchalib.php');
		  $publickey = "6Lesc_YSAAAAAP2zKy_KXtvmxCW350HATBH1gaPY";
		  echo ' <div align="center"> ' .recaptcha_get_html($publickey). '</div>'; ?>
                      
                      <div id="form-submit" class="field f_100 clearfix submit">
                           <input type="submit" name="submitButton" value="Register" onClick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);">
                      </div>
                      
                       <input type="hidden" name="csrftoken" value="<?php echo $_SESSION['token']; ?>" />
                 </form>
            </div>
        </div>
    </div>
    <?php include 'footer.php' ?>
</body>