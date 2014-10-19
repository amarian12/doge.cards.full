<?php
include_once 'dbcon.php';
include_once 'functions.php';
sec_session_start(); 
?>

<?php echo <?php if(login_check($mysqli) == true) : ?>
        	<a href="dashboard" class="button">Dashboard</a>
			<a href="logout" class="button">Logout</a>
		<?php else : ?>
        	<a href="login" class="button">Login</a>
			<a href="register" class="button">Register</a>
		<?php endif; ?>
        <a href="redeem" class="button">Redeem</a>
        <a href="faucet" class="button">Faucet</a>
        <a href="faq" class="button">FAQs</a>
        <a href="contact" class="button">Contact</a>*/ ?>
