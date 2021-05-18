<?php
	require 'includes/db.php';

	$get_topics_sql = "SELECT topic_id, topic_title,
		DATE_FORMAT(topic_create_time, '%b %e %Y at %r') AS
		fmt_topic_create_time, topic_owner, category_id FROM forum_topics
		ORDER BY topic_create_time DESC";

	$get_topics_res = $mysqli->query($get_topics_sql) or die($mysqli->error);

	// check if result set from get_topics_res returns < 1 row (so nothing)
	if ($get_topics_res->num_rows < 1) {
		$all_posts_display_block = "<p><em>No topics exist.</em></p>";
	} else {
		$all_posts_display_block = <<<END_OF_TEXT
			<table>
			<tr>
			<th scope="col">Topic Title</th>
			<th scope="col">Topic Category</th>
			<th scope="col"># of Posts</th>
			</tr>
		END_OF_TEXT;

		while ($topic_info = $get_topics_res->fetch_assoc()) {
			$topic_id = $topic_info['topic_id'];
			$topic_title = stripslashes($topic_info['topic_title']);
			$topic_create_time = $topic_info['fmt_topic_create_time'];
			$topic_owner = stripslashes($topic_info['topic_owner']);
			$topic_cat = $topic_info['category_id'];

			$get_num_posts_sql = "SELECT COUNT(post_id) AS post_count FROM
				forum_posts WHERE topic_id = '$topic_id'";

			$get_num_posts_res = $mysqli->query($get_num_posts_sql) or die($mysqli->error);

			while ($posts_info = $get_num_posts_res->fetch_assoc()) {
				$num_posts = $posts_info['post_count'];
			}

			$get_topic_cat_sql = "SELECT category_name 
				FROM forum_categories
				WHERE category_id = $topic_cat";

			$get_topic_cat_res = $mysqli->query($get_topic_cat_sql) or die($mysqli->error);

			while ($topic_cat_name = $get_topic_cat_res->fetch_assoc()) {
				$cur_cat = $topic_cat_name['category_name'];
			}

			// add to display
			$all_posts_display_block .= <<<END_OF_TEXT
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
		$get_topic_cat_res->free_result();
		$get_topics_res->free_result();
		$get_num_posts_res->free_result();

		// close table
		$all_posts_display_block .= "</table>";
	}

	$get_categories_sql = "SELECT * FROM forum_categories";
	$get_categories_res = $mysqli->query($get_categories_sql) or die($mysqli->error);
	$display_cat_sel = '';

	while ($cat_info = $get_categories_res->fetch_assoc()) {
		$cur_cat_name = $cat_info['category_name'];
		$cur_cat_id = $cat_info['category_id'];
		
		$display_cat_sel .= <<<END_OF_TEXT
			<option value="$cur_cat_id">$cur_cat_name</option>
		END_OF_TEXT;
	}

	if (isset($_POST['submit'])) {
		// we clear all_posts_display_block as we only want to render HTML from cat_display_block 
		$all_posts_display_block = '';
		$current_cat = $_POST['show_category'];

		$get_sel_sql = "SELECT * FROM forum_topics WHERE category_id = $current_cat";
		$get_sel_res = $mysqli->query($get_sel_sql) or die($mysqli->error);

		$cat_display_block = <<<END_OF_TEXT
			<table>
			<tr>
			<th scope="col">Topic Title</th>
			<th scope="col"># of Posts</th>
			</tr>
		END_OF_TEXT;

		while ($chosen_cat = $get_sel_res->fetch_assoc()) {
			$cat_topic_id = $chosen_cat['topic_id'];
			$cat_topic_title = $chosen_cat['topic_title'];
			$cat_topic_create_time = $chosen_cat['topic_create_time'];
			$cat_topic_owner = $chosen_cat['topic_owner'];

			$get_num_posts_sql = "SELECT COUNT(post_id) AS post_count FROM
				forum_posts WHERE topic_id = '$cat_topic_id'";

			$get_num_posts_res = $mysqli->query($get_num_posts_sql) or die($mysqli->error);

			while ($posts_info = $get_num_posts_res->fetch_assoc()) {
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
	}

	$mysqli->close();
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
			<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' onsubmit="return checkDefault()" method="POST">
				<label for="show_category">Pick a category:</label>
				<select id="show_category" name="show_category">
					<option value="default">Select...</option>
					<?php echo $display_cat_sel; ?>
				</select>
				<input type="submit" name="submit" value="Filter">
			</form><br/>
			<?php if (isset($_POST['submit'])) echo $cat_display_block; ?>
			<?php echo $all_posts_display_block; ?>
		</div>
		<?php include "includes/footer.php"; ?>
	</div>
	<!-- no need to rerender page if select value is default, instead we prevent form submission-->
	<script>function checkDefault() { if (document.getElementById('show_category').value === 'default') return false }</script>
</body>
</html>
