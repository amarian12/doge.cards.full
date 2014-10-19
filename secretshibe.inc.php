<?php
	include_once 'dbcon.php';
	include_once 'dbinfo.php';
	include_once 'functions.php';
	sec_session_start(); 
?>
<?php if(login_check($mysqli) == true) : ?>
		<?php else : ?>
        <p id='error'>You need to be logged in to access this page!</p>
        	<?php die(); ?>
		<?php endif; ?>
<?php
	$link = new mysqli("HOST", "USERNAME", "PASSWORD", "DB");
	$query = "SELECT gckey, claimed, gifted, expiryDate FROM giftcards WHERE gckey = '" . $_GET['code'] . "' LIMIT 1";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_assoc($result);	
	$query = "SELECT userID from users WHERE username = '" . $_SESSION['username'] . "' LIMIT 1";
	$result = mysqli_query($link, $query);
	$row2 = mysqli_fetch_assoc($result);	
	if($row == NULL)
	{
		echo 'That key does not exist!';
		mysqli_close($link);
		die();
	}
	else
	{
		if($row['claimed'] == 1)
		{
			echo 'This key has been claimed already!';
			mysqli_close($link);
			die();	
		}
		elseif($row['gifted'] == 1)
		{
			echo 'This key has been gifted already!';
			mysqli_close($link);
			die();	
		}
		elseif($row['expiryDate'] != '0000-00-00')
		{
			echo 'This key has an expiry date!';
			mysqli_close($link);
			die();	
		}
		else
		{
			$query = "UPDATE giftcards SET gifted='1' WHERE gckey = '" . $_GET['code'] . "'";
			$result = mysqli_query($link, $query);
			$query = "SELECT * FROM users WHERE userID != '". $row2['userID'] ."' ORDER BY RAND() LIMIT 1;";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_assoc($result);
			$query = "UPDATE giftcards SET giftedTo='".$row['userID']."' WHERE gckey='".$_GET['code']."'";
			$result = mysqli_query($link, $query);
			$query = "UPDATE giftcards SET style='99' WHERE gckey='".$_GET['code']."'";
			$result = mysqli_query($link, $query);
			mysqli_close($link);
			echo '<a href="https://doge.cards/secretthanks">Click here to continue..</a>';
			die();
		}
	}
	mysqli_close($link);
?>