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
		$link = new mysqli("HOST", "USERNAME", "PASSWORD", "DB");
		$query = "SELECT * FROM users;";
		$result = mysqli_query($link, $query);
		$numusers = mysqli_num_rows($result);
		$query = "SELECT * FROM giftcards;";
		$result = mysqli_query($link, $query);
		$numcards = mysqli_num_rows($result);
		$query = "SELECT SUM(value) AS val FROM giftcards WHERE gifted='1';";
		$result = mysqli_query($link, $query);
		$sumval = mysqli_fetch_assoc($result);
		$query = "SELECT deletedCards FROM info;";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_assoc($result);	
		$numofcards = $numcards + intval($row['deletedCards']);
		mysqli_close($link);
		echo 'A total of <b>' . $numusers . '</b> shibes have created <b>' . $numofcards . '</b> dogecards..<br/>..and gave <b>' . $sumval['val'] . '</b> dogecoins through secret shibe!';
?><br>
<br>

		<p class="theContent">Welcome to <b>doge.cards</b>. This is a new, easy to use platform through which you can create gift cards using the Dogecoin decentralised currency. Whether it's a birthday, event or other form of giveaway, they're great for all occasions! Simply register, login and start creating gift cards! If you're only here to redeem gift cards, click <a href="redeem">here</a> and we'll get started. To create a card, register (or login if you have already registered), navigate to 'Create' and submit the simple form to generate your very own dogecard!
		</p><br>
	<br> </div>
    </div>
    <?php include 'footer.php' ?>
</body>
</html>