<head>
	<link href="style.css?v23" rel="stylesheet" type="text/css" />
	<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
</head>

<body class="confirmationBody">
	<div class="confirmation">
    	<div class="confirmationDoge2"></div>
    </div>
<?php
		 echo '<div class="confirmationInside">';
		 //Chooses a random number 
		 $num = Rand (1,4); 
		 //Based on the random number, gives a quote 
		 switch ($num)
		 {
		 case 1:
		 echo '<p class="confirmationHeader">Wow!</p>';
		 break;
		 case 2:
		 echo '<p class="confirmationHeader">Such secret shibe!</p>';
		 break;
		 case 3:
		 echo '<p class="confirmationHeader">Many dogenerous!</p>';
		 break;
		 case 4:
		 echo '<p class="confirmationHeader">Very friend!</p>';
		 }
		echo '<p class="confirmationHeader">Successfully sent a secret shibe gift!</p>';
		echo '<p class="confirmationGeneral">Your secret shibe partner has been sent the dogecard. You made a stranger on the internet a little bit happier, well done!</p>';
	?>
</body>