<?php
	require 'includes/db.php';

	if ((!$_POST['topic_owner']) || (!$_POST['topic_title']) || (!$_POST['post_text'])) {
		header("Location: add_topic.php");
		exit();
	}

	// escape special characters in string, sql injection mitigation
	$clean_topic_owner = mysqli_real_escape_string($mysqli, $_POST['topic_owner']);
	$clean_topic_title = mysqli_real_escape_string($mysqli, $_POST['topic_title']);
	$clean_post_text = mysqli_real_escape_string($mysqli, $_POST['post_text']);

	$cat_id = $_POST['select_category'];

	$add_topic_sql = "INSERT INTO forum_topics(topic_title, topic_create_time, topic_owner, category_id)
	 VALUES('$clean_topic_title', NOW(), '$clean_topic_owner', $cat_id)";

	$add_topic_res = mysqli_query($mysqli, $add_topic_sql) or die(mysqli_error($mysqli));

	// get the id of the last query
	$topic_id = mysqli_insert_id($mysqli);

	$add_post_sql = "INSERT INTO forum_posts(topic_id, post_text, post_create_time, post_owner, category_id)
		VALUES('$topic_id', '$clean_post_text', now(), '$clean_topic_owner', $cat_id)";

	$add_post_res = mysqli_query($mysqli, $add_post_sql) or die(mysqli_error($mysqli));

	mysqli_close($mysqli);

	header("Location: show_topic.php?topic_id=" . $topic_id);
	exit;
?>
