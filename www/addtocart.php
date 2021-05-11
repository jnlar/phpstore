<?php
	session_start();

	if (isset($_POST['sel_item_id'])) {
		require 'includes/db.php';

		// create safe values for use
		$safe_sel_item_id = mysqli_real_escape_string($mysqli, $_POST['sel_item_id']);
		$safe_sel_item_qty = mysqli_real_escape_string($mysqli, $_POST['sel_item_qty']);
		$safe_sel_item_color = mysqli_real_escape_string($mysqli, $_POST['sel_item_color']);

		$get_iteminfo_sql = "SELECT * FROM store_items WHERE id = '" . $safe_sel_item_id . "'";
		$get_iteminfo_res = mysqli_query($mysqli, $get_iteminfo_sql) or die(mysqli_error($mysqli));

		if (mysqli_num_rows($get_iteminfo_res) < 1) {
			mysqli_free_result($get_iteminfo_res);
			mysqli_close($mysqli);

			header('Location: store.php');
			exit;
		} else {
			while ($item_info = mysqli_fetch_array($get_iteminfo_res)) {
				$item_title = stripslashes($item_info['item_title']);
			}

			mysqli_free_result($get_iteminfo_res);

			if ($safe_sel_item_color === '') $safe_sel_item_color = 'n/a';

			$addtocart_sql = "INSERT INTO store_shoppertrack
				(session_id, sel_item_id, sel_item_qty, sel_item_color, date_added)
				VALUES ('" . $_COOKIE['PHPSESSID'] . "',
				'" . $safe_sel_item_id . "', 
				'" . $safe_sel_item_qty . "', 
				'" . $safe_sel_item_color . "', now())";

			$addtocart_res = mysqli_query($mysqli, $addtocart_sql) or die (mysqli_error($mysqli));

			mysqli_close($mysqli);

			header('Location: cart.php');
			exit;
		}
	} else {

		header('Location: store.php');
		exit;
	}
?>
