<?php
	session_start();
	require 'includes/db.php';

	$sess_id = $_COOKIE['PHPSESSID'];
	$nav_block = <<<EOT
		<h2>Your Shopping Cart</h2>
		<ul class=sl-nav>
		<li><a href="store.php">Continue shopping</a></li>
		<li><a href="checkout.php?id=$sess_id">Checkout</a></li></ul><div id="cart-container">
	EOT;

	require 'includes/render_cart.php';

	$display_block .= "</div>";

	$get_cart_res->free_result();
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang=en>
	<head>
		<?php include "includes/head.php"; ?>
		<title>My Cart</title>
		<style><?php include "css/main.css"; ?></style>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" 
			integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" 
			crossorigin="anonymous" referrerpolicy="no-referrer" />
	</head>
	<body>
		<div id="wrapper">
			<?php include "includes/nav.php"; ?>
			<div id="inner-wrapper">
				<?php echo $nav_block; ?>
				<?php echo $display_block; ?>
			</div>
			<?php include "includes/footer.php"; ?>
		</div>
	<script src="js/ajax.js"></script>
	</body>
</html>
