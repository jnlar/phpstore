<?php
	session_start();
	require 'includes/db.php';

	$display_block = "<h2>Your Shopping Cart</h2>";

	$get_cart_sql = "SELECT st.id, si.id as sid, si.item_title, si.item_price, si.item_stock, st.sel_item_qty,
		st.sel_item_color FROM store_shoppertrack AS st
		LEFT JOIN store_items AS si ON si.id = st.sel_item_id
		WHERE session_id = '" . @$_COOKIE['PHPSESSID'] . "'";

	$get_cart_res = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));
	
	if (mysqli_num_rows($get_cart_res) < 1) {
		$display_block .= "<p>You have no items in your cart. Please
			<a href=\"store.php\">continue to shop</a>!</p>";
	} else {
		$display_block .= <<<EOT
			<table>
			<tr>
			<th>Title</th>
			<th>Color</th>
			<th>Price</th>
			<th>Qty</th>
			<th>Total Price</th>
			<th>Action</th>
			</tr>
		EOT;

		while ($cart_info = mysqli_fetch_array($get_cart_res)) {
			$id = $cart_info['id'];
			$st_i_id = $cart_info['sid'];
			$item_title = stripslashes($cart_info['item_title']);
			$item_price = $cart_info['item_price'];
			$item_qty = $cart_info['sel_item_qty'];
			$item_color = $cart_info['sel_item_color'];
			$item_stock = $cart_info['item_stock'];
			$total_price = sprintf("%.02f", $item_price * $item_qty);

			$display_block .= <<<EOT
				<tr>
				<td>$item_title</td>
				<td>$item_color</td>
				<td>\$ $item_price</td>
				<td>$item_qty</td>
				<td>\$ $total_price</td>
				<td><a href="removefromcart.php?id=$id&amp;sid=$st_i_id&amp;stock=$item_stock&amp;qty=$item_qty">remove</a></td>
				</tr>
			EOT;
		}

		$display_block .= "</table><p><a href=\"store.php\">Continue shopping</a></p>
			<button><a href=\"checkout.php?id=" . $_COOKIE['PHPSESSID'] . "\">Checkout</a></button>";
	}

	mysqli_free_result($get_cart_res);
	mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html lang=en>
	<head>
		<?php include "includes/head.php"; ?>
		<title>My Cart</title>
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
