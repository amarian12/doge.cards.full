<?php
include_once 'dbcon.php';
include_once 'functions.php';
sec_session_start(); 
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DOGE.CARDS - Dogecoin Giftcards</title>
<link href="style.css?v28" rel="stylesheet" type="text/css" />
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
			if(isset($_GET['code']))
			{
				$link = new mysqli("HOST", "USERNAME", "PASSWORD", "DB");
				$query = "SELECT gckey, style, expiryDate FROM giftcards WHERE gckey = '" . $_GET['code'] . "' LIMIT 1";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_assoc($result);	
				if($row == NULL)
				{
					echo 'That key does not exist!';
					mysqli_close($link);
					die();
				}
				else
				{
					echo '<table><tr><td valign="top">';
					$shorturl = file_get_contents('http://tinyurl.com/api-create.php?url=http://doge.cards/result?code='.$_GET['code']);
					echo '<div id="field2-container" class="field f_50-2">
                      	<label for="field2">
                                URL:
                           </label>';
					echo '<input type="text" onClick="this.select();" value="' . $shorturl . '" /> </div><br/><br/>';
					echo '<div id="field3-container" class="field f_50-2">
                      	<label for="field3">
                                Code:
                           </label>';
					echo '<input type="text" style="width: 217px;" onClick="this.select();" value="' . $_GET['code'] . '" /> </div>';
					echo '</td><td>';
					echo '<img src=cardgen.php?code=' . $_GET['code'] . '&style=' . $row['style'] . '>';
					echo '</td></tr></table>';
					mysqli_close($link);
				}
			}
			?><br>
<br>
		
	</div></div>
     <?php include 'footer.php' ?>
</body>
</html>