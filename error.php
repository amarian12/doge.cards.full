<head>
	<link href="style.css?v25" rel="stylesheet" type="text/css" />
	<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
</head>

<body class="errorSABody">
	<div class="errorSA">
    	<div class="confirmationDoge"></div>
    </div>
<?php
	if($_GET['error'] == 0)
	{
		$error = 'That key does not exist!';	
	}
	elseif($_GET['error'] == 1)
	{
		$error = 'You are not allowed to redeem your own dogecard!';	
	}
	elseif($_GET['error'] == 2)
	{
		$error = 'Already claimed!';	
	}
		 echo '<div class="errorSAInside">';
		 echo '<p class="errorSAHeader">Wow, such error!</p>';
		echo '<p class="errorSAGeneral">'.$error.'</p>';
	?>
</body>