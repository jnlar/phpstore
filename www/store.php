<?php
	session_start();
	require 'includes/db.php';

	$get_cats_sql = "SELECT id, cat_title, cat_desc FROM store_categories ORDER BY cat_title";
	$get_cats_res = $mysqli->query($get_cats_sql) or die($mysqli->error);

	// in the instance where someone goes straight to store.php, a session cookie won't be created,
	// so we remove the checkout button until a session cookie exists.
	if (@$_COOKIE['PHPSESSID']) {
		$sess_id = $_COOKIE['PHPSESSID'];
		$can_checkout = "<li><a href=\"checkout.php?id=$sess_id\">Checkout</a></li>";
	} else $can_checkout = "";

	$display_block = "<ul class=sl-nav>
			<li><a href=\"cart.php\">Cart</a></li>$can_checkout</ul>";

	if ($get_cats_res->num_rows < 1) {
		$display_block .= "<p><em>Sorry, no categories to browse.</em></p>";
	} else {
		while ($categories = $get_cats_res->fetch_assoc()) {
			$cat_id = $categories['id'];
			$cat_title = stripslashes($categories['cat_title']);
			$cat_desc = stripslashes($categories['cat_desc']);

			$display_block .= 
				"<li><p class=\"item-cat-p\"><strong><a onclick=\"Ajax.getItems('$cat_id')\" 
				href=\"javascript:void(0)\">" . $cat_title. "</a><br/></strong><span>" . $cat_desc . "</span></p></li>
				<div id=\"$cat_id\" name=\"cat-items\"></div>";
		}
	}

	$get_cats_res->free_result();
	$mysqli->close();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "includes/head.php"; ?>
		<title>Shop</title>
		<style><?php include "css/main.css"; ?></style>
	</head>
	<body>
		<div id="wrapper">
			<?php include "includes/nav.php"; ?>
			<div id="inner-wrapper">
				<h2>Gardening items</h2>
				<?php echo $display_block; ?>
			</div>
			<?php include "includes/footer.php"; ?>
		</div>
		<script src="js/ajax.js"></script>
	</body>
</html>
