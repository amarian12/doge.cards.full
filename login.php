<?php
    include_once 'dbcon.php';
    include_once 'functions.php';
	sec_session_start();
	 
	if (login_check($mysqli) == true) {
		$logged = 'in';
	} else {
		$logged = 'out';
	}
?>
   
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DOGE.CARDS - Dogecoin Giftcards</title>
<link href="style.css?v1f" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Old+Standard+TT:700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
<link href="css/uniform.css" media="screen" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.tools.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/main.js?v1"></script>
<script type="text/JavaScript" src="js/sha512.js"></script> 
<script type="text/JavaScript" src="js/forms.js"></script>
</head>

<body style="background-image: url(bodybg.png);">
	<?php include 'header.php' ?>
    <div id="contentContainer">
        <div id="content">
            <div class="TTWForm-container clearfix">    
            <?php if(isset($_GET['error']))
				{
					echo "<br/>";
					if($_GET['error'] == 1)
					{
						echo "<p id='error'>Login failed! Make sure both your e-mail and password are correct and try again!</p>";	
					}
					echo "<br/>";
				}
				?> 
<?php include 'navigationus.php'; ?><br>       
                 <form action="process_login.php" class="TTWForm" method="post">
                      
                      
                      <div id="field1-container" class="field f_100">
                           <label for="field1">
                                E-mail Address
                           </label>
                           <input type="email" name="email" id="field1" required>
                      </div>
                      
                      
                      <div id="field2-container" class="field f_100">
                           <label for="field2">
                                Password
                           </label>
                           <input type="password" name="password" id="field2">
                      </div>                  
                      
                      <div id="form-submit" class="field f_100 clearfix submit">
                           <input type="submit" value="Login" onClick="formhash(this.form, this.form.password);">
                      </div>
                 </form>
            </div>
        </div>
    </div>
    <?php include 'footer.php' ?>
</body>