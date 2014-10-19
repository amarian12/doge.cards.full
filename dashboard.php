<?php
include_once 'dbcon.php';
include_once 'dbinfo.php';
include_once 'functions.php';
sec_session_start(); 
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DOGE.CARDS - Dogecoin Giftcards</title>
<link href="style.css?v64" rel="stylesheet" type="text/css" />
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
      	<?php include 'navigation.php' ?>
<br>

		<p class="theContent">Welcome to the <b>doge.cards</b> dashboard, <?php echo $_SESSION['username'] ?>! Here you can create gift cards, check up on your balance and redeem existing gift cards. Use the address below to deposit funds in order to use the dogecard system (may take up to an hour to process and show in your balance, this is due to the slow API, hopefully we can fix this at a later stage!).
		</p><br>
	<br>
    <?php
		if(isset($_POST['removecards']))
		{
			$link = new mysqli("HOST", "USERNAME", "PASSWORD", "DB");
			$query = "SELECT userID from users WHERE username = '" . $_SESSION['username'] . "'";
			$result = mysqli_query($link, $query);
			$userID = mysqli_fetch_assoc($result);
			$query = "SELECT * from giftcards WHERE userID = '" . $userID["userID"] . "' AND gifted = '0' AND claimed = '1'";
			$result = mysqli_query($link, $query);
			$numcards = mysqli_num_rows($result);
			$query = "DELETE FROM giftcards WHERE gifted = '0' AND claimed = '1' AND userID = '". $userID["userID"] . "'";
			$result = mysqli_query($link, $query);
			$query = "UPDATE info SET deletedCards=deletedCards+".$numcards;
			$result = mysqli_query($link, $query);	
			mysqli_close();
		}
		$link = new mysqli("HOST", "USERNAME", "PASSWORD", "DB");
		$query = "SELECT walletAddress, walletUser from users WHERE username = '" . $_SESSION['username'] . "' LIMIT 1";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_assoc($result);
		echo "<p id='address'>" . $row['walletAddress'] . "</p>";
		$balance = file_get_contents('https://www.dogeapi.com/wow/v2/?api_key=APIKEY&a=get_user_balance&user_id=' . $row['walletUser']);
		$json_a = json_decode($balance,true); 
		$new_balance = $json_a['data'][balance];
		echo "Confirmed Balance: " . $new_balance . " Ðoge";		
		$history = file_get_contents('https://www.dogeapi.com/wow/v2/?api_key=APIKEY&a=get_transactions&num=8&type=receive&user_id=' . $row['walletUser']);
		$json_b = json_decode($history,true); 
		$history2 = $json_b['data']['transactions'][0][address];
		$history3 = $json_b['data']['transactions'][0][amount];
		$histime = $json_b['data']['transactions'][0][transaction_time];
		$history4 = gmdate("Y-m-d\ - H:i:s", $histime);
		$query = "SELECT userID from users WHERE username = '" . $_SESSION['username'] . "'";
		$result = mysqli_query($link, $query);
		$userIDs = mysqli_fetch_assoc($result);
		$query = "SELECT * from giftcards WHERE gifted = '1' AND giftedTo = '". $userIDs["userID"] . "'";
		$result = mysqli_query($link, $query);
		$numshibes = mysqli_num_rows($result);
		mysqli_close($link);
	?>
    <br>
<br>
            <?php if($numshibes == 0) : ?>
		<?php else : ?>
        <p id='address'>Your Secret Shibe Gifts</p>
                <div class="pending" >
                <table >
                    <tr>
                        <td>
                            Date
                      </td>
                        <td >
                            Key
                        </td>
                      <td>
                            Value
                      </td>
                      <td>
                            Link
                      </td>
                      <td>
                            Status 
                      </td>
                      <td>
                            Destination
                      </td>
                    </tr>
                    <?php
						$link = new mysqli("HOST", "USERNAME", "PASSWORD", "DB");
						$query = "SELECT userID from users WHERE username = '" . $_SESSION['username'] . "'";
						$result = mysqli_query($link, $query);
						$userID = mysqli_fetch_assoc($result);
						$query = "SELECT * from giftcards WHERE gifted = '1' AND giftedTo = '". $userID["userID"] . "'";
						if($result = mysqli_query($link, $query))
						{
							while ($row = mysqli_fetch_assoc($result)) {
								if($row["claimed"] == 0) { $isClaimed = "Unclaimed"; } else { $isClaimed = "Redeemed"; };
								if($row["redeemedTo"] == "0") { $isRedeemed = "Not yet redeemed!"; } else { $isRedeemed = $row["redeemedTo"]; };
								printf ("<tr> <td>%s</td> <td>%s</td> <td>%s (%s)</td> <td><a href='http://doge.cards/result?code=" . $row["gckey"] . "'>Click Here</a></td> <td>%s</td> <td>%s</td> </tr>", $row["dateCreated"], $row["gckey"], $row["value"], $row["value"] * ((100-0.5) / 100), $isClaimed, $isRedeemed);
							}	
						}
						mysqli_close($link);
					?>
                </table>
            </div>
            <br/>
		<?php endif; ?>

            <p id='address'>Your Dogecards</p>
                <div class="pending" >
                <table >
                    <tr>
                        <td>
                            Date
                      </td>
                        <td >
                            Key
                        </td>
                      <td>
                            Value
                      </td>
                      <td>
                            Link
                      </td>
                      <td>
                            Expiry
                      </td>
                      <td>
                            Status 
                      </td>
                      <td>
                            Destination
                      </td>
                      <td>
                            Style
                      </td>
                    </tr>
                    <?php
						$link = new mysqli("HOST", "USERNAME", "PASSWORD", "DB");
						$query = "SELECT userID from users WHERE username = '" . $_SESSION['username'] . "'";
						$result = mysqli_query($link, $query);
						$userID = mysqli_fetch_assoc($result);
						$query = "SELECT dateCreated, claimed, value, expiryDate, gckey, redeemedTo, style from giftcards WHERE userID = '" . $userID["userID"] . "' AND gifted = '0' ORDER BY gcID DESC";
						if($result = mysqli_query($link, $query))
						{
							while ($row = mysqli_fetch_assoc($result)) {
								if($row["claimed"] == 0) { $isClaimed = "Unclaimed"; } else { $isClaimed = "Redeemed"; };
								if($row["expiryDate"] == "0000-00-00") { $expiryDate = "No expiry!"; } else { $expiryDate = $row["expiryDate"]; };
								if($row["redeemedTo"] == "0") { $isRedeemed = "Not yet redeemed!"; } else { $isRedeemed = $row["redeemedTo"]; };
								printf ("<tr> <td>%s</td> <td>%s</td> <td>%s (%s)</td> <td><a href='http://doge.cards/result?code=" . $row["gckey"] . "'>Click Here</a></td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td></tr>", $row["dateCreated"], $row["gckey"], $row["value"], $row["value"] * ((100-0.5) / 100), $expiryDate, $isClaimed, $isRedeemed, $row['style']);
							}	
						}
						mysqli_close($link);
					?>
                </table></div><br/>
                <form action='' method="post"> 
                <div id="form-submit" class="field f_100 clearfix submit">
                           <input type="submit" name="removecards" value="Remove Redeemed Dogecards">
                </div>       
            	</form><br/><br/>
        </div>
        </div>
     <?php include 'footer.php' ?>

</body>
</html>