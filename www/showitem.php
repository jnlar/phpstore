<?php
	session_start();
	require 'includes/db.php';

	$display_block = "<h2>My Store - Item Detail</h2>";

	$safe_item_id = mysqli_real_escape_string($mysqli, $_GET['item_id']);

	// validate item
	$get_item_sql = "SELECT c.id as cat_id, c.cat_title, si.item_title,
		si.item_price, si.item_desc, si.item_stock, si.item_image FROM store_items AS si
		LEFT JOIN store_categories AS c on c.id = si.cat_id
		WHERE si.id = '".$safe_item_id."'";

	$get_item_res = mysqli_query($mysqli, $get_item_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_item_res) < 1) {
		$display_block .= "<p><em>Invalid item selection.</em></p>";
	} else {
		while ($item_info = mysqli_fetch_array($get_item_res)) {
			$cat_id = $item_info['cat_id'];
			$cat_title = strtoupper(stripslashes($item_info['cat_title']));
			$item_title = stripslashes($item_info['item_title']);
			$item_price = $item_info['item_price'];
			$item_desc = stripslashes($item_info['item_desc']);
			$item_stock = $item_info['item_stock'];
			$item_image = $item_info['item_image'];
		}

		$display_block .= <<<EOT
			<p><em>You are viewing:</em></br>
			<strong><a href="store.php?cat_id=$cat_id">$cat_title</a> &gt;
			$item_title</strong></p>
			<div style="float: left;"><img src="$item_image" alt="$item_title"></div>
			<div style="float: left; padding-left: 12px">
			<p><strong>Description:</strong></br>$item_desc</p>
			<p><strong>Price:</strong>\$$item_price</p>
			<form method="POST" action="addtocart.php">
			EOT;

		// free result set
		mysqli_free_result($get_item_res);

		// get colors
		$get_colors_sql = "SELECT item_color FROM store_item_color WHERE
			item_id = '".$safe_item_id."' ORDER BY item_color";

		$get_colors_res = mysqli_query($mysqli, $get_colors_sql) or die(mysqli_error($mysqli));

		if (mysqli_num_rows($get_colors_res) > 0) {
			$display_block .= "<p><label for=\"sel_item_color\">
				Available Colors:</label><br/>
				<select id=\"sel_item_color\" name=\"sel_item_color\">";

			while ($colors = mysqli_fetch_array($get_colors_res)) {
				$item_color = $colors['item_color'];
				$display_block .= "<option value=\"" . $item_color . "\">" . $item_color . "</option>";
			}
			$display_block .= "</select></p>";

		}

		mysqli_free_result($get_colors_res);

		$display_block .= "</select></p><p><label for=\"sel_item_qty\">
			Select Quantity:</label><select id=\"sel_item_qty\" name=\"sel_item_qty\">";

		for ($i = 1; $i < $item_stock + 1; $i++) {
			if ($i == 10) break;
			$display_block .= "<option value=\"" . $i . "\">" . $i . "</option>";
		}

		$display_block .= <<<ENDOFTEXT
			</select></p><input type="hidden" name="sel_item_id" value="$_GET[item_id]">
			<button type="submit" name="submit" value="submit">Add to Cart</button>
			</form>
			</div>
		ENDOFTEXT;
	}

	mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "includes/head.php"; ?>
		<title>My Store</title>
		<style><?php include "css/main.css"; ?></style>
	</head>
	<body>
		<div id="wrapper">
			<?php include "includes/nav.php"; ?>
			<div id="inner-wrapper">
				<?php echo $display_block; ?>
			</div>
			<?php include "includes/footer.php"; ?>
		</div>
	</body>
</html>
