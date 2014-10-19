<?php
include_once 'dbcon.php';
include_once 'functions.php';
sec_session_start(); 
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DOGE.CARDS - Dogecoin Giftcards</title>
<link href="style.css?v24" rel="stylesheet" type="text/css" />
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

		<p class="theContent"><strong>What is doge.cards?</strong><br/>Well, after trying to find a similar system to no avail; I decided to create one myself. Doge.cards is a web application that allows you to create so-called "Dogecards" by depositing into a special wallet address and utilizing the easy-to-use forms accessible from the dashboard. You're able to allocate amounts of dogecoin to these cards and receive an image with a code on it in return. People are then able to come here and redeem the code (without even logging in!) by inputting said dogecard code and their dogecoin wallet address. It's as simple as that!<br/><br/><strong>What's the point of it?</strong><br/>Simply, you're able to print these off, e-mail them, send them on facebook or other social media etc. and share your wealth without making it too complicated for the other party.<br/><br/><strong>Is it secure? Will you steal my money?</strong><br/>I've been an active member of the /r/dogecoin community for a good few months now and I'm an avid tipper, nothing makes me more angry than seeing someone be scammed. As for the technical aspects, the site uses HTTPS to encrypt personal information and wallet data, and my code has been checked over by a few security-expert friends of mine who've assured me that I've covered all of the bases with exploits - I'm always looking in case new ones pop up so I'm able to quickly patch them and stop any potential hacks. However, big sites have been hacked before (DogeAPI) and I cannot guarantee that even with the best encryption it will be 100% secure. No site is.<br/><br/><strong>Are you able to see any.. personal information if I were to register?</strong><br/>Only the wallet address you were assigned, your username and e-mail. Your password is encrypted with SHA-256, the encryption used in bitcoin, making it essentially impossible to crack the password if it's strong enough (dictionary attacks are always possible). Even I can't see what password you have signed up with, it's all completely safe.<br/><br/><strong>So what do you make out of this?</strong><br/>Nothing. The only fees are to cover the API transaction fees (0.5%) and I don't make a single dogecoin out of any transaction or registration on the site. You may wonder why: it's because I want to give something back to the community that welcomed me so kindly.<br/><br/><strong>Sounds good! How do I get started?</strong><br/>Simply click 'Register' at the top there and get started with the registration process. You're only allowed one account per IP address and e-mail so if you need another one for a family member please let me know via e-mail (see contact above) and I'll get back to you as soon as I can. If you forget your password, I currently haven't implemented that function (remember I'm one guy coding this whole thing!) so you'll need to e-mail me about that as well. It's all forwarded to my main e-mail so I'll get it rather quickly.<br/><br/><strong>Help! It froze while I was redeeming/creating/logging in/registering!</strong><br/>Follow the hitchhikers guide to the galaxy and DON'T PANIC. This is because the API we're using takes some time to query back and forth between our site and their API - it's all completely normal stuff and you will <strong>not</strong> lose anything - even if you refresh multiple times. Try not to, though, as it can slow down the process altogether or you'll receive an error message (submitted multiple times) rather than the confirmation. Remember: be patient, wait for the page to load before you freak out, it can take up to 30 seconds sometimes!<br/><br/><strong>DOUBLE HELP! My coins aren't in the dashboard after depositing!</strong><br/>Double don't panic! It can take anywhere from 60 seconds to 2 hours for deposits to show in the dashboard. It goes in your doge.cards wallet almost instantly, but it takes the API some time to update the infomation. Just be patient. If you have any worries please feel free to contact me using the details on the contact page.
		</p>
	</div></div>
     <?php include 'footer.php' ?>
</body>
</html>