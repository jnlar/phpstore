<?php
	// TODO: 
	// (done) - populate store_orders with order information
	// (done) - adjust value of item_stock in store_items 
	// (done) - populate store_order_items with order items 
	// (done) - delete store_shoppertrack records
	// (done) - Page redirect
	// 1. Free result sets

	if (isset($_POST['submit'])) {
		session_start(); 
		require 'includes/db.php';

		$full_name = $_POST['first-name'] . " " . $_POST['last-name'];
		$order_name = $mysqli->real_escape_string($full_name);
		$order_addr = $mysqli->real_escape_string($_POST['address']);
		$order_city = $mysqli->real_escape_string($_POST['city']);
		$order_state = $mysqli->real_escape_string($_POST['state']);
		$order_postcode = $mysqli->real_escape_string($_POST['postcode']);
		$order_tel = $mysqli->real_escape_string($_POST['tel']);
		$order_email = $mysqli->real_escape_string($_POST['email']);
		$order_total = $mysqli->real_escape_string($_POST['total']);
		$sess_id = $mysqli->real_escape_string($_COOKIE['PHPSESSID']);

		$insert_order_sql = "INSERT into store_orders (
			id, order_date, order_name, order_address, order_city, order_state, order_zip, order_tel, order_email, item_total, status
			) VALUES ( NULL, now(), '$order_name', '$order_addr', '$order_city', '$order_state', $order_postcode, $order_tel,
			'$order_email', $order_total, 'processed' )";

		$insert_order_res = $mysqli->query($insert_order_sql) or die($mysqli->error);
		$cur_id = $mysqli->insert_id;

		$get_sel_order_sql = "SELECT ss.sel_item_id, ss.sel_item_qty, ss.sel_item_color, si.item_price, si.item_stock
		 	FROM store_shoppertrack AS ss INNER JOIN store_items AS si ON ss.sel_item_id = si.id WHERE session_id = '$sess_id'";
		$get_sel_order_res = $mysqli->query($get_sel_order_sql) or die($mysqli->error);

		while ($row = $get_sel_order_res->fetch_assoc()) {
			$sel_item_id = $row['sel_item_id'];
			$sel_item_qty = $row['sel_item_qty'];
			$sel_item_color = $row['sel_item_color'];
			$item_price = $row['item_price'];
			$item_stock = $row['item_stock'];

			// TODO: (done) - get corresponding order id
			// populate store_order_items with order
			$insert_order_items_sql = "INSERT into store_orders_items (
				order_id, sel_item_id, sel_item_qty, sel_item_color, sel_item_price
				) VALUES ( $cur_id, $sel_item_id, $sel_item_qty, '$sel_item_color', $item_price )";

			$insert_order_items_res = $mysqli->query($insert_order_items_sql) or die($mysqli->error);

			// adjust value of item_stock in store_items
			$adj_sel_item_stock_sql = "UPDATE store_items SET item_stock = $item_stock - $sel_item_qty WHERE id = $sel_item_id";
			$adj_sel_item_stock_res = $mysqli->query($adj_sel_item_stock_sql) or die($mysqli->error);

			// delete corresponding store_shoppertrack row from table as we no longer need it
			$delete_item_sql = "DELETE FROM store_shoppertrack WHERE
				id = '" . $safe_id . "' and session_id = '$sess_id'";

			$delete_item_res = $mysqli->query($delete_item_sql) or die($mysqli->error);

		}
		// FIXME
		// free result sets
		//$insert_order_res->free();
		//$adj_sel_item_stock_res->free();
		//$get_sel_order_res->free();
		//$insert_order_items_res->free();

		header('Location: store.php');
		session_destroy();
	} else {
		header('Location: checkout.php');
	}
?>
