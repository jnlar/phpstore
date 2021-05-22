<?php
	session_start();

	if (isset($_GET['id'])) {
		require 'includes/db.php';

		$safe_id = $mysqli->real_escape_string($_GET['id']);
		$sess_id = $_COOKIE['PHPSESSID'];

		$delete_item_sql = "DELETE FROM store_shoppertrack WHERE
			id = '" . $safe_id . "' and session_id = '" . $sess_id . "'";

		$delete_item_res = $mysqli->query($delete_item_sql) or die ($mysqli->error);

		require 'includes/render_cart.php';

		echo $display_block;
		$get_cart_res->free_result();
		$mysqli->close();
	}
?>
