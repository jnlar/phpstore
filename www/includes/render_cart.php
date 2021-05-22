<?php
	$get_cart_sql = "SELECT st.id, si.id as sid, si.item_title, si.item_price, si.item_stock, st.sel_item_qty,
		st.sel_item_color FROM store_shoppertrack AS st
		LEFT JOIN store_items AS si ON si.id = st.sel_item_id
		WHERE session_id = '$sess_id'";

	$get_cart_res = $mysqli->query($get_cart_sql) or die($mysqli->error);
	
	if ($get_cart_res->num_rows < 1) {
		$display_block = "<p>You have no items in your cart. Please
			<a href=\"store.php\">continue to shop</a>!</p>";
	} else {
		$display_block = <<<EOT
			<table>
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

		$display_block .= "</table>";
	}
?>
