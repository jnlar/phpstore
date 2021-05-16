<?php
	require 'includes/db.php';

	$get_cats_sql = "SELECT id, cat_title, cat_desc FROM store_categories ORDER BY cat_title";
	$get_cats_res = mysqli_query($mysqli, $get_cats_sql) or die(mysqli_error($mysqli));

	if (@$_COOKIE['PHPSESSID']) {
		$sess_id = $_COOKIE['PHPSESSID'];
		$can_checkout = "<li><a href=\"checkout.php?id=$sess_id\">Checkout</a></li>";
	} else $can_checkout = "";

	$display_block = "<ul class=sl-nav>
			<li><a href=\"cart.php\">Cart</a></li>$can_checkout</ul>";

	if (mysqli_num_rows($get_cats_res) < 1) {
		$display_block .= "<p><em>Sorry, no categories to browse.</em></p>";
	} else {
		while ($categories = mysqli_fetch_array($get_cats_res)) {
			$cat_id = $categories['id'];
			$cat_title = stripslashes($categories['cat_title']);
			$cat_desc = stripslashes($categories['cat_desc']);

			$display_block .= 
				"<p class=\"item-cat-p\"><strong><a onclick=\"getItems('$cat_id')\" 
				href=\"javascript:void(0)\">" . $cat_title. "</a></strong><span>&nbsp;&mdash;&nbsp;" . $cat_desc . "</span></p>
				<div id=\"$cat_id\" name=\"cat-items\"></div>";
		}
	}

	mysqli_free_result($get_cats_res);
	mysqli_close($mysqli);
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
		<script src="js/get_store_items.js"></script>
	</body>
</html>
