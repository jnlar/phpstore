<?php
	session_start();

	if (isset($_POST['sel_item_id'])) {
		require 'includes/db.php';

		// create safe values for use
		$safe_sel_item_id = $mysqli->real_escape_string($_POST['sel_item_id']);
		$safe_sel_item_qty = $mysqli->real_escape_string($_POST['sel_item_qty']);
		$safe_sel_item_color = $mysqli->real_escape_string($_POST['sel_item_color']);

		$get_iteminfo_sql = "SELECT * FROM store_items WHERE id = '" . $safe_sel_item_id . "'";
		$get_iteminfo_res = $mysqli->query($get_iteminfo_sql) or die($mysqli->error);

		if ($get_iteminfo_res->num_rows < 1) {
			$get_iteminfo_res->free_result();
			$mysqli->close();

			header('Location: store.php');
			exit;
		} else {
			while ($item_info = $get_iteminfo_res->fetch_assoc()) {
				$item_title = stripslashes($item_info['item_title']);
			}

			$get_iteminfo_res->free_result();

			if ($safe_sel_item_color === '') $safe_sel_item_color = 'n/a';

			$addtocart_sql = "INSERT INTO store_shoppertrack
				(session_id, sel_item_id, sel_item_qty, sel_item_color, date_added)
				VALUES ('" . $_COOKIE['PHPSESSID'] . "',
				'" . $safe_sel_item_id . "', 
				'" . $safe_sel_item_qty . "', 
				'" . $safe_sel_item_color . "', now())";

			$addtocart_res = $mysqli->query($addtocart_sql) or die ($mysqli->error);

			$mysqli->close();

			header('Location: cart.php');
			exit;
		}
	} else {

		header('Location: store.php');
		exit;
	}
?>
