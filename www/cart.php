<?php
	session_start();
	require 'includes/db.php';

	$sess_id = $_COOKIE['PHPSESSID'];
	$display_block = <<<EOT
		<h2>Your Shopping Cart</h2>
		<ul class=sl-nav>
		<li><a href="store.php">Continue shopping</a></li>
		<li><a href="checkout.php?id=$sess_id">Checkout</a></li></ul>
	EOT;

	$get_cart_sql = "SELECT st.id, si.id as sid, si.item_title, si.item_price, si.item_stock, st.sel_item_qty,
		st.sel_item_color FROM store_shoppertrack AS st
		LEFT JOIN store_items AS si ON si.id = st.sel_item_id
		WHERE session_id = '$sess_id'";

	$get_cart_res = $mysqli->query($get_cart_sql) or die($mysqli->error);
	
	if ($get_cart_res->num_rows < 1) {
		$display_block .= "<p>You have no items in your cart. Please
			<a href=\"store.php\">continue to shop</a>!</p>";
	} else {
		$display_block .= <<<EOT
			<div id="cart-container"><table>
			<tr>
			<th scope="col">Title</th>
			<th scope="col">Color</th>
			<th scope="col">Price</th>
			<th scope="col">Qty</th>
			<th scope="col">Total Price</th>
			<th scope="col">Action</th>
			</tr>
		EOT;

		while ($cart_info = $get_cart_res->fetch_assoc()) {
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
				<td><i onclick="Ajax.removeItem($id)" class="fa fa-trash-alt"></i></td>
				</tr>
			EOT;
		}

		$display_block .= "</table></div>";
	}

	$get_cart_res->free_result();
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang=en>
	<head>
		<?php include "includes/head.php"; ?>
		<title>My Cart</title>
		<style><?php include "css/main.css"; ?></style>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	</head>
	<body>
		<div id="wrapper">
			<?php include "includes/nav.php"; ?>
			<div id="inner-wrapper">
				<?php echo $display_block; ?>
			</div>
			<?php include "includes/footer.php"; ?>
		</div>
	<script src="js/ajax.js"></script>
	</body>
</html>
