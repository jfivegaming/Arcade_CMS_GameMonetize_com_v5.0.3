<?php
if (!defined('R_PILOT')) {
    exit();
}

if (is_logged() && isset($_POST['cid'])) {
    $blog_id = secureEncode($_POST['cid']);
    $sql_category_dlt = $GameMonetizeConnect->query("SELECT id FROM " . BLOGS . " WHERE id='{$blog_id}'");

    if ($sql_category_dlt->num_rows > 0) {
        $GameMonetizeConnect->query("DELETE FROM " . BLOGS . " WHERE id='{$blog_id}'");
    }
}
