<?php
	if (isset($_GET['q'])) {
		require 'includes/db.php';

		$cat_id = $mysqli->real_escape_string($_GET['q']);
		$get_cats_sql = "SELECT id, cat_title, cat_desc FROM store_categories ORDER BY cat_title";
		$get_cats_res = $mysqli->query($get_cats_sql) or die($mysqli->error);

		$get_items_sql = "SELECT id, item_title, item_price FROM store_items 
			WHERE cat_id = $cat_id ORDER BY item_title";
		$get_items_res = $mysqli->query($get_items_sql) or die($mysqli->error);

		if ($get_items_res->num_rows < 1) {
			$display_block = "<p><em>Sorry, no items in this category.</em></p>";
		} else {
			$display_block = "<ul>";

			while ($row = $get_items_res->fetch_assoc()) {
				$item_id = $row['id'];
				$item_title = stripslashes($row['item_title']);
				$item_price = $row['item_price'];

				$display_block .="<li><a 
					href=\"showitem.php?item_id=" . $item_id . "\">" . $item_title . "
					</a> (\$" . $item_price . ")</li>";
			}

			$display_block .= "</ul>";
			$get_items_res->free_result();
			echo $display_block;
		}

		$mysqli->close();
	}
?>
