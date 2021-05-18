<?php
	require 'includes/db.php';

	// gather the topics
	$get_topics_sql = "SELECT topic_id, topic_title,
		DATE_FORMAT(topic_create_time, '%b %e %Y at %r') AS
		fmt_topic_create_time, topic_owner, category_id FROM forum_topics
		ORDER BY topic_create_time DESC";

	$get_topics_res = mysqli_query($mysqli, $get_topics_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_topics_res) < 1) {
		// there are no topics, so say
		$display_block = "<p><em>No topics exist.</em></p>";
	} else {
		// create the display string
		$display_block = <<<END_OF_TEXT
		<table>
		<tr>
		<th scope="col">Topic Title</th>
		<th scope="col">Topic Category</th>
		<th scope="col"># of Posts</th>
		</tr>
		END_OF_TEXT;

		while ($topic_info = mysqli_fetch_array($get_topics_res)) {
			$topic_id = $topic_info['topic_id'];
			$topic_title = stripslashes($topic_info['topic_title']);
			$topic_create_time = $topic_info['fmt_topic_create_time'];
			$topic_owner = stripslashes($topic_info['topic_owner']);
			$topic_cat = $topic_info['category_id'];

			// get number of posts
			$get_num_posts_sql = "SELECT COUNT(post_id) AS post_count FROM
				forum_posts WHERE topic_id = '$topic_id'";

			$get_num_posts_res = mysqli_query($mysqli, $get_num_posts_sql) or die(mysqli_error($mysqli));

			while ($posts_info = mysqli_fetch_array($get_num_posts_res)) {
				$num_posts = $posts_info['post_count'];

			}

			// TODO: get topic category!
			$get_topic_cat_sql = "SELECT category_name 
				FROM forum_categories
				WHERE category_id = $topic_cat";

			$get_topic_cat_res = mysqli_query($mysqli, $get_topic_cat_sql) or die(mysqli_error($mysqli));

			while ($topic_cat_name = mysqli_fetch_array($get_topic_cat_res)) {
				$cur_cat = $topic_cat_name['category_name'];
			}

			// add to display
			$display_block .= <<<END_OF_TEXT
				<tr>
				<td><a href="show_topic.php?topic_id=$topic_id">
				<strong>$topic_title</strong></a><br/>
				Created on $topic_create_time by $topic_owner</td>
				<td class="topic_cat">$cur_cat</td>
				<td class="num_posts_col">$num_posts</td>
				</tr>
			END_OF_TEXT;
		}

		// free result set
		mysqli_free_result($get_topics_res);
		mysqli_free_result($get_num_posts_res);


		// close table
		$display_block .= "</table>";
	}

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

		$cat_display_block = <<<END_OF_TEXT
			<table>
			<tr>
			<th scope="col">Topic Title</th>
			<th scope="col"># of Posts</th>
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

			$cat_display_block .= <<<END_OF_TEXT
				<tr>
				<td><a href="show_topic.php?topic_id=$cat_topic_id">
				<strong>$cat_topic_title</strong></a><br/>
				Created on $cat_topic_create_time by $cat_topic_owner</td>
				<td class="num_posts_col">$num_posts</td>
				</tr>
			END_OF_TEXT;
		}

		$cat_display_block .= "</table>";
		$display_block = '';
	}

	// close connection to db
	mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "includes/head.php"; ?>
	<title>All Topics</title>
	<style><?php include "css/main.css"; ?></style>
</head>
<body>
	<div id="wrapper">
		<?php include "includes/nav.php"; ?>
		<div id="inner-wrapper">
			<h2>Gardening Forum</h2>
			<?php include "includes/forum_nav.php" ?>
			<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method="POST">
				<label for="show_category">Pick a category:</label>
				<select id="show_category" name="show_category">
					<option value="default">Select...</option>
					<?php echo $display_cat_sel; ?>
				</select>
				<input type="submit" name="submit" value="Filter">
			</form><br/>
			<?php if (isset($_POST['submit']) && $_POST['show_category'] !== 'default') echo $cat_display_block; ?>
			<?php echo $display_block; ?>
		</div>
		<?php include "includes/footer.php"; ?>
	</div>
</body>
</html>
