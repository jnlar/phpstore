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
		<th>TOPIC TITLE</th>
		<th>TOPIC CATEGORY</th>
		<th># of POSTS</th>
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

		// close connection to db
		mysqli_close($mysqli);

		// close table
		$display_block .= "</table>";
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>All Topics</title>
	<style><?php include "css/main.css"; ?></style>
</head>
<body>
	<div id="wrapper">
		<?php include "nav.php"; ?>
		<div id="inner-wrapper">
			<h1>Gardening Forum</h1>
			<?php include "forum_nav.php" ?>
			<?php echo $display_block; ?>
		</div>
	</div>
</body>
</html>
