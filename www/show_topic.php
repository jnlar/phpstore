<?php
	require 'includes/db.php';

	// check for required info from the qeuery string
	if (!isset($_GET['topic_id'])) {
		header("Location: topiclist.php");
		exit;
	}

	// create safe vaules for use
	$safe_topic_id = mysqli_real_escape_string($mysqli, $_GET['topic_id']);

	// verify topic exists
	$verify_topic_sql = "SELECT topic_title FROM forum_topics WHERE topic_id = '" . $safe_topic_id . "'";
	$verify_topic_res = mysqli_query($mysqli, $verify_topic_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($verify_topic_res) < 1) {
		// topic doesn't exist
		$display_block = "<p><em>You have selected an invalid topic.<br/>
			Please <a href=\"topiclist.php\">try again</a>.</em></p>";
	} else {
		// get the topic title
		while ($topic_info = mysqli_fetch_array($verify_topic_res)) {
			$topic_title = stripslashes($topic_info['topic_title']);
		}

		// gather the posts
		$get_posts_sql = "SELECT post_id, post_text, DATE_FORMAT(
			post_create_time, '%b %e %Y<br/>%r') AS fmt_post_create_time, post_owner
			FROM forum_posts
			WHERE topic_id = '$safe_topic_id'
			ORDER BY post_create_time ASC";

		$get_post_res = mysqli_query($mysqli, $get_posts_sql) or die(mysqli_error($mysqli));

		$get_post_cat_sql = "SELECT category_id FROM forum_posts WHERE topic_id = $safe_topic_id";
		$get_post_cat_res = mysqli_query($mysqli, $get_post_cat_sql) or die(mysqli_error($mysqli));

		while ($post_cat = mysqli_fetch_array($get_post_cat_res)) {
			$post_category = stripslashes($post_cat['category_id']);
		}

		$get_cat_name_sql = "SELECT category_name FROM forum_categories WHERE category_id = $post_category";
		$get_cat_name_res = mysqli_query($mysqli, $get_cat_name_sql) or die(mysqli_error($mysqli));

		while ($cat_info = mysqli_fetch_array($get_cat_name_res)) {
			$cat_title = stripslashes($cat_info['category_name']);
		}

		// create the display string
		$display_block = <<<END_OF_TEXT
			<p>Category: <strong>$cat_title</strong></p>
			<table>
			<tr>
			<th>AUTHOR</th>
			<th>POST</th>
			</tr>
		END_OF_TEXT;

		while ($posts_info = mysqli_fetch_array($get_post_res)) {
			$post_id = $posts_info['post_id'];
			$post_text = nl2br(stripslashes($posts_info['post_text']));
			$post_create_time = $posts_info['fmt_post_create_time'];
			$post_owner = stripslashes($posts_info['post_owner']);

			// add to display
			$display_block .= <<<END_OF_TEXT
				<tr>
				<td>$post_owner<br/><br/>
				created on:<br/>$post_create_time</td>
				<td>$post_text<br/><br/>
				<a href="reply_to_post.php?post_id=$post_id">
				<strong>REPLY TO POST</strong></a></td>
				</tr>
			END_OF_TEXT;
		}

		// free results
		mysqli_free_result($get_post_res);
		mysqli_free_result($verify_topic_res);

		// close connection
		mysqli_close($mysqli);

		// close table
		$display_block .= "</table>";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "includes/head.php"; ?>
	<title>Posts in: <?php echo $topic_title; ?></title>
	<style><?php include "css/main.css"; ?></style>
</head>
<body>
	<div id="wrapper">
		<?php include "includes/nav.php"; ?>
		<div id="inner-wrapper">
		<?php include "includes/forum_nav.php"; ?>
			<h2>Post topic: <?php echo $topic_title; ?></h2>
			<?php echo $display_block; ?>
		</div>
		<?php include "includes/footer.php"; ?>
	</div>
</body>
</html>
