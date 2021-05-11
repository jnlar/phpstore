<?php
	session_start();

	if (isset($_GET['id'])) {
		require 'includes/db.php';

		$safe_id = mysqli_real_escape_string($mysqli, $_GET['id']);

		$delete_item_sql = "DELETE FROM store_shoppertrack WHERE
			id = '" . $safe_id . "' and session_id = '" . $_COOKIE['PHPSESSID'] . "'";

		$delete_item_res = mysqli_query($mysqli, $delete_item_sql) or die (mysqli_error($mysqli));

		mysqli_close($mysqli);

		header('Location: cart.php');
	} else {
		header('Location: store.php');
		exit;
	}
?>
