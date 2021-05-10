<?php
	require 'includes/db.php';

	$get_categories_sql = "SELECT * FROM forum_categories";
	$get_categories_res = mysqli_query($mysqli, $get_categories_sql) or die(mysqli_error($mysqli));
	$display_cat_sel = '';

	while ($cat_info = mysqli_fetch_array($get_categories_res)) {
		$cur_cat_name = $cat_info['category_name'];
		$cur_cat_id = $cat_info['category_id'];
		
		$display_cat_sel .= <<<END_OF_TEXT
			<option value="$cur_cat_id">$cur_cat_name</option>
		END_OF_TEXT;
	}

	if (isset($_POST['submit']) && $_POST['show_category'] !== 'default') {
		$current_cat = $_POST['show_category'];
		$get_sel_sql = "SELECT * FROM forum_topics WHERE category_id = $current_cat";
		$get_sel_res = mysqli_query($mysqli, $get_sel_sql) or die(mysqli_error($mysqli));

		$display_block = <<<END_OF_TEXT
			<table>
			<tr>
			<th>TOPIC TITLE</th>
			<th># of POSTS</th>
			</tr>
		END_OF_TEXT;

		while ($chosen_cat = mysqli_fetch_array($get_sel_res)) {
			$cat_topic_id = $chosen_cat['topic_id'];
			$cat_topic_title = $chosen_cat['topic_title'];
			$cat_topic_create_time = $chosen_cat['topic_create_time'];
			$cat_topic_owner = $chosen_cat['topic_owner'];

			$get_num_posts_sql = "SELECT COUNT(post_id) AS post_count FROM
				forum_posts WHERE topic_id = '$cat_topic_id'";

			$get_num_posts_res = mysqli_query($mysqli, $get_num_posts_sql) or die(mysqli_error($mysqli));

			while ($posts_info = mysqli_fetch_array($get_num_posts_res)) {
				$num_posts = $posts_info['post_count'];
			}

			$display_block .= <<<END_OF_TEXT
				<tr>
				<td><a href="show_topic.php?topic_id=$cat_topic_id">
				<strong>$cat_topic_title</strong></a><br/>
				Created on $cat_topic_create_time by $cat_topic_owner</td>
				<td class="num_posts_col">$num_posts</td>
				</tr>
			END_OF_TEXT;
		}

		$display_block .= "</table>";
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Topics</title>
	<style><?php include "css/main.css"; ?></style>
</head>
<body>
	<div id="wrapper">
		<?php include "includes/nav.php"; ?>
		<div id="inner-wrapper">
			<h1>Gardening Forum Categories</h1>
			<?php include "includes/forum_nav.php"; ?>
			<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method="POST">
				<label for="show_category">Pick a category:</label>
				<select id="show_category" name="show_category">
					<option value="default">Select...</option>
					<?php echo $display_cat_sel; ?>
				</select>
				<input type="submit" name="submit" value="Filter">
			</form><br/>
			<?php if (isset($_POST['submit']) && $_POST['show_category'] !== 'default') echo $display_block; ?>
		</div>
	</div>
</body>
</html>
