<?php
if (!empty($_GET['blog'])) {
	$blog_url = secureEncode($_GET['blog']);
	$themeData['new_game_page'] = "games";
	$sqlQuery = $GameMonetizeConnect->query("SELECT * FROM " . BLOGS . " WHERE url='" . $blog_url . "'");
	if ($sqlQuery->num_rows > 0) {
		$blog = $sqlQuery->fetch_array();
		$post = htmlspecialchars_decode($blog['post']);
		$themeData['blog_id'] = $blog['id'];
		$themeData['blog_title'] = $blog['title'];
		$themeData['blog_url'] = siteUrl() . "/blog/" . $blog['url'];
		$themeData['blog_post'] = $post;
		$themeData['blog_date_created'] = date("d M Y", strtotime($blog['date_created']));
		$themeData['blog_image_url'] = siteUrl() . $blog['image_url'];

		$themeData['blog_content'] = \GameMonetize\UI::view('blog/blog-post');
	} else {
		$themeData['blog_content'] = \GameMonetize\UI::view('blog/blog-notfound');
	}
} else {
	$sql_blog_query = $GameMonetizeConnect->query("SELECT * FROM " . BLOGS. " ORDER BY id DESC LIMIT 7");
	$ct_r = '';
	while ($blog = $sql_blog_query->fetch_array()) {
		$post = strip_tags(htmlspecialchars_decode($blog['post']));
		$themeData['blog_id'] = $blog['id'];
		$themeData['blog_title'] = $blog['title'];
		$themeData['blog_url'] = siteUrl() . "/blog/" . $blog['url'];
		$themeData['blog_post'] = strlen($post) > 210 ? substr($post, 0, 210) . "..." : $post;
		$themeData['blog_date_created'] = date("d M Y", strtotime($blog['date_created']));
		$themeData['blog_image_url'] = siteUrl() . $blog['image_url'];

		$ct_r .= \GameMonetize\UI::view('blog/blog-list');
	}

	$footer_description = getFooterDescription('blogs');

	$themeData['footer_description'] = isset($footer_description->description) ? htmlspecialchars_decode($footer_description->description): "";

	$themeData['blogs_list'] = $ct_r;
	$themeData['blog_content'] = \GameMonetize\UI::view('blog/blogs');
}
$themeData['page_content'] = \GameMonetize\UI::view('blog/content');
