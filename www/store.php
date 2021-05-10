<?php
	// TODO:
	// (done). AJAX implementation: get store items in category from db on click

	// connect to db
	require 'includes/db.php';

	$display_block = "<h1>Item Categories</h1>
		<p>Select a category to see its items.</p>";

	// show categories
	$get_cats_sql = "SELECT id, cat_title, cat_desc FROM store_categories ORDER BY cat_title";
	$get_cats_res = mysqli_query($mysqli, $get_cats_sql) or die(mysqli_error($mysqli));

	$display_block = "<div id=\"store-cat\">";

	if (mysqli_num_rows($get_cats_res) < 1) {
		$display_block .= "<p><em>Sorry, no categories to browse.</em></p>";
	} else {
		while ($categories = mysqli_fetch_array($get_cats_res)) {
			$cat_id = $categories['id'];
			$cat_title = stripslashes($categories['cat_title']);
			$cat_desc = stripslashes($categories['cat_desc']);

			$display_block .= 
				"<p><strong><a onclick=\"getItems('$cat_id')\" 
				href=\"javascript:void(0)\">" . $cat_title. "</a></strong><br/>" . $cat_desc . " </p>
				<div id=\"$cat_id\" name=\"cat-items\"></div>";
		}
	}

	$display_block .= "</div>";

	// free result set
	mysqli_free_result($get_cats_res);

	// close sql connection
	mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Shop</title>
		<style><?php include "css/main.css"; ?></style>
	</head>
	<body>
		<div id="wrapper">
			<?php include "includes/nav.php"; ?>
			<div id="inner-wrapper">
				<div id="shop-wrapper">
					<?php echo $display_block; ?>
				</div>
			</div>
		</div>
		<script src="js/get_store_items.js"></script>
	</body>
</html>
