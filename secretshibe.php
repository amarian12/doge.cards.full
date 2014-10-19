<?php
include_once 'dbcon.php';
include_once 'functions.php';
sec_session_start(); 
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DOGE.CARDS - Dogecoin Giftcards</title>
<link href="style.css?v26" rel="stylesheet" type="text/css" />
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
        <?php
				$_SESSION['token'] = uniqid('', true);
				?>
<?php if(isset($_GET['success']))
				{
						echo "<p id='success'>Gift successful! You brightened the day of someone you don't know, feel proud!</p>";	
						echo "<br/>";
				}
				?> 
		<p class="theContent" style="text-align: center;"><img src="secretshibelogo.png"/></p>
        <p class="theContent">What is <strong>secret shibe</strong>? It's effectively a method of brightening up someone's day - you're able to send one of your available dogecards to a <strong>random</strong> member of doge.cards. You won't know who got it, they won't know who sent it, it's just a nice gesture of dogenerosity! After you choose to send one of your gift cards as a secret shibe gift, it will disappear from your dashboard (it'll still be taken off of your balance) and a random person will suddenly see a secret shibe giftcard on their dashboard with a special dogecard style! Secret shibe dogecards can <strong>not</strong> have an expiry date.</p>
       <br>
       <?php if(login_check($mysqli) == true) : ?>
        	 <p id='address'>Your Available Dogecards</p>
                <div class="pending" >
                <table >
                    <tr>
                        <td>
                            Date
                      </td>
                      <td>
                            Value
                      </td>
                      <td>
                            Gift it?
                      </td>
                    </tr>
                    <?php
						$link = new mysqli("HOST", "USERNAME", "PASSWORD", "DB");
						$query = "SELECT userID from users WHERE username = '" . $_SESSION['username'] . "'";
						$result = mysqli_query($link, $query);
						$userID = mysqli_fetch_assoc($result);
						$query = "SELECT * from giftcards WHERE userID = '" . $userID["userID"] . "' AND claimed = '0' AND expiryDate = '0000-00-00' AND gifted = '0'";
						if($result = mysqli_query($link, $query))
						{
							while ($row = mysqli_fetch_assoc($result)) {
								if($row["claimed"] == 0) { $isClaimed = "Unclaimed"; } else { $isClaimed = "Redeemed"; };
								if($row["expiryDate"] == "0000-00-00") { $expiryDate = "No expiry!"; } else { $expiryDate = $row["expiryDate"]; };
								if($row["redeemedTo"] == "0") { $isRedeemed = "Not yet redeemed!"; } else { $isRedeemed = $row["redeemedTo"]; };
								printf ("<tr> <td>%s</td> <td>%s</td> <td>%s</td>", $row["dateCreated"], $row["value"], "<a href='secretshibe.inc.php?code=".$row["gckey"]."'><img src='heart_add.png'/></a>");
							}	
						}
						mysqli_close($link);
					?>
                </table>
            </div>
		<?php else : ?>
        	<p id="success"><a href="https://doge.cards/register">Register</a> or <a href="https://doge.cards/login">Login</a> to start using secret shibe and all the other DOGE.CARDS services!</p>
		<?php endif; ?>
        </div>
	</div>
     <?php include 'footer.php' ?>
</body>
</html>