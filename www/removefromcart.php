<?php
	session_start();

	if (isset($_GET['id'])) {
		// connect to database
		require 'includes/db.php';

		// create safe values for use 
		$safe_id = mysqli_real_escape_string($mysqli, $_GET['id']);

		// NOTE: 
		// We shouldn't need these as items in cart are added to stock 'buffer' in store_shoppertrack,
		// we just delete the store_shoppertrack record when removed from cart

		//$safe_item_id = mysqli_real_escape_string($mysqli, $_GET['sid']);
		//$safe_stock = mysqli_real_escape_string($mysqli, $_GET['stock']);
		//$safe_qty = mysqli_real_escape_string($mysqli, $_GET['qty']);

		//$adj_sel_item_stock_sql = "UPDATE store_items SET item_stock = $safe_stock + $safe_qty WHERE id = $safe_item_id";
		//$adj_sel_item_stock_res = mysqli_query($mysqli, $adj_sel_item_stock_sql) or die(mysqli_error($mysqli));

		$delete_item_sql = "DELETE FROM store_shoppertrack WHERE
			id = '" . $safe_id . "' and session_id = '" . $_COOKIE['PHPSESSID'] . "'";

		$delete_item_res = mysqli_query($mysqli, $delete_item_sql) or die (mysqli_error($mysqli));

		// close connection to MySQL
		mysqli_close($mysqli);

		// redirect to cart page
		header('Location: cart.php');

	} else {
		// send them somewhere else
		header('Location: store.php');
		exit;
	}
?>
