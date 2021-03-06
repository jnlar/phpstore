<?php
	session_start();
	require 'includes/db.php';

	$display_block = "<h2>My Store - Item Detail</h2>
		<ul class=sl-nav>
		<li><a href=\"store.php\">Continue shopping</a></li>
		<li><a href=\"cart.php\">Cart</a></li></ul>";

	$safe_item_id = $mysqli->real_escape_string($_GET['item_id']);

	// validate item
	$get_item_sql = "SELECT c.id as cat_id, c.cat_title, si.item_title,
		si.item_price, si.item_desc, si.item_stock, si.item_image FROM store_items AS si
		LEFT JOIN store_categories AS c on c.id = si.cat_id
		WHERE si.id = '".$safe_item_id."'";

	$get_item_res = $mysqli->query($get_item_sql) or die($mysqli->error);

	if ($get_item_res->num_rows < 1) {
		$display_block .= "<p><em>Invalid item selection.</em></p>";
	} else {
		while ($item_info = $get_item_res->fetch_assoc()) {
			$cat_id = $item_info['cat_id'];
			$cat_title = strtoupper(stripslashes($item_info['cat_title']));
			$item_title = stripslashes($item_info['item_title']);
			$item_price = $item_info['item_price'];
			$item_desc = stripslashes($item_info['item_desc']);
			$item_stock = $item_info['item_stock'];
			$item_image = $item_info['item_image'];
		}

		$display_block .= <<<EOT
			<p><em>You are viewing:</em>
			<strong>$item_title</strong></p>
			<div style="float: left;"><img src="images/$item_image" alt="$item_title"width="150" height="200"></div>
			<div style="float: left; padding-left: 12px">
			<p><strong>Description:</strong></br>$item_desc</p>
			<p><strong>Price:</strong>\$$item_price</p>
			<form method="POST" action="addtocart.php">
			EOT;

		// free result set
		$get_item_res->free_result();

		// get colors
		$get_colors_sql = "SELECT item_color FROM store_item_color WHERE
			item_id = '".$safe_item_id."' ORDER BY item_color";

		$get_colors_res = $mysqli->query($get_colors_sql) or die($mysqli->error);

		if ($get_colors_res->num_rows > 0) {
			$display_block .= "<p><label for=\"sel_item_color\">
				Available Colors:</label><br/>
				<select id=\"sel_item_color\" name=\"sel_item_color\">";

			while ($colors = $get_colors_res->fetch_assoc()) {
				$item_color = $colors['item_color'];
				$display_block .= "<option value=\"" . $item_color . "\">" . $item_color . "</option>";
			}
			$display_block .= "</select></p>";

		}

		$get_colors_res->free_result();

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

	$mysqli->close();
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
