<?php
	require 'includes/db.php';

	// check for required fields from the form
	//if ((!$_POST['topic_owner']) || (!$_POST['topic_title']) || (!$_POST['post_text'])) {
	//	header("Location: add_topic.php");
	//	exit();
	//}

	// create safe values for input into the database
	$clean_topic_owner = mysqli_real_escape_string($mysqli, $_POST['topic_owner']);
	$clean_topic_title = mysqli_real_escape_string($mysqli, $_POST['topic_title']);
	$clean_post_text = mysqli_real_escape_string($mysqli, $_POST['post_text']);

	// get category_id 
	$cat_id = $_POST['select_category'];

	// create and issue the first query
	$add_topic_sql = "INSERT INTO forum_topics(topic_title, topic_create_time, topic_owner, category_id)
	 VALUES('$clean_topic_title', NOW(), '$clean_topic_owner', $cat_id)";

	$add_topic_res = mysqli_query($mysqli, $add_topic_sql) or die(mysqli_error($mysqli));

	// get the id of the last query
	$topic_id = mysqli_insert_id($mysqli);

	// get the category name
	//$category_name = mysqli_query($mysqli, "SELECT category_name FROM forum_categories WHERE category_id = $cat_id");

	// create and issue the second query
	$add_post_sql = "INSERT INTO forum_posts(topic_id, post_text, post_create_time, post_owner, category_id)
		VALUES('$topic_id', '$clean_post_text', now(), '$clean_topic_owner', $cat_id)";

	$add_post_res = mysqli_query($mysqli, $add_post_sql) or die(mysqli_error($mysqli));

	// close connection to mysql
	mysqli_close($mysqli);

	//$display_block = "<p>The <strong>" . $_POST['topic_title'] . "</strong> in the" . $cat_id . "category has been created.</p>";
	header("Location: show_topic.php?topic_id=" . $topic_id);
	exit;
?>
<!--<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>New Topic Added</title>
	<style><?php include "css/main.css"; ?></style>
</head>
<body>
	<div id="wrapper">
		<?php include "nav.php"; ?>
		<div id="inner-wrapper">
			<?php include "forum_nav.php"; ?>
			<h1>New Topic Added</h1>
			<?php echo $display_block; ?>
		</div>
	</div>
</body>
</html>-->
