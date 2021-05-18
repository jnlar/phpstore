<?php
	session_start();

	if (isset($_GET['id'])) {
		require 'includes/db.php';

		$safe_id = $mysqli->real_escape_string($_GET['id']);

		$delete_item_sql = "DELETE FROM store_shoppertrack WHERE
			id = '" . $safe_id . "' and session_id = '" . $_COOKIE['PHPSESSID'] . "'";

		$delete_item_res = $mysqli->query($delete_item_sql) or die ($mysqli->error);

		$mysqli->close();

		header('Location: cart.php');
	} else {
		header('Location: store.php');
		exit;
	}
?>
