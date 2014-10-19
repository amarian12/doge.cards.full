<?php
include_once 'dbcon.php';
include_once 'functions.php';
sec_session_start(); 
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DOGE.CARDS - Dogecoin Giftcards</title>
<link href="style.css?v17" rel="stylesheet" type="text/css" />
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
      	<?php include 'navigationus.php'; ?><br>
<br>

		<p class="theContent">Hi there, it appears you wish to contact me - if you want to report an issue, seek advice or otherwise send feedback, send all requests to the following e-mail (once the captcha is completed):<br>
</p><br>

        
        <a href="http://www.google.com/recaptcha/mailhide/d?k=01wrCgohGDpcJQotxyme6RSw==&amp;c=9VM9lemY7cJvi1tvWTx7K_EATN8d56_4iePfmq1U0YE=" onClick="window.open('http://www.google.com/recaptcha/mailhide/d?k\07501wrCgohGDpcJQotxyme6RSw\75\75\46c\759VM9lemY7cJvi1tvWTx7K_EATN8d56_4iePfmq1U0YE\075', '', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=300'); return false;" title="Reveal this e-mail address">d...</a>@gmail.com
		<br>
	<br> </div>
	</div>
     <?php include 'footer.php' ?>
</body>
</html>