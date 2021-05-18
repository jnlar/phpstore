<?php
	if (isset($_GET['id'])) {
		require "includes/db.php";

		// create safe values
		$safe_id = $mysqli->real_escape_string($_GET['id']);

		$get_order_info_sql = "SELECT ss.sel_item_id, ss.sel_item_qty, si.item_title, si.id, si.item_price
			FROM store_shoppertrack AS ss INNER JOIN store_items AS si ON si.id = ss.sel_item_id 
			WHERE ss.session_id = '$safe_id'";
		$get_order_info_res = $mysqli->query($get_order_info_sql) or die($mysqli->error);

		$display_block = "<h2>Checkout</h2>";
		$total = 0;

		if ($get_order_info_res->num_rows < 1) {
			$display_block .= "<p>You have no items in your cart. Please
				<a href=\"store.php\">continue to shop</a>!</p>";
		} else {
			$display_block .= "
				<ul class=\"sl-nav\"><li><a href=\"store.php\">Continue shopping</a></li>
				<li><a href=\"cart.php\">Back to cart</a></li></ul>
				<table id=\"checkout-table\">
				<th scope=\"col\">Item</th><th scope=\"col\">Quantity</th><th scope=\"col\">Price [per unit]</th>";

			while ($order_info = $get_order_info_res->fetch_assoc()) {
				$sel_item_id = stripslashes($order_info['sel_item_id']);
				$sel_item_qty = stripslashes($order_info['sel_item_qty']);
				$item_price = stripslashes($order_info['item_price']);
				$item_title = stripslashes($order_info['item_title']);

				$total += sprintf("%.2f", $item_price * $sel_item_qty);

				$display_block .= <<<END_OF_TEXT
					<tr><td>$item_title</td>
					<td>$sel_item_qty</td>
					<td>$item_price</td></tr>
				END_OF_TEXT;
			}

			$display_block .= "<th scope=\"col\"colspan=\"3\" id=\"total-price\">Total</th><tr><td colspan=\"3\">&#36;$total</td></tr>";

			$display_block .= <<<END_OF_TEXT
				</table><form id="checkout-form" method="POST" action="do_checkout.php" onsubmit="return validateForm()">
					<ul>
						<li><label for="first-name">First Name: </label><input type="text" id="first-name" name="first-name"></li>
						<li><label for="last-name">Last Name: </label><input type="text" id="last-name" name="last-name"></li>
						<li><label for="address">Address: </label><input type="text" id="address" name="address"></li>
						<li><label for="city">City: </label><input type="text" id="city" name="city"></li>
						<li><label for="state">State: </label><input type="text" id="state" name="state"></li>
						<li><label for="postcode">Postcode: </label><input type="text" id="postcode" name="postcode"></li>
						<li><label for="tel">Telephone: </label><input type="text" id="tel" name="tel"></li>
						<li><label for="email">Email: </label><input type="text" id="email" name="email"></li>
						<li><button type="submit" name="submit" value="submit">Checkout</button></li>
						<li><input type="hidden" name="total" id="total" value="$total"></li>
					</ul>
				</form>
				<div id="error-box">
				</div>
			END_OF_TEXT;

			$get_order_info_res->free_result();
		}
	}
?>
<!DOCTYPE html>
<html lang=en>
	<head>
		<?php include "includes/head.php"; ?>
		<title>Checkout</title>
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
		<script src="js/validate.js"></script>
	</body>
</html>
