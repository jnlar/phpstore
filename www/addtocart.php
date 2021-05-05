<?php
	session_start();

	if (isset($_POST['sel_item_id'])) {
		// connect to db
		require 'includes/db.php';

		// create safe values for use
		$safe_sel_item_id = mysqli_real_escape_string($mysqli, $_POST['sel_item_id']);
		$safe_sel_item_qty = mysqli_real_escape_string($mysqli, $_POST['sel_item_qty']);
		$safe_sel_item_color = mysqli_real_escape_string($mysqli, $_POST['sel_item_color']);

		// validate item and get title and price
		$get_iteminfo_sql = "SELECT * FROM store_items WHERE id = '" . $safe_sel_item_id . "'";
		$get_iteminfo_res = mysqli_query($mysqli, $get_iteminfo_sql) or die(mysqli_error($mysqli));

		// adjust item_stock value dependent on sel_item_qty
		//$get_item_stock_sql = "SELECT item_stock FROM store_items WHERE id = $safe_sel_item_id";
		//$get_item_stock_res = mysqli_query($mysqli, $get_item_stock_sql) or die(mysqli_error($mysqli));
		//$adj_sel_item_stock_sql = "UPDATE store_items SET item_stock = $get_item_stock_res - $safe_sel_item_qty WHERE id = $safe_sel_item_id";
		//$adj_sel_item_stock_res = mysqli_query($mysqli, $adj_sel_item_stock_sql) or die(mysqli_error($mysqli));

		if (mysqli_num_rows($get_iteminfo_res) < 1) {
			// free result
			mysqli_free_result($get_iteminfo_res);

			// close connection
			mysqli_close($mysqli);

			// invalid id, send anyway
			header('Location: store.php');
			exit;
		} else {
			// get info
			while ($item_info = mysqli_fetch_array($get_iteminfo_res)) {
				$item_title = stripslashes($item_info['item_title']);
				//$item_stock = $item_info['item_stock'];
			}

			// adjust item_stock value dependent on sel_item_qty
			//$adj_sel_item_stock_sql = "UPDATE store_items SET item_stock = $item_stock - $safe_sel_item_qty WHERE id = $safe_sel_item_id";
			//$adj_sel_item_stock_res = mysqli_query($mysqli, $adj_sel_item_stock_sql) or die(mysqli_error($mysqli));

			// free result
			mysqli_free_result($get_iteminfo_res);
			//mysqli_free_result($adj_sel_item_stock_res);

			// add info to cart table

			if ($safe_sel_item_color === '') $safe_sel_item_color = 'n/a';

			$addtocart_sql = "INSERT INTO store_shoppertrack
				(session_id, sel_item_id, sel_item_qty, sel_item_color, date_added)
				VALUES ('" . $_COOKIE['PHPSESSID'] . "',
				'" . $safe_sel_item_id . "', 
				'" . $safe_sel_item_qty . "', 
				'" . $safe_sel_item_color . "', now())";

			$addtocart_res = mysqli_query($mysqli, $addtocart_sql) or die (mysqli_error($mysqli));

			// close connection to MySQL
			mysqli_close($mysqli);

			// redirect to cart page
			header('Location: cart.php');
			exit;
		}
	} else {
		// send to store
		header('Location: store.php');
		exit;
	}
?>
