<?php
	require 'includes/db.php';

	if (!$_POST) {
		if (!isset($_GET['post_id'])) {
			header("Location: topiclist.php");
			exit;
		}
		$safe_post_id = $mysqli->real_escape_string($_GET['post_id']);

		$verify_sql = "SELECT ft.topic_id, ft.topic_title, ft.category_id FROM forum_posts
			AS fp LEFT JOIN forum_topics AS ft on fp.topic_id = ft.topic_id 
			WHERE fp.post_id = '$safe_post_id'";

		$verify_res = $mysqli->query($verify_sql) or die($mysqli->error);

		if ($verify_res->num_rows < 1) {
			header("Location: topiclist.php");
			exit;
		} else  {
			while ($topic_info = $verify_res->fetch_assoc()) {
				$cat_id = $topic_info['category_id'];
				$topic_id = $topic_info['topic_id'];
				$topic_title = stripslashes($topic_info['topic_title']);
			}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "includes/head.php"; ?>
	<title>Post your reply in: <?php echo $topic_title; ?></title>
	<style><?php include "css/main.css"; ?></style>
</head>
<body>
	<div id="wrapper">
		<?php include "includes/nav.php"; ?>
		<div id="inner-wrapper">
			<h2>Reply to: <?php echo $topic_title; ?></h2>
			<?php include "includes/forum_nav.php"; ?>
			<p><a href="show_topic.php?topic_id=<?php echo $topic_id; ?>">Back to post</a></p>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<p><label for="post_owner">Your Email Address:</label><br/>
				<input type="email" id="post_owner" name="post_owner" size="40" maxlength="150" required="required"></p>
				<p><label for="post_text">Post Text:</label><br/>
				<textarea id="post_text" name="post_text" rows="8" cols="40" required="required"></textarea></p>
				<input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
				<input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>">
				<button type="submit" name="submit" value="submit">Add Post</button>
			</form>
		</div>
		<?php include "includes/footer.php"; ?>
	</div>
</body>
</html>
<?php
		}

		$verify_res->free_result();
		$mysqli->close();
	} else if ($_POST) {
		if ((!$_POST['topic_id']) || (!$_POST['post_text']) || (!$_POST['post_owner'])) {
			header("Location: topiclist.php");
			exit;
		}

		$safe_topic_id = $mysqli->real_escape_string($_POST['topic_id']);
		$safe_cat_id = $mysqli->real_escape_string($_POST['cat_id']);
		$safe_post_text = $mysqli->real_escape_string($_POST['post_text']);
		$safe_post_owner = $mysqli->real_escape_string($_POST['post_owner']);

		$add_post_sql = "INSERT INTO forum_posts (topic_id, post_text, post_create_time, post_owner, category_id)
			VALUES('$safe_topic_id', '$safe_post_text', NOW(), '$safe_post_owner', '$safe_cat_id')";

		$add_post_res = $mysqli->query($add_post_sql) or die($mysqli->error);

		$mysqli->close();

		header("Location: show_topic.php?topic_id=" . $_POST['topic_id']);
		exit;
	}
?>
