<?php
	require 'includes/db.php';

	$get_categories_sql = "SELECT * FROM forum_categories";
	$get_categories_res = mysqli_query($mysqli, $get_categories_sql) or die(mysqli_error($mysqli));
	$display_block = '';

	while ($cat_info = mysqli_fetch_array($get_categories_res)) {
		$cur_cat_name = $cat_info['category_name'];
		$cur_cat_id = $cat_info['category_id'];
		
		$display_block .= <<<END_OF_TEXT
			<option value="$cur_cat_id">$cur_cat_name</option>
		END_OF_TEXT;
	}

	mysqli_free_result($get_categories_res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "includes/head.php"; ?>
	<title>Add a Topic</title>
	<style><?php include "css/main.css"; ?></style>
</head>
<body>
	<div id="wrapper">
		<?php include "includes/nav.php"; ?>
		<div id="inner-wrapper">
			<h2>Add a Post</h2>
			<?php include "includes/forum_nav.php"; ?>
			<form method="post" action="do_add_topic.php">
				<p><label for="select_category">Categories:</label><br/>
					<select name="select_category">
						<option value="default" name="default">Choose a Category</option>
						<?php echo $display_block; ?>
					</select>
				</p>
				<p><label for="topic_owner">Your Email Address:</label><br/>
					<input type="email" id="topic_owner" name="topic_owner" size="40" maxlength="150" required="required">
				</p>
				<p><label for="topic_title">Topic Title:</label><br/>
					<input type="text" id="topic_title" name="topic_title" size="40" maxlength="150" required="required">
				</p>
				<p><label for="post_text">Post Text:</label><br/>
					<textarea id="post_text" name="post_text" cols="40" rows="8"></textarea>
				</p>
				<button type="submit" name="submit" value="submit">Add Topic</button>
			</form>
		</div>
		<?php include "includes/footer.php"; ?>
	</div>
</body>
</html>
