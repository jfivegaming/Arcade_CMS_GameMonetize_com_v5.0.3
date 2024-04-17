<?php
if (!defined('R_PILOT')) {
    exit();
}

$page = $_POST['page'];

if (isset($page) && is_numeric($page)) {
    $offsetPage = $page * 7;
    $allBlogs = '';
    $sql_query = $GameMonetizeConnect->query("SELECT * FROM " . BLOGS . " ORDER BY id DESC LIMIT 7 OFFSET {$offsetPage}");
    if ($sql_query) {
        while ($blog = $sql_query->fetch_assoc()) {
    		$post = strip_tags(htmlspecialchars_decode($blog['post']));
            $blog_url = siteUrl() . "/blog/" . $blog['url'];
            $blog_image = siteUrl() . $blog['image_url'];
            $blog_title = ucwords($blog['title']);
            $blog_created_date = date("d M Y", strtotime($blog['date_created']));;
            $blog_post = strlen($post) > 210 ? substr($post, 0, 210) . "..." : $post;

            $allBlogs .= <<<EOF
            <a href="{$blog_url}" class="blog-list-content">
                    <div class="blog-list-image" style="background-image: url({$blog_image})"></div>
                    <div class="blog-list-description">
                        <div class="blog-list-title">{$blog_title}</div>
                        <div class="blog-list-date">Posted on {$blog_created_date}</div>
                        <div class="blog-list-post">{$blog_post}.</div>
                    <div class="blog-list-more">READ MORE &gt;&gt;</div>
                </div>
            </a>
EOF;
        }

        $data['status'] = 200;
        $data['blogs'] = $allBlogs;
        $data['page'] = $page + 1;
    }
} else {
    $data['error_message'] = 'Invalid.';
}

header("Content-type: application/json");
echo json_encode($data);
$GameMonetizeConnect->close();
exit();
