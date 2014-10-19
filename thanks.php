<?php
	$value = filter_input(INPUT_GET, 'value', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	if($value == "")
	{
		$value = 'no';
	}
	if($value <= 0.1)
	{
		$value = 'no';
	}
?>

<head>
	<link href="style.css?v22" rel="stylesheet" type="text/css" />
	<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
</head>

<body class="confirmationBody">
	<div class="confirmation">
    	<div class="confirmationDoge"></div>
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
		 echo '<p class="confirmationHeader">Such dogecard!</p>';
		 break;
		 case 3:
		 echo '<p class="confirmationHeader">Many dogecoin!</p>';
		 break;
		 case 4:
		 echo '<p class="confirmationHeader">Very rich!</p>';
		 }
		echo '<p class="confirmationHeader">Successfully redeemed '. $value .' dogecoins!</p>';
		echo '<p class="confirmationGeneral">Your dogecoins are on their way! Thanks for using doge.cards. It may take up to 30 minutes for the transaction to appear. You may close this page now!</p>';
	?>
</body>