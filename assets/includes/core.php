<?php
/**
* @package GameMonetize CMS 
*/

set_time_limit(0);
session_start();
date_default_timezone_set( 'UTC' ); // GameMonetize.com calculates offsets from UTC
define('CORE_PILOT', true);

if ( !defined( 'ABSPATH' ) ) 
    define('ABSPATH', dirname(dirname(dirname(__FILE__))) . '/');

$time = ceil( time() );
$date = date("j/m/y g:iA", $time);
$access = true;

if ( td_installing() ) {
    require_once( ABSPATH . 'assets/includes/config.php');
    require_once ABSPATH . 'assets/includes/tables.php';

    /**
    * Connecting to MySql server
    */
    $GameMonetizeConnect = @new mysqli($dbGM['host'], $dbGM['user'], $dbGM['pass'], $dbGM['name']);

    /**
    * Set up connection charset
    */
    //$GameMonetizeConnect->set_charset("utf8");

    /**
    * Check connection status
    */
    if ($GameMonetizeConnect->connect_errno) 
        exit($GameMonetizeConnect->connect_errno);

    require_once ABSPATH . 'assets/classes/load.php';
    require_once ABSPATH . 'gm-content/addons/load.php';
    require_once ABSPATH . 'assets/includes/engine.php';
}


/* 
* General functions 
*/
function is_logged() 
{

    if (isset($_COOKIE["gm_ac_u"]) && isset($_COOKIE["gm_ac_p"])) 
    {
        $userId = (int) secureEncode($_COOKIE["gm_ac_u"]);
        $userPass = secureEncode($_COOKIE["gm_ac_p"]);

        global $GameMonetizeConnect;
        $query = $GameMonetizeConnect->query("SELECT id FROM ".ACCOUNTS." WHERE id=$userId AND password='$userPass' AND active=1");
        $fetch = $query->num_rows;
        
        return $fetch;
    }
}

function is_admin() 
{
    global $userData;
    return (is_logged() && $userData['admin']) ? true : false;
}

function is_page( $page ) {
    static $this_page = '';
    switch ($page) {
        case 'play':
            $this_page = 'play' === $_GET['p'] && !empty($_GET['id']) && getGame2($_GET['id']);
        break;

        case 'admin':
            $this_page = 'admin' === $_GET['p'];
        break;
        
        case 'home':
        default:
            $this_page = 'home' === $_GET['p'];
        break;
    }
    return (bool) ($this_page) ? true : false;
}


function title_tag() 
{
    return '<title>' . td_title() . '</title>';
}


function td_title($name_display=true, $sep1='&middot;', $sep2='&raquo;') 
{
    global $config, $lang;
    if (!isset($_GET['p'])) {
        $_GET['p'] = 'home';
    }

    switch ($_GET['p']) {
        case 'home':
            $cat=$_GET["cat"];;
            if($cat<>""){
                $cat = str_replace('-', '.', $cat); 
                $cat = ucfirst($cat);
                return $cat . " Games - Play Games Online Free at GameFree.Games";
            }
        break;
        case 'index':
            $set = $lang['page_home'];
        break;
        case 'categories':
            return "Categories - " . $config['site_name'];
        break;
        case 'new-games':
            return "New Games - " . $config['site_name'];
        break; 
        case 'best-games':
            return "Best Games - " . $config['site_name'];
        break;
        case 'about':
            return "About us - " . $config['site_name'];
        break;
        case 'featured-games':
           return "Featured Games - " . $config['site_name'];
        break;
        case 'played-games':
            return "Played - " . $config['site_name'];
        break;
        case 'terms':
            return "Terms - " . $config['site_name'];
        break;
        case 'privacy':
            return "Privacy Policy - " . $config['site_name'];
        break;  
        case 'tags':
            return "Tags - " . $config['site_name'];
        break;
        case 'search':
            return "Search - " . $config['site_name'];
        break;
        case 'setting':
            if (isset($_GET['section']) && !empty($_GET['section'])) {
                $page_section = $_GET['section'];
                if ($page_section == 'info') {
                    $set = $lang['page_setting'].' '.$sep2.' '.$lang['page_section_info'];
                } elseif ($page_section == 'avatar') {
                    $set = $lang['page_setting'].' '.$sep2.' '.$lang['page_section_avatar'];
                } elseif ($page_section == 'theme') {
                    $set = $lang['page_setting'].' '.$sep2.' '.$lang['page_section_theme'];
                } elseif ($page_section == 'password') {
                    $set = $lang['page_setting'].' '.$sep2.' '.$lang['page_section_password'];
                } else {
                    $set = $lang['page_section_not_found'];
                }
            } else {
                $set = $lang['page_section_not_found'];
            }
            
        break;
        case 'profile':
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                if (getData($_GET['id'], 'id') == true) {
                    $username_titled = getData($_GET['id'], 'name');
                    $set = $username_titled['name'];
                } else {
                    $set = $lang['page_user_not_found'];
                }
            } else {
                $set = $lang['page_user_not_found'];
            }
        break;
        case 'search':
            if (isset($_GET['q']) && !empty($_GET['q'])) {
                $set = $lang['page_search'].' '.$sep2.' '.$_GET['q'];
            } else {
                $set = $lang['page_search'];
            }
        break;
        case 'play':
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                if (getGame2($_GET['id'], 'id') == true) {
                    $gamename_titled = getGame2($_GET['id'], 'name');
                    $set = $gamename_titled['name'];
                } else {
                    $set = $lang['page_game_not_found'];
                }
            } else {
                $set = $lang['page_game_not_found'];
            }
        break;
        case 'admin':
            if (isset($_GET['section']) && !empty($_GET['section'])) {
                $page_section = $_GET['section'];
                if ($page_section == 'global') {
                    $set = $lang['page_admin'].' '.$sep2.' '.$lang['page_admin_section_global'];
                } elseif ($page_section == 'addgame') {
                    $set = $lang['page_admin'].' '.$sep2.' '.$lang['page_admin_section_addgame'];
                } elseif ($page_section == 'setting') {
                    $set = $lang['page_admin'].' '.$sep2.' '.$lang['page_admin_section_setting'];
                } elseif ($page_section == 'games') {
                    if (isset($_GET['action']) && !empty($_GET['action'])) {
                        $section_page = $_GET['action'];
                        if ($section_page == 'edit') {
                            $set = $lang['page_admin'].' '.$sep2.' '.$lang['page_admin_section_games'].' &rsaquo; '.$lang['admin_game_edit'];
                        } else {
                            $set = $lang['page_admin'].' '.$sep2.' '.$lang['page_admin_section_games'].' &rsaquo; '.$lang['page_section_not_found'];
                        }
                    } else {
                        $set = $lang['page_admin'].' '.$sep2.' '.$lang['page_admin_section_games'];
                    }
                } elseif ($page_section == 'categories') {
                    if (isset($_GET['action']) && !empty($_GET['action'])) {
                        $section_page = $_GET['action'];
                        if ($section_page == 'add') {
                            $set = $lang['page_admin'].' '.$sep2.' '.$lang['page_admin_section_categories'].' &rsaquo; '.$lang['admin_category_add'];
                        } elseif ($section_page == 'edit') {
                            $set = $lang['page_admin'].' '.$sep2.' '.$lang['page_admin_section_categories'].' &rsaquo; '.$lang['admin_category_edit'];
                        } else {
                            $set = $lang['page_admin'].' '.$sep2.' '.$lang['page_admin_section_categories'].' &rsaquo; '.$lang['page_section_not_found'];
                        }
                    } else {
                        $set = $lang['page_admin'].' '.$sep2.' '.$lang['page_admin_section_categories'];
                    }
                } elseif ($page_section == 'users') {
                    if (isset($_GET['action']) && !empty($_GET['action'])) {
                        $section_page = $_GET['action'];
                        if ($section_page == 'edit') {
                            $set = $lang['page_admin'].' '.$sep2.' '.$lang['page_admin_section_users'].' &rsaquo; '.$lang['admin_user_edit'];
                        } else {
                            $set = $lang['page_admin'].' '.$sep2.' '.$lang['page_admin_section_users'].' &rsaquo; '.$lang['page_section_not_found'];
                        }
                    } else {
                        $set = $lang['page_admin'].' '.$sep2.' '.$lang['page_admin_section_users'];
                    }
                } elseif ($page_section == 'ads') {
                    $set = $lang['page_admin'].' '.$sep2.' '.$lang['page_admin_section_ads'];
                } else {
                    $set = $lang['page_section_not_found'];
                }
            } else {
                $set = $lang['page_section_not_found'];
            }        
        break;
        case 'login':
            $set = $lang['page_login'];
        break;
        case 'signup':
            $set = $lang['page_signup'];
        break;
        case 'contact':
            return "Contact - " . $config['site_name'];
        break;
        case 'error':
        default:
            $set = $lang['page_error'];
        break;
    }

    if ($name_display) {
        return $config['site_name'];
    } else {
        return $set;
    }
}

function slugify($text) {
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

function urlState($url, $type=false) 
{
    if ($type == true) {
        return urlencode($url);
    }
    elseif($type == false) {
        return urldecode($url);
    }
}


function siteUrl() 
{
    global $config;
    return $config['site_url'];
}


function shortStr($str, $len, $pnt=true) 
{
    if (strlen($str) > $len) {
        if ($pnt == true) {
            $str = mb_substr($str, 0, $len, 'UTF-8')."…";
        } else {
            $str = mb_substr($str, 0, $len, 'UTF-8');
        }
    }
    return $str;
}

function secureEncode($string) 
{
    global $GameMonetizeConnect;
    $string = trim($string);
    if (!$GameMonetizeConnect->connect_errno) {
    $string = mysqli_real_escape_string($GameMonetizeConnect, $string);
    }
    $string = htmlspecialchars($string, ENT_QUOTES);
    $string = str_replace('\\r\\n', '<br>',$string);
    $string = str_replace('\\r', '<br>',$string);
    $string = str_replace('\\n\\n', '<br>',$string);
    $string = str_replace('\\n', '<br>',$string);
    $string = str_replace('\\n', '<br>',$string);
    $string = stripslashes($string);
    $string = str_replace('&amp;#', '&#',$string);
    
    return $string;
}


function decodeHTML($string) 
{
    return $string = htmlspecialchars_decode($string);
}


function addslashes__recursive($var)
{
    if (!is_array($var))
    return addslashes($var);
    $new_var = array();
    foreach ($var as $k => $v)$new_var[addslashes($k)]=addslashes__recursive($v);
    return $new_var;
}

$_POST=addslashes__recursive($_POST);
$_GET=addslashes__recursive($_GET);
$_REQUEST=addslashes__recursive($_REQUEST);
$_SERVER=addslashes__recursive($_SERVER);
$_COOKIE=addslashes__recursive($_COOKIE);

function get_game_container_src($get_game_id, $get_game_width, $get_game_height) 
{
    $get_game_data = getGame($get_game_id);
    $urlgame = $get_game_data['file'];

    $game_get_source = '<iframe src="'.$urlgame.'" id="game-player" width="100%" height="100%" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

    return $game_get_source;
}


function gameFileUrl($file_url, $import) 
{
    if ($import == 1) {
        $game_url = siteUrl() . '/data-games/' . $file_url;
    }
    else {
        $game_url = $file_url;
    }
    return $game_url;
}


function gameImageUrl($image_url, $import) 
{
    global $config;

    if ($import == 1) {
        $url = siteUrl().'/'.$image_url;
    }
    else {
        if ($image_url == '') {
            $url = $config['theme_path'] . '/image/data-game/default_game-thumb.png';
        }
        else {
            $url = $image_url;
        }
    }
    return $url;
}


function gameData($row_data) 
{
    global $userData;

    $game = array('game_id' => $row_data['game_id'], 'game_name' => $row_data['game_name'], 'instructions' => nl2br($row_data['instructions']), 'plays' => number_format($row_data['plays'], 0, '', '.'), 'category' => $row_data['category']);
    
    $game['name'] = $row_data['name'];
    $game['video_url'] = $row_data['video_url'];
    $game['description'] = $row_data['description'];
    $game['game_url'] = siteUrl().'/game/' . slugify($game['name']);
    $game['file_url'] = gameFileUrl($row_data['file'], $row_data['import']);
    $game['file'] = $row_data['file'];
    $game['embed'] = get_game_container_src($game['game_id'], $row_data['w'], $row_data['h']);
    $game['image_url'] = gameImageUrl($row_data['image'], $row_data['import']);
    $game['featured'] = "";
    if( $row_data['featured']  == "1") {
        $game['featured'] = "<span class='featured_icon'></span>";
    }

    if (is_logged() && $userData['admin'] == 1) {
        $game['admin_edit'] = '<button data-href="'.siteUrl().'/admin/games/edit/'.$row_data['game_id'].'" class="stt-adm-button top-gm-btn fa fa-pencil"></button>';
    }
    else {
        $game['admin_edit'] = '';
    }

    $game['date_added'] = date('d/m/y', $row_data['date_added']);

    return $game;
}


function getGame($gid=0) 
{
    global $GameMonetizeConnect;
    
    $gid = secureEncode($gid);
    $sql_query_game = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE game_id='{$gid}'");
    if ($sql_query_game->num_rows == 1) {
        if ($game = $sql_query_game->fetch_array()) {
            return $game;
        }
    }
}

function getGame2($id) 
{
    global $GameMonetizeConnect;

    $sql_query_game = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE game_name='{$id}'");
    if ($sql_query_game->num_rows == 1) {
        if ($game = $sql_query_game->fetch_array()) {
            return $game;
        }
    }
}

function getTagsByTitle($title) 
{
    global $GameMonetizeConnect;

    // if(is_numeric(strpos($title, "-"))){
    //     $title = str_replace("-", " ",$title);
    // }
    $sql_query = $GameMonetizeConnect->query("SELECT * FROM ".TAGS." WHERE url='{$title}'");
    if ($sql_query->num_rows == 1) {
        return $sql_query->fetch_assoc();
    }
}

function getBlogByUrl($url) 
{
    global $GameMonetizeConnect;

    $sql_query = $GameMonetizeConnect->query("SELECT * FROM ".BLOGS." WHERE url='{$url}'");
    if ($sql_query->num_rows == 1) {
        return $sql_query->fetch_assoc();
    }
}

function getCategoriesByUrl($title) 
{
    global $GameMonetizeConnect;

    $sql_query = $GameMonetizeConnect->query("SELECT * FROM ".CATEGORIES." WHERE category_pilot='{$title}'");
    if ($sql_query->num_rows == 1) {
        return $sql_query->fetch_assoc();
    }
}

function getCategoriesLikeName($title) 
{
    global $GameMonetizeConnect;

    $sql_query = $GameMonetizeConnect->query("SELECT * FROM ".CATEGORIES." WHERE name LIKE '%{$title}%' ORDER BY id DESC");
    if ($sql_query->num_rows == 1) {
        return $sql_query->fetch_assoc();
    }
    return null;
}

function getTagsLikeName($title) 
{
    $url = slugify_url($title);
    global $GameMonetizeConnect;

    $sql_query = $GameMonetizeConnect->query("SELECT * FROM ".TAGS." WHERE name LIKE '%{$title}%' OR url LIKE '%{$url}%' ORDER BY id DESC LIMIT 1");

    if ($sql_query->num_rows > 0) {
        return $sql_query->fetch_assoc();
    }else{
        // Create tags if not exist
        $sql_query = $GameMonetizeConnect->query("INSERT INTO ".TAGS." (url, name, footer_description) VALUES ('{$url}', '$title', '')", MYSQLI_USE_RESULT);

        if($sql_query){
            return array("id"=>$GameMonetizeConnect->insert_id);
        }
    }
    return null;
}

function slugify_url($string)
{
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), '-', $string);
    return strtolower(trim($string, '-'));
}


function getAvatar($avatar_id=0, $gender=1, $avatar_size='large') 
{
    $userGet_media = getMedia($avatar_id);

    if ($avatar_id != 0) {
        $avatar_picture = $userGet_media[''.$avatar_size.''];
    } else {
        if ($gender == 2) {
            $avatar_picture = siteUrl()."/static/avatar-female.png";
        } else {
            $avatar_picture = siteUrl()."/static/avatar-male.png";
        }
    }

    return $avatar_picture;
}


function getInfo($user_id=0) 
{
    global $GameMonetizeConnect;

    if (empty($user_id) or !is_numeric($user_id) or $user_id < 1) {
        return false;
    }

    $user_id = secureEncode($user_id);

    $user_info = "SELECT gender,about FROM ".USERS." WHERE user_id = '{$user_id}'";
    $user_info_query = $GameMonetizeConnect->query($user_info);

    if ($user_info_query->num_rows == 1) {
        if ($user = $user_info_query->fetch_array()) {
            return $user;
        }
    }
}

function getData($user_id=0, $query_select='*') 
{
    global $GameMonetizeConnect;

    if (is_numeric($user_id)) {
        $user_id_type = "id = " . $user_id;
    } elseif (preg_match('/[A-Za-z0-9_]/', $user_id)) {
        $user_id_type = "username = '{$user_id}'";
    } else {
        return false;
    }

    $user_id = secureEncode($user_id);
    $user_data = "SELECT $query_select FROM ".ACCOUNTS." WHERE " . $user_id_type;
    $user_data_query = $GameMonetizeConnect->query($user_data);

    if ($user_data_query->num_rows == 1) {
        if ($user = $user_data_query->fetch_array()) {
            return $user;
        }
    }
}

function getMedia($file_id=0) 
{
    global $GameMonetizeConnect;
    
    if (empty($file_id) or !is_numeric($file_id) or $file_id < 1) {
        return false;
    }
    
    $file_id = secureEncode($file_id);
    $query_one = "SELECT * FROM ".MEDIA." WHERE id=$file_id";
    $sql_query_one = $GameMonetizeConnect->query($query_one);
    
    if ($sql_query_one->num_rows == 1) {
        $sql_fetch_one = mysqli_fetch_assoc($sql_query_one);
        $sql_fetch_one['complete'] = siteUrl().'/'.$sql_fetch_one['url'] . '.' . $sql_fetch_one['extension'];
        $sql_fetch_one['large'] = siteUrl().'/'.$sql_fetch_one['url'] . '_100x75.' . $sql_fetch_one['extension'];
        $sql_fetch_one['medium'] = siteUrl().'/'.$sql_fetch_one['url'] . '_100x100.' . $sql_fetch_one['extension'];
        $sql_fetch_one['thumb'] = siteUrl().'/'.$sql_fetch_one['url'] . '_thumb.' . $sql_fetch_one['extension'];

        return $sql_fetch_one;
    }
}


function uploadMedia($upload) 
{
    if ($GLOBALS['access'] !== true) {
        return false;
    }
    
    global $GameMonetizeConnect;
    set_time_limit(0);
    
    if (!file_exists('data-photo/' . date('Y'))) {
        mkdir('data-photo/' . date('Y'), 0777, true);
    }
    
    if (!file_exists('data-photo/' . date('Y') . '/' . date('m'))) {
        mkdir('data-photo/' . date('Y') . '/' . date('m'), 0777, true);
    }
    
    $photo_dir = 'data-photo/' . date('Y') . '/' . date('m');
    
    if (is_uploaded_file($upload['tmp_name'])) {
        $upload['name'] = secureEncode($upload['name']);
        $name = preg_replace('/([^A-Za-z0-9_\-\.]+)/i', '', $upload['name']);
        $ext = strtolower(substr($upload['name'], strrpos($upload['name'], '.') + 1, strlen($upload['name']) - strrpos($upload['name'], '.')));
        
        if ($upload['size'] > 1024) {
            
            if (preg_match('/(jpg|jpeg|png)/', $ext)) {
                
                list($width, $height) = getimagesize($upload['tmp_name']);
                
                $query_one = "INSERT INTO " . MEDIA . " (extension, name, type) VALUES ('$ext','$name','photo')";
                $sql_query_one = $GameMonetizeConnect->query($query_one);
                
                if ($sql_query_one) {
                    $sql_id = mysqli_insert_id($GameMonetizeConnect);
                    $original_file_name = $photo_dir . '/' . generateKey() . '_' . $sql_id . '_' . md5($sql_id);
                    $original_file = $original_file_name . '.' . $ext;
                    
                    if (move_uploaded_file($upload['tmp_name'], $original_file)) {
                        $min_size = $width;
                        
                        if ($width > $height) {
                            $min_size = $height;
                        }
                        
                        $min_size = floor($min_size);
                        
                        if ($min_size > 920) {
                            $min_size = 920;
                        }
                        
                        $imageSizes = array(
                            'thumb' => array(
                                'type' => 'crop',
                                'width' => 64,
                                'height' => 64,
                                'name' => $original_file_name . '_thumb'
                            ),
                            '100x100' => array(
                                'type' => 'crop',
                                'width' => $min_size,
                                'height' => $min_size,
                                'name' => $original_file_name . '_100x100'
                            ),
                            '100x75' => array(
                                'type' => 'crop',
                                'width' => $min_size,
                                'height' => floor($min_size * 0.75),
                                'name' => $original_file_name . '_100x75'
                            )
                        );
                        
                        foreach ($imageSizes as $ratio => $data) {
                            $save_file = $data['name'] . '.' . $ext;
                            processMedia($data['type'], $original_file, $save_file, $data['width'], $data['height']);
                        }
                        
                        processMedia('resize', $original_file, $original_file, $min_size, 0);
                        $GameMonetizeConnect->query("UPDATE " . MEDIA . " SET url='$original_file_name' WHERE id=$sql_id");
                        $get = array(
                            'id' => $sql_id,
                            'extension' => $ext,
                            'name' => $name,
                            'url' => $original_file_name
                        );
                        
                        return $get;
                    }
                }
            }
        }
    }
}


function uploadGameMedia($upload, $gamename)  
{
   if ($GLOBALS['access'] !== true) return false;
    
    global $GameMonetizeConnect;
    set_time_limit(0);
    
    if (!file_exists('images/')) {
        mkdir('images/', 0777, true);
    }
    
    $photo_dir = 'images/';
    
    if (is_uploaded_file($upload['tmp_name'])) {
        $upload['name'] = secureEncode($upload['name']);
        $name = preg_replace('/([^A-Za-z0-9_\-\.]+)/i', '', $upload['name']);
        $ext = strtolower(substr($upload['name'], strrpos($upload['name'], '.') + 1, strlen($upload['name']) - strrpos($upload['name'], '.')));
        
        if ($upload['size'] > 1024) {
            
            if (preg_match('/(jpg|jpeg|png)/', $ext)) {
                
                list($width, $height) = getimagesize($upload['tmp_name']);

                    $original_file_name = $photo_dir . $gamename . '.' . $ext;
                    
                    if (move_uploaded_file($upload['tmp_name'], $original_file_name)) {

                        $original_file_name = '/' . $photo_dir . $gamename;

                        $get = array(
                            'extension' => $ext,
                            'name' => $name,
                            'url' => $original_file_name
                        );
                        
                        return $get;
                    }
                }
            }
    }
}

function uploadGameMediaCategory($upload, $categoryname) 
{
    if ($GLOBALS['access'] !== true) return false;
    
    global $GameMonetizeConnect;
    set_time_limit(0);
    
    if (!file_exists('cat/')) {
        mkdir('cat/', 0777, true);
    }
    
    $photo_dir = 'cat/';
    
    if (is_uploaded_file($upload['tmp_name'])) {
        $upload['name'] = secureEncode($upload['name']);
        $name = preg_replace('/([^A-Za-z0-9_\-\.]+)/i', '', $upload['name']);
        $ext = strtolower(substr($upload['name'], strrpos($upload['name'], '.') + 1, strlen($upload['name']) - strrpos($upload['name'], '.')));
        
        if ($upload['size'] > 1024) {
            
            if (preg_match('/(jpg|jpeg|png)/', $ext)) {
                
                list($width, $height) = getimagesize($upload['tmp_name']);

                    $original_file_name = $photo_dir . $categoryname . '.' . $ext;
                    
                    if (move_uploaded_file($upload['tmp_name'], $original_file_name)) {

                        $original_file_name = '/' . $photo_dir . $categoryname;

                        $get = array(
                            'extension' => $ext,
                            'name' => $name,
                            'url' => $original_file_name
                        );
                        
                        return $get;
                    }
                }
            }
    }
}

function uploadBlogImage($upload, $blog_title) 
{
    if ($GLOBALS['access'] !== true) return false;
    
    global $GameMonetizeConnect;
    set_time_limit(0);
    
    if (!file_exists('blog-img/')) {
        mkdir('blog-mg/', 0777, true);
    }
    
    $photo_dir = 'blog-img/';
    
    if (is_uploaded_file($upload['tmp_name'])) {
        $upload['name'] = secureEncode($upload['name']);
        $name = preg_replace('/([^A-Za-z0-9_\-\.]+)/i', '', $upload['name']);
        $ext = strtolower(substr($upload['name'], strrpos($upload['name'], '.') + 1, strlen($upload['name']) - strrpos($upload['name'], '.')));
        
        if ($upload['size'] > 1024) {
            
            if (preg_match('/(jpg|jpeg|png)/', $ext)) {
                
                list($width, $height) = getimagesize($upload['tmp_name']);

                    $original_file_name = $photo_dir . $blog_title . '.' . $ext;
                    
                    if (move_uploaded_file($upload['tmp_name'], $original_file_name)) {

                        $original_file_name = '/' . $photo_dir . $blog_title;

                        $get = array(
                            'extension' => $ext,
                            'name' => $name,
                            'url' => $original_file_name
                        );
                        
                        return $get;
                    }
                }
            }
    }
}


function processMedia($run, $photo_src, $save_src, $width=0, $height=0, $quality=80) 
{
    
    if (!is_numeric($quality) or $quality < 0 or $quality > 100) {
        $quality = 80;
    }

    if (file_exists($photo_src)) {
        
        if (strrpos($photo_src, '.')) {
            $ext = substr($photo_src, strrpos($photo_src,'.') + 1, strlen($photo_src) - strrpos($photo_src, '.'));
            $fxt = (!in_array($ext, array('jpeg', 'png'))) ? "jpeg" : $ext;
        } else {
            $ext = $fxt = 0;
        }
        
        if (preg_match('/(jpg|jpeg|png)/', $ext)) {
            list($photo_width, $photo_height) = getimagesize($photo_src);
            $create_from = "imagecreatefrom" . $fxt;
            $photo_source = $create_from($photo_src);
            
            if ($run == "crop") {
                
                if ($width > 0 && $height > 0) {
                    $crop_width = $photo_width;
                    $crop_height = $photo_height;
                    $k_w = 1;
                    $k_h = 1;
                    $dst_x = 0;
                    $dst_y = 0;
                    $src_x = 0;
                    $src_y = 0;
                    
                    if ($width == 0 or $width > $photo_width) {
                        $width = $photo_width;
                    }
                    
                    if ($height == 0 or $height > $photo_height) {
                        $height = $photo_height;
                    }
                    
                    $crop_width = $width;
                    $crop_height = $height;
                    
                    if ($crop_width > $photo_width) {
                        $dst_x = ($crop_width - $photo_width) / 2;
                    }
                    
                    if ($crop_height > $photo_height) {
                        $dst_y = ($crop_height - $photo_height) / 2;
                    }
                    
                    if ($crop_width < $photo_width || $crop_height < $photo_height) {
                        $k_w = $crop_width / $photo_width;
                        $k_h = $crop_height / $photo_height;
                        
                        if ($crop_height > $photo_height) {
                            $src_x  = ($photo_width - $crop_width) / 2;
                        } elseif ($crop_width > $photo_width) {
                            $src_y  = ($photo_height - $crop_height) / 2;
                        } else {
                            
                            if ($k_h > $k_w) {
                                $src_x = round(($photo_width - ($crop_width / $k_h)) / 2);
                            } else {
                                $src_y = round(($photo_height - ($crop_height / $k_w)) / 2);
                            }
                        }
                    }
                    
                    $crop_image = @imagecreatetruecolor($crop_width, $crop_height);
                    
                    if ($ext == "png") {
                        @imagesavealpha($crop_image, true);
                        @imagefill($crop_image, 0, 0, @imagecolorallocatealpha($crop_image, 0, 0, 0, 127));
                    }
                    
                    @imagecopyresampled($crop_image, $photo_source ,$dst_x, $dst_y, $src_x, $src_y, $crop_width - 2 * $dst_x, $crop_height - 2 * $dst_y, $photo_width - 2 * $src_x, $photo_height - 2 * $src_y);

                    @imageinterlace($crop_image, true);
                    @imagejpeg($crop_image, $save_src, $quality);
                    @imagedestroy($crop_image);
                }
            } elseif ($run == "resize") {
                
                if ($width == 0 && $height == 0) {
                    return false;
                }
                
                if ($width > 0 && $height == 0) {
                    $resize_width = $width;
                    $resize_ratio = $resize_width / $photo_width;
                    $resize_height = floor($photo_height * $resize_ratio);
                } elseif ($width == 0 && $height > 0) {
                    $resize_height = $height;
                    $resize_ratio = $resize_height / $photo_height;
                    $resize_width = floor($photo_width * $resize_ratio);
                } elseif ($width > 0 && $height > 0) {
                    $resize_width = $width;
                    $resize_height = $height;
                }
                
                if ($resize_width > 0 && $resize_height > 0) {
                    $resize_image = @imagecreatetruecolor($resize_width, $resize_height);
                    
                    if ($ext == "png") {
                        @imagesavealpha($resize_image, true);
                        @imagefill($resize_image, 0, 0, @imagecolorallocatealpha($resize_image, 0, 0, 0, 127));
                    }
                    
                    @imagecopyresampled($resize_image, $photo_source, 0, 0, 0, 0, $resize_width, $resize_height, $photo_width, $photo_height);

                    @imageinterlace($resize_image, true);
                    @imagejpeg($resize_image, $save_src, $quality);
                    @imagedestroy($resize_image);
                }
            } elseif ($run == "scale") {
                
                if ($width == 0) {
                    $width = 100;
                }
                
                if ($height == 0) {
                    $height = 100;
                }
                
                $scale_width = $photo_width * ($width / 100);
                $scale_height = $photo_height * ($height / 100);
                $scale_image = @imagecreatetruecolor($scale_width, $scale_height);
                
                if ($ext == "png") {
                    @imagesavealpha($scale_image, true);
                    @imagefill($scale_image, 0, 0, imagecolorallocatealpha($scale_image, 0, 0, 0, 127));
                }
                
                @imagecopyresampled($scale_image, $photo_source, 0, 0, 0, 0, $scale_width, $scale_height, $photo_width, $photo_height);

                @imageinterlace($scale_image, true);
                @imagejpeg($scale_image, $save_src, $quality);
                @imagedestroy($scale_image);
            }
        }
    }
} 


function generateKey($minlength=5, $maxlength=5, $uselower=true, $useupper=true, $usenumbers=true, $usespecial=false) 
{
    $charset = '';
    
    if ($uselower) {
        $charset .= "abcdefghijklmnopqrstuvwxyz";
    }
    
    if ($useupper) {
        $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    }
    
    if ($usenumbers) {
        $charset .= "123456789";
    }
    
    if ($usespecial) {
        $charset .= "~@#$%^*()_+-={}|][";
    }
    
    if ($minlength > $maxlength) {
        $length = mt_rand($maxlength, $minlength);
    } else {
        $length = mt_rand($minlength, $maxlength);
    }
    
    $key = '';
    
    for ($i = 0; $i < $length; $i++) {
        $key .= $charset[(mt_rand(0, strlen($charset) - 1))];
    }
    
    return $key;
}

function dateState($date, $type=1) 
{
    $date_state = '';
    if ($type == 1) {
        $date_state = date("j/m/y", $date);
    }
    elseif ($type == 2) {
         $date_state = date("j/m/Y", $date);
    }
    elseif ($type == 3) {
         $date_state = date("j-m-y", $date);
    }
    elseif ($type == 4) {
         $date_state = date("j-m-Y", $date);
    }
    elseif ($type == 5) {
         $date_state = date("j/m/y g:i A", $date);
    }
    elseif ($type == 6) {
         $date_state = date("j/m/Y g:i A", $date);
    }
    elseif ($type == 7) {
         $date_state = date("j-m-y g:i A", $date);
    }
    elseif ($type == 8) {
         $date_state = date("j-m-Y g:i A", $date);
    }
    return $date_state;
}

function numberFormat($num) 
{
    $suffixes = array('', 'k', 'M', 'G', 'T');
        $suffixIndex = 0;
    
        while(abs($num) >= 1000 && $suffixIndex < sizeof($suffixes))
        {
            $suffixIndex++;
            $num /= 1000;
        }
    
        return (
            $num > 0
                ? floor($num * 1000) / 1000
                : ceil($num * 1000) / 1000
            )
            . $suffixes[$suffixIndex];
}


function listMenu($s1, $s2) 
{
    if ($s1 == $s2) {
        return 'active';
    } else {
        return false;
    }
}


function getADS($type='728x90') 
{
   global $GameMonetizeConnect, $config;

    $sql_query_ads = $GameMonetizeConnect->query("SELECT * FROM ".ADS."");
    
    if ($sql_query_ads->num_rows == true) {
        $ads_select = $sql_query_ads->fetch_array();
        if ($type == '728x90') {
            $ads_select['728x90'] = $ads_select['728x90'];
        } elseif ($type == '300x250') {
            $ads_select['300x250'] = $ads_select['300x250'];
        } elseif ($type == '600x300') {
          $ads_select['600x300'] = $ads_select['600x300'];
        } elseif ($type == '728x90_main') {
            $ads_select['728x90_main'] = $ads_select['728x90_main'];
        } elseif ($type == '300x250_main') {
            if(!empty($ads_select['300x250_main'])) {
                      $ads_select['300x250_main'] = '<div class="post post-trick" style="position: absolute; left: 0px; top: 0px;">
                <span class="ad-desc-left"><img src="' . $config['theme_path'] . '/image/bg_a728.png" alt=""></span>
                <div style="text-align:center;margin:0 auto;width:300px; height:250px;margin-top:9px;">
                '. $ads_select['300x250_main'] .'
                </div>
                <span class="ad-desc-right"><img src="' . $config['theme_path'] . '/image/bg_a728.png" alt=""></span>
            </div>';
            }
        } elseif ($type == 'ads_video') {
            $ads_select['ads_video'] = $ads_select['ads_video'];
        }

        return $ads_select[$type];
    } else {
        return false;
    }
}


function feedID($data, $str=4, $key='x1') 
{
    $pro1 = substr($data, -$str); # Select last $str digits
    $pro2 = $pro1.$key;
    return $pro2;
}


function searchGames($sch_query='') 
{
    global $GameMonetizeConnect;
    $q_result = array();
    
    if (!isset($sch_query) or empty($sch_query)) {
        return $q_result;
    }
    
    $sch_query = secureEncode($sch_query);

    $sql_query = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE name LIKE '%$sch_query%' AND published='1' ORDER BY name ASC");

    if ($sql_query->num_rows > 0) {
        while ($sql_fetch = $sql_query->fetch_array()) {
            $q_result[] = $sql_fetch;
        }
    }
    
    return $q_result;
}


function lastUser($type='logged', $limit=5) 
{
    global $GameMonetizeConnect;
    $q_lb_user = array();

    if ($type == 'logged') {
        $last_users_logged = $GameMonetizeConnect->query("SELECT avatar_id,name,username,id FROM ".ACCOUNTS." ORDER BY last_logged DESC LIMIT ".$limit);
        while ($last_user = $last_users_logged->fetch_array()) {
            $q_lb_user[] = $last_user;
        }
    } elseif ($type == 'registered') {
        $last_users_registered = $GameMonetizeConnect->query("SELECT avatar_id,name,username,id FROM ".ACCOUNTS." ORDER BY registration_date DESC LIMIT ".$limit);
        while ($last_user = $last_users_registered->fetch_array()) {
            $q_lb_user[] = $last_user;
        }
    }

    return $q_lb_user;
}


function getStats($type='games', $num_format=true) 
{
    global $GameMonetizeConnect;

    if ($type == 'games') {
        $stats_query = $GameMonetizeConnect->query("SELECT game_id FROM ".GAMES." WHERE game_id!=0");
    } elseif ($type == 'users') {
        $stats_query = $GameMonetizeConnect->query("SELECT id FROM ".ACCOUNTS." WHERE id!=0");
    } elseif ($type == 'categories') {
        $stats_query = $GameMonetizeConnect->query("SELECT id FROM ".CATEGORIES." WHERE id!=0");
    } elseif ($type == 'catalog_games') {
        $stats_query = $GameMonetizeConnect->query("SELECT id FROM ".CATALOG." WHERE id!=0");
    }

    if ($num_format) {
        return numberFormat($stats_query->num_rows);
    } else {
        return $stats_query->num_rows;
    }
}


function incCheck($array, $entry, $type='check') 
{
    foreach ($array as $c_array) {
        if ($type == 'check') {
            if (stripos(strtolower($entry), strtolower($c_array)) !== false) {
                return true;
            }
        }
        elseif ($type == 'scan') {
            if ($c_array == $entry) {
                return true;
            }
        }
    }
}


/**
* @since 2.0.1
*/

function untrailingslashit($string) 
{
    return rtrim( $string, '/\\' );
}


function trailingslashit($string) 
{
    return untrailingslashit( $string ) . '/';
}


function addon_path($file) 
{
    return trailingslashit( dirname($file) );
}


function td_installing($install_step=0) 
{
    if ($install_step == 1) {
        return ( file_exists( ABSPATH . 'assets/includes/config.php') ) ? true : false;
    } elseif ($install_step == 2) {
        return ( file_exists( ABSPATH . 'assets/includes/install-blank.php') ) ? true : false;
    } else {
        return ( file_exists( ABSPATH . 'assets/includes/config.php') && file_exists( ABSPATH . 'assets/includes/install-blank.php') ) ? true : false;
    }
}


function get_addons($type) 
{
    if (! isset($_SESSION['addons'][$type])) {
        return false;
    }

    $get = $_SESSION['addons'][$type];

    if ( !is_array($get) ) {
        return false;
    }

    return $get;
}


function addon() 
{
    $params = func_get_args();
    $countParams = func_num_args();
    $type = $params[0];
    $args = "";
    unset($params[0]);

    if (is_array ($type)) {
        $return_type = $type[1];

        if (isset ($type[2])) {
            if ($type[2] == "no_append") {
                $noAppend = true;
            }
        }

        $type = $type[0];
    }

    if ( isset($params[1]) ) {
        $args = $params[1];
    }

    if ($countParams > 2) {
        $args = $params[($countParams - 1)];
    }
        
    $get_addons = get_addons($type);

    if ( is_array($get_addons) ) {
        foreach ($get_addons as $name) {
            $adds = call_user_func_array($name, $params);

            if ( !empty($adds) ) {
                if ( $return_type == "string" ) {
                    if ( is_array($args) ) {
                        $args = "";
                    }

                    if (isset ($noAppend)) {
                        $args = "";
                    }
                        
                    $args .= $adds;
                }
                elseif ( $return_type == "array" ) {
                    $args = array_merge($args, $adds);
                }
                else {
                    return false;
                }
            }
        }
    }

    return $args;
}


function register_addon($type, $func) 
{
    $name = $func;
    $func_invalid = (preg_match('/[A-Za-z0-9_]/i', $name)) ? false : true;

    if ( isset($_SESSION['addons'][$type][$name]) ) {
        return false;
    }
        
    if ( !preg_match('/[A-Za-z0-9_]/i', $type) or $func_invalid) {
        return false;
    }

    $type = strtolower($type);
    $_SESSION['addons'][$type][$name] = $func;
}


function call_addon() 
{
    $args = func_get_args();
    $type = $args[0];
    $func = $args[1];
    unset($args[0], $args[1]);

    return call_user_func_array($func, $args);
}

function getFeaturedGames() 
{
    global $GameMonetizeConnect;
   
    $query_gm_topStar = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE featured='1' ORDER BY rand() LIMIT 5");
        if ($query_gm_topStar->num_rows != 0) {
            $game_get_source = "";
            while ($topStar = $query_gm_topStar->fetch_array()) {
                $game_top = gameData($topStar);
                $game_get_source .= '<li class="adsmall" style="display:none"><a href="'.$game_top['game_url'].'">
               <div class="gameicon" style="background-image: url('.$game_top['image_url'].'); background-size: cover;border-radius: 3px;background-position-x: 50%;background-position-y: 30%;height: 100%;width:100%;background-repeat: no-repeat;"></div>
                </a></li>';
            }
        }
        return $game_get_source;
}

function getSidebarWidget($type='top-star', $gameName = '',  $exclusions = []) 
{
    global $GameMonetizeConnect, $themeData, $lang, $config;
    if ($type == 'top-star') {
        $query_gm_topStar = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE featured='1' ORDER BY rand() LIMIT 6");
        $top_star_list = '';
        if ($query_gm_topStar->num_rows != 0) {
            while ($topStar = $query_gm_topStar->fetch_array()) {
                $game_top = gameData($topStar);
                $themeData['widget_topstar_url'] = $game_top['game_url'];
                $themeData['widget_topstar_image'] = $game_top['image_url'];
                $themeData['widget_topstar_name'] = $game_top['name'];
                $themeData['widget_topstar_rating'] = $topStar['rating'];
                $themeData['widget_topstar_video_url'] = $topStar['video_url'];
                $top_star_list .= \GameMonetize\UI::view('game/sections/widget-each/top-stars-list');
            }
        } else {
            $top_star_list .= \GameMonetize\UI::view('game/sections/widget-each/top-stars-notfound');
        }
        $themeData['widget_sidebar_top_star_list'] = $top_star_list;
        return \GameMonetize\UI::view('game/sections/widget.top-stars');
    }

     elseif ($type == 'top-star2') {
        $query_gm_topStar = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE featured='1' ORDER BY rand() LIMIT 6");
        $top_star_list = '';
        if ($query_gm_topStar->num_rows != 0) {
            while ($topStar = $query_gm_topStar->fetch_array()) {
                $game_top = gameData($topStar);
                $themeData['widget_topstar_url'] = $game_top['game_url'];
                $themeData['widget_topstar_image'] = $game_top['image_url'];
                $themeData['widget_topstar_name'] = $game_top['name'];
                $themeData['widget_topstar_rating'] = $topStar['rating'];
                $themeData['widget_topstar_video_url'] = $topStar['video_url'];
                $top_star_list .= \GameMonetize\UI::view('game/sections/widget-each/top-stars-list');
            }
        } else {
            $top_star_list .= \GameMonetize\UI::view('game/sections/widget-each/top-stars-notfound');
        }
        $themeData['widget_sidebar_top_star_list'] = $top_star_list;
        return \GameMonetize\UI::view('game/sections/widget.top-stars');
    }

    elseif ($type == 'top-user') {

        $query_gm_topStar = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE published='1' ORDER BY rand() LIMIT 17");
        $top_users_list = '';
        if ($query_gm_topStar->num_rows != 0) {
            while ($topStar = $query_gm_topStar->fetch_array()) {
                $game_top = gameData($topStar);
                $themeData['widget_topstar_url'] = $game_top['game_url'];
                $themeData['widget_topstar_image'] = $game_top['image_url'];
                $themeData['widget_topstar_name'] = $game_top['name'];
                $themeData['widget_topstar_rating'] = $topStar['rating'];
                $top_users_list .= \GameMonetize\UI::view('game/sections/widget-each/top-users-list');
            }
        } else {
            $top_users_list .= \GameMonetize\UI::view('game/sections/widget-each/top-stars-notfound');
        }
        $themeData['widget_sidebar_top_users_list'] = $top_users_list;
        return \GameMonetize\UI::view('game/sections/widget.top-users');
    }

    elseif ($type == 'random') {
        $query_gm_Random = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE published='1' ORDER BY featured, rand() desc LIMIT 30");
        $random_games_list = '';
        if ($query_gm_Random->num_rows != 0) {
            while ($gRandom = $query_gm_Random->fetch_array()) {
                $gmRandom = gameData($gRandom);
                $themeData['random_game_url'] = $gmRandom['game_url'];
                $themeData['random_game_image'] = $gmRandom['image_url'];
                $themeData['random_game_name'] = $gmRandom['name'];
                $themeData['random_game_rating'] = $gRandom['rating'];
                $themeData['random_game_video_url'] = $gRandom['video_url'];
                $random_games_list .= \GameMonetize\UI::view('game/sections/widget-each/random-games-list');
            }
        } else {
            $random_games_list .= \GameMonetize\UI::view('game/sections/widget-each/random-games-notfound');
        }

        $themeData['widget_sidebar_random_list'] = $random_games_list;
        return \GameMonetize\UI::view('game/sections/widget.random-games');
    }

    if ($type == 'similar-name'){
        $top_star_list = $sqlWhere = '';
        $selectedId = [];
        if(is_numeric(strpos($gameName, "."))){
            $gameNameExplode = explode('.', $gameName);
        }else{
            $gameNameExplode = explode(' ', $gameName);
        }
        
        $firstName = substr($gameNameExplode[0], 0, 4);
        $secondName = substr($gameNameExplode[1], 0, 4);
        
        if(count($exclusions) > 0){
            $sqlWhere .= " AND game_id NOT IN (".implode(',', $exclusions).") ";
        }

        $sqlQuerySimilar = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE (name LIKE '%{$firstName}%' OR name LIKE '%{$secondName}%') AND published='1' AND name != '{$gameName}' {$sqlWhere} ORDER BY name ASC LIMIT 6");
        if ($sqlQuerySimilar->num_rows != 0) {

            while ($game = $sqlQuerySimilar->fetch_array()) {
                if(!in_array($game['game_id'], $selectedId)){
                    $selectedId[] = $game['game_id'];
                }
                $game_top = gameData($game);
                $themeData['widget_topstar_url'] = $game_top['game_url'];
                $themeData['widget_topstar_image'] = $game_top['image_url'];
                $themeData['widget_topstar_name'] = $game_top['name'];
                $themeData['widget_topstar_rating'] = $game['rating'];
                $themeData['widget_topstar_video_url'] = $game['video_url'];
                $top_star_list .= \GameMonetize\UI::view('game/sections/widget-each/top-stars-list');
            }

            if($sqlQuerySimilar->num_rows < 6){
                $gameLimitRemaining = 6 - $sqlQuerySimilar->num_rows;
                if (count($selectedId) > 0) {
                    $sqlWhereFirst = " AND game_id NOT IN (" . implode(',', $selectedId) . ") ";
                } else {
                    $sqlWhereFirst = "";
                }
                $sqlQuerySimilar = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE name != '{$gameName}' AND published='1' {$sqlWhereFirst} {$sqlWhere} ORDER BY RAND() LIMIT {$gameLimitRemaining}");
                while ($game = $sqlQuerySimilar->fetch_array()) {
                    if(!in_array($game['game_id'], $selectedId)){
                        $selectedId[] = $game['game_id'];
                    }
                    $game_top = gameData($game);
                    $themeData['widget_topstar_url'] = $game_top['game_url'];
                    $themeData['widget_topstar_image'] = $game_top['image_url'];
                    $themeData['widget_topstar_name'] = $game_top['name'];
                    $themeData['widget_topstar_rating'] = $game['rating'];
                    $themeData['widget_topstar_video_url'] = $game['video_url'];
                    $top_star_list .= \GameMonetize\UI::view('game/sections/widget-each/top-stars-list');
                }

            }
        } else {

            // Get same category
            $sameCategoryCounter = 0;
            $sqlQuerySimilar = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE published='1' AND name != '{$gameName}' AND category = (SELECT category FROM ".GAMES." WHERE name = '{$gameName}') {$sqlWhere} ORDER BY name LIMIT 6");
            while ($game = $sqlQuerySimilar->fetch_array()) {
                if(!in_array($game['game_id'], $selectedId)){
                    $selectedId[] = $game['game_id'];
                }
                $game_top = gameData($game);
                $themeData['widget_topstar_url'] = $game_top['game_url'];
                $themeData['widget_topstar_image'] = $game_top['image_url'];
                $themeData['widget_topstar_name'] = $game_top['name'];
                $themeData['widget_topstar_rating'] = $game['rating'];
                $themeData['widget_topstar_video_url'] = $game['video_url'];
                $top_star_list .= \GameMonetize\UI::view('game/sections/widget-each/top-stars-list');
                $sameCategoryCounter++;
            }
            if($sameCategoryCounter < 6){

            }            
            if ($sqlQuerySimilar->num_rows < 6) {
                $gameLimitRemaining = 6 - $sqlQuerySimilar->num_rows;
                if (count($selectedId) > 0) {
                    $sqlWhereFirst = " AND game_id NOT IN (" . implode(',', $selectedId) . ") ";
                } else {
                    $sqlWhereFirst = "";
                }
                $sqlQuerySimilar = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE published='1' AND name != '{$gameName}' {$sqlWhere} {$sqlWhereFirst} ORDER BY RAND() LIMIT {$gameLimitRemaining}");

                while ($game = $sqlQuerySimilar->fetch_array()) {
                    if(!in_array($game['game_id'], $selectedId)){
                        $selectedId[] = $game['game_id'];
                    }
                    $game_top = gameData($game);
                    $themeData['widget_topstar_url'] = $game_top['game_url'];
                    $themeData['widget_topstar_image'] = $game_top['image_url'];
                    $themeData['widget_topstar_name'] = $game_top['name'];
                    $themeData['widget_topstar_rating'] = $game['rating'];
                    $themeData['widget_topstar_video_url'] = $game['video_url'];
                    $top_star_list .= \GameMonetize\UI::view('game/sections/widget-each/top-stars-list');
                }
            }
        }

        $themeData['widget_sidebar_top_star_list'] = $top_star_list;
        return [\GameMonetize\UI::view('game/sections/widget.top-stars'), $selectedId];
    }
}

function getCarouselWidget($type='carousel_random_games', $items=2) 
{
    global $GameMonetizeConnect, $themeData, $userData, $lang, $config;

    switch ( $type ) {
        case 'carousel_random_games':
            $query_gm_Random = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE published='1' ORDER BY rand() LIMIT 20");
            $carousel_random_games_list = '';
            if ($query_gm_Random->num_rows > 0) {
                while ($gRandom = $query_gm_Random->fetch_array()) {
                    $gmRandom = gameData($gRandom);
                    $themeData['random_game_url'] = $gmRandom['game_url'];
                    $themeData['random_game_image'] = $gmRandom['image_url'];
                    $themeData['random_game_name'] = $gmRandom['name'];
                    $themeData['random_game_rating'] = $gRandom['rating'];
                    $carousel_random_games_list .= \GameMonetize\UI::view('widgets/carousel-random-games/item');
                }
            } else {
                $carousel_random_games_list .= '';
            }
            $themeData['carousel_random_games_items'] = $items;
            $themeData['carousel_random_list'] = $carousel_random_games_list;
            // return \GameMonetize\UI::view('widgets/carousel-random-games/container');
        break;

    }
}

function installDefaultGames(){
    include( ABSPATH . 'assets/includes/config.php');
    include ABSPATH . 'assets/includes/tables.php';
        
    /**
    * Connecting to MySql server
    */
    global $GameMonetizeConnect;
    $GameMonetizeConnect = @new mysqli($dbGM['host'], $dbGM['user'], $dbGM['pass'], $dbGM['name']);
    /**
    * Set up connection charset
    */
    //$GameMonetizeConnect->set_charset("utf8");

    /**
    * Check connection status
    */
    if ($GameMonetizeConnect->connect_errno > 0) 
        exit($GameMonetizeConnect->connect_errno);

    include ABSPATH . 'assets/classes/load.php';
    include ABSPATH . 'gm-content/addons/load.php';
    include ABSPATH . 'assets/includes/engine.php';
    $time = ceil( time() );

    // Get custom game feed url
    $settingSql = "SELECT * FROM `gm_setting` WHERE `id` = '1'";
    $settings = $GameMonetizeConnect->query($settingSql);
    $settings = $settings->fetch_assoc();

    $catalog = file_get_contents('https://gamemonetize.com/rssfeed.php?format=json&category=All&type=html5&popularity=newest&company=All&amount=70');
    if (!!$catalog) {
        $games = json_decode($catalog, true);
        $i = 0;
        $installedGamesCounter = 0;
        $installedGamesMaximum = 50;
        foreach ($games as $game) {
                if($installedGamesCounter >= $installedGamesMaximum) break;
                $title = seo_friendly_url_custom($game['title']);
                $user_info = "SELECT * FROM `gm_games` WHERE `game_name` = '$title'";
                $user_info_query = $GameMonetizeConnect->query($user_info);

                if ($user_info_query->num_rows == 0) {

                    $game_data = array();
                    $game_data['catalog_id'] = secureEncode($game['id']);
                    $game_data['game_name'] = secureEncode($title);
                    $game_data['name'] = secureEncode($game['title']);
                    $game_data['description'] = !empty($game['description']) ? secureEncode($game['description']) : '';
                    $game_data['instructions'] = !empty($game['instructions']) ? secureEncode($game['instructions']) : '';
                    $game_data['file'] = secureEncode($game['url']);
                    $game_data['width'] = $game['width'];
                    $game_data['height'] = $game['height'];
                    $game_data['image'] = $game['thumb'];

                    // Get category from database
                    $category_data = getCategoriesLikeName($game['category']);
                    if($category_data !== null){
                            $category = $category_data['id'];                        
                    }

                    // Get tags from database
                    $allTags = explode(",", $game['tags']);
                    $allTagsId = [];
                    foreach($allTags as $tag){
                            $tag_data = getTagsLikeName(trim($tag));
                            $allTagsId[] = "\"{$tag_data["id"]}\"";
                    }
                    if(count($allTagsId) > 0){
                            $tags = "[".implode(",", $allTagsId)."]";
                    }

                    $isSuccess = $GameMonetizeConnect->query("INSERT INTO gm_games (
                            catalog_id, 
                            game_name, 
                            name, 
                            image, 
                            description, 
                            instructions, 
                            category, 
                            file, 
                            game_type, 
                            w, 
                            h, 
                            date_added, 
                            tags_ids,
                            published
                    ) VALUES (
                            'gamemonetize-{$game_data['catalog_id']}',
                            '{$game_data['game_name']}',
                            '{$game_data['name']}',
                            '{$game_data['image']}',
                            '{$game_data['description']}',
                            '{$game_data['instructions']}',
                            '{$category}',
                            '{$game_data['file']}',
                            'html5',
                            '{$game_data['width']}',
                            '{$game_data['height']}',
                            '{$time}', 
                            '{$tags}',
                            '1'
                    )");
                    if ($isSuccess) {
                            $installedGamesCounter++;
                            addGameXml(siteUrl() . '/game/' . $game_data['game_name']);
                    }
                    $i++;
                }
        }

        sleep(1);
        // $data['status'] = 200;
        // $data['message'] = $i . ' ' . $lang['admin_premium_games_installed'];
        return true;
    } 
    return false;

}

function seo_friendly_url_custom($string)
{
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), '-', $string);
    return strtolower(trim($string, '-'));
}

function getFooterDescription($type)
{
    $footer_description_result = (object)[];
    global $GameMonetizeConnect;
    $sqlQuery = $GameMonetizeConnect->query("SELECT description, has_content, content_value FROM ".FOOTER_DESCRIPTION." WHERE page_name='{$type}' OR page_url='/{$type}' LIMIT 1");
    if ($sqlQuery->num_rows > 0) {
        $footer_description = $sqlQuery->fetch_assoc();
        $footer_description_result->description = $footer_description['description'];
        $footer_description_result->has_content = $footer_description['has_content'];
        $footer_description_result->content_value = $footer_description['content_value'];
    }
    return $footer_description_result;
}

function db_array_install($site_url, $site_title, $admin_user, $admin_password, $admin_email) 
{
    $db = array();

    $db[0] = "CREATE TABLE IF NOT EXISTS `gm_account` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` text COLLATE utf8_unicode_ci NOT NULL,
                `username` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
                `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
                `admin` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
                `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
                `avatar_id` int(11) NOT NULL,
                `xp` int(11) NOT NULL,
                `language` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
                `profile_theme` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'style-1',
                `ip` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
                `registration_date` int(11) NOT NULL,
                `last_logged` int(11) NOT NULL,
                `last_update_info` int(11) NOT NULL,
                `active` enum('1','0') COLLATE utf8_unicode_ci NOT NULL,
                PRIMARY KEY (`id`) 
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
    # >>
    $db[1] = "INSERT INTO `gm_account` (`id`, `name`, `username`, `password`, `admin`, `email`, `xp`, `language`, `profile_theme`, `ip`, `registration_date`, `active`) VALUES (1, 'Administrator', '{$admin_user}', '{$admin_password}', '1', 'admin@admin.com', 0, 'english', 'style-1', '::0', 1478417322, '1')";
    # >>
    $db[2] = "CREATE TABLE IF NOT EXISTS `gm_users` (
                `user_id` int(11) NOT NULL,
                `gender` enum('1','2') CHARACTER SET utf8 NOT NULL DEFAULT '1',
                `about` text COLLATE utf8_unicode_ci NOT NULL,
                UNIQUE KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
    # >>
    $db[3] = "INSERT INTO `gm_users` (`user_id`, `gender`) VALUES (1, '1')";
    # >>
    $db[4] = "CREATE TABLE IF NOT EXISTS `gm_ads` (
                `id` int(11) NOT NULL,
                `728x90` varchar(700) COLLATE utf8_unicode_ci NOT NULL,
                `300x250` varchar(700) COLLATE utf8_unicode_ci NOT NULL,
                `600x300` varchar(700) COLLATE utf8_unicode_ci NOT NULL,
                `728x90_main` varchar(700) COLLATE utf8_unicode_ci NOT NULL,
                `300x250_main` varchar(700) COLLATE utf8_unicode_ci NOT NULL,
                `ads_video` varchar(700) COLLATE utf8_unicode_ci NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
    # >>
    $db[5] = "INSERT INTO `gm_ads` (`id`, `728x90`, `300x250`, `600x300`, `728x90_main`, `300x250_main`, `ads_video`) VALUES (1, '', '', '', '', '', '')";
    # >>
    $db[6] = "CREATE TABLE IF NOT EXISTS `gm_categories` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `category_pilot` varchar(250) CHARACTER SET utf8 NOT NULL,
                `name` text COLLATE utf8_unicode_ci NOT NULL,
                `image` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
                `footer_description` TEXT NULL DEFAULT '',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
    # >>
    $db[7] = "INSERT INTO `gm_categories` (`id`, `category_pilot`, `name`, `image`) VALUES
(1, 'action-games', 'Action Games', '/cat/action-games.jpg'),
(2, 'racing-games', 'Racing Games', '/cat/racing-games.png'),
(3, 'shooting-games', 'Shooting Games', '/cat/shooting-games.jpg'),
(4, 'arcade-games', 'Arcade Games', '/cat/arcade-games.jpg'),
(5, 'puzzle-games', 'Puzzle Games', '/cat/puzzle-games.jpg'),
(6, 'strategy-games', 'Strategy Games', '/cat/strategy-games.png'),
(7, 'multiplayer-games', 'Multiplayer Games', '/cat/multiplayer-games.jpg'),
(8, 'sports-games', 'Sports Games', '/cat/sports-games.png'),
(9, 'fighting-games', 'Fighting Games', '/cat/fighting-games.png');";
    # >>
    $db[10] = "CREATE TABLE IF NOT EXISTS `gm_games` (
                `game_id` int(11) NOT NULL AUTO_INCREMENT,
                `catalog_id` varchar(250) CHARACTER SET latin1 NOT NULL,
                `game_name` varchar(250) CHARACTER SET latin1 NOT NULL,
                `name` varchar(250) COLLATE latin1_swedish_ci NOT NULL,
                `image` varchar(500) COLLATE latin1_swedish_ci NOT NULL,
                `import` enum('0','1') COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
                `category` int(11) NOT NULL,
                `plays` int(11) NOT NULL,
                `rating` enum('0','0.5','1','1.5','2','2.5','3','3.5','4','4.5','5') COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
                `description` varchar(15000) COLLATE latin1_swedish_ci NOT NULL,
                `instructions` varchar(600) COLLATE latin1_swedish_ci NOT NULL,
                `file` varchar(500) COLLATE latin1_swedish_ci NOT NULL,
                `game_type` varchar(250) COLLATE latin1_swedish_ci NOT NULL,
                `w` int(10) NOT NULL,
                `h` int(10) NOT NULL,
                `date_added` int(11) NOT NULL,
                `published` enum('0','1') COLLATE latin1_swedish_ci NOT NULL,
                `featured` enum('0','1') COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
                `mobile` int(255) NOT NULL,
                `featured_sorting` varchar(255) NOT NULL,
                `field_1` varchar(500) NOT NULL,
                `field_2` varchar(500) NOT NULL,
                `field_3` varchar(500) NOT NULL,
                `field_4` varchar(500) NOT NULL,
                `field_5` varchar(500) NOT NULL,
                `field_6` varchar(500) NOT NULL,
                `field_7` varchar(500) NOT NULL,
                `field_8` varchar(500) NOT NULL,
                `field_9` varchar(500) NOT NULL,
                `field_10` varchar(500) NOT NULL,
                `tags_ids` JSON NULL DEFAULT NULL,
                `video_url` VARCHAR(100) NULL DEFAULT NULL,
                PRIMARY KEY (`game_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci";

    # >>
//     $db[16] = "INSERT INTO `gm_games` (`game_id`, `catalog_id`, `game_name`, `name`, `image`, `import`, `category`, `plays`, `rating`, `description`, `instructions`, `file`, `game_type`, `w`, `h`, `date_added`, `published`, `featured`) VALUES
// (1, 'gamemonetize-1447', 'pizza-ninja-mania', 'Pizza Ninja Mania', 'https://img.gamemonetize.com/a5687ulj1xahqiaiy04cudesyul5jmxt/512x384.jpg', '0', 0, 0, '0', 'Pizza ingredients juggling through the air, ninja slicing skills needed! Customers need to be served quickly and also love to see the entertainment. So grab a knife and do your job! Play in each game mode and be the best! Also new types of bonuses await!', '', 'https://html5.gamemonetize.com/a5687ulj1xahqiaiy04cudesyul5jmxt/', 'html5', 600, 800, 1576076683, '1', '0'),
// (2, 'gamemonetize-1446', 'wrestle-online', 'Wrestle Online', 'https://img.gamemonetize.com/dqa5wkouob7ff5gqs387s3ua4lnjdkiq/512x384.jpg', '0', 0, 12, '0', 'Jump up as you try to knock your opponent out. Play single player mode, two player mode or online multiplayer mode. Collect coins to unlock new skins in this fun multiplayer game.', '', 'https://html5.gamemonetize.com/dqa5wkouob7ff5gqs387s3ua4lnjdkiq/', 'html5', 800, 600, 1576076683, '1', '0'),
// (3, 'gamemonetize-1445', 'town-bus-driver', 'Town Bus Driver', 'https://img.gamemonetize.com/sgs955s7l9l3afnvbeksmihkfa8ry75q/512x384.jpg', '0', 2, 1, '0', 'The hardest part of driving and learning how to drive is mastering how to park without scratching or denting your new car. Town Driver allow you to drive around the parking lot simulating new life skills required for a car safety in the correct spot. Will you be able to park all the cars without leaving a scratch?', '', 'https://html5.gamemonetize.com/sgs955s7l9l3afnvbeksmihkfa8ry75q/', 'html5', 800, 600, 1576076683, '1', '0'),
// (4, 'gamemonetize-1444', '3d-billiard-8-ball-pool', '3d Billiard 8 ball Pool', 'https://img.gamemonetize.com/jf2a06o1z5ezy7stb7c4lmm13syg12yk/512x384.jpg', '0', 8, 1, '0', 'Famous variety of billiards. The goal of the game is to score all the balls of one group (either “striped” or “solid”) after robbery, and at the end to score the ball with the number 8. Whoever does this, he becomes the winner of the game.', '', 'https://html5.gamemonetize.com/jf2a06o1z5ezy7stb7c4lmm13syg12yk/', 'html5', 800, 600, 1576076683, '1', '0'),
// (5, 'gamemonetize-1443', 'my-perfect-bride-wedding-dress-up', 'My Perfect Bride Wedding Dress Up', 'https://img.gamemonetize.com/o9k6h9fskjgvyqfbenqu8lhrgf9s9egy/512x384.jpg', '0', 1, 1, '0', 'It&#039;s your big day, so why settle for looking good when you can look perfect? Getting married is a special occasion, and the bride needs to look and feel beautiful. In this dress-up game, click through the hair, accessory, and make-up options to get the perfect look for this blushing bride&#039;s wedding day.', '', 'https://html5.gamemonetize.com/o9k6h9fskjgvyqfbenqu8lhrgf9s9egy/', 'html5', 500, 750, 1576076683, '1', '0'),
// (6, 'gamemonetize-1442', 'prom-queen-dress-up-high-school', 'Prom Queen Dress Up High School', 'https://img.gamemonetize.com/f8x3crntylr78dyr70ja18m9ia9kiixy/512x384.jpg', '0', 1, 1, '0', 'Choose beautiful outfits, fashionable dresses and stylish hairstyles for high school girls who are soon graduating from school. In September, the girls plan to go on to College, Institute or University. But now may, school ends, the graduation party is approaching, and the most important question is what to wear fashionable, modern, elegant for the holiday?', '', 'https://html5.gamemonetize.com/f8x3crntylr78dyr70ja18m9ia9kiixy/', 'html5', 450, 750, 1576076683, '1', '0'),
// (7, 'gamemonetize-1441', 'block-puzzle-star', 'Block Puzzle Star', 'https://img.gamemonetize.com/ai2f44hil8mf7u5b8411dm83s1dyfhbp/512x384.jpg', '0', 5, 0, '0', 'Click on 3 or more connected stars of the same color to eliminate the stars and get a star bomb under certain conditions.', '', 'https://html5.gamemonetize.com/ai2f44hil8mf7u5b8411dm83s1dyfhbp/', 'html5', 640, 960, 1576076683, '1', '0'),
// (8, 'gamemonetize-1440', 'ace-plane-decisive-battle', 'Ace plane decisive battle', 'https://img.gamemonetize.com/a1i2o00hl13xeegd3vli22mm5sk7gqfq/512x384.jpg', '0', 5, 0, '0', 'Control your fighter, dodge local attacks, survive, and get high scores', '', 'https://html5.gamemonetize.com/a1i2o00hl13xeegd3vli22mm5sk7gqfq/', 'html5', 320, 480, 1576076683, '1', '0'),
// (9, 'gamemonetize-1439', 'dream-dolly-designer', 'Dream Dolly Designer', 'https://img.gamemonetize.com/38goragog2ic0szndwi6vqld9bbmjyin/512x384.jpg', '0', 1, 0, '0', 'Do you girls like playing with dolls? What if you could have as many dolls as you wish and take them everywhere with you? All you need to do is get Dream Dolly Designer - Doll Game right away! Create your dream dolls in one of the most wonderful games for girls! You can customize every detail of your doll, from facial features, to hair, makeup, outfit and even the packaging box! Get the fun started in a realistic and fun doll creator game.', '', 'https://html5.gamemonetize.com/38goragog2ic0szndwi6vqld9bbmjyin/', 'html5', 500, 750, 1576076683, '1', '0'),
// (10, 'gamemonetize-1438', 'dress-up-wheel', 'Dress Up Wheel', 'https://img.gamemonetize.com/80fcgr157d60gyw59udrfjgjll0gtli2/512x384.jpg', '0', 1, 0, '0', 'Girls, are you ready to see how lucky you are? Join Mira in one of the most amazing dress up games and find out what the wheel has prepared for you. Prove your fashion skills and test your luck! Which fashion style do you hope to unlock first? Spin the dress up wheel and let it guide you through 4 different styles: retro, classy, rockstar and school style. Mira can&#039;t wait to see what clothes you&#039;ll get. You will have a great time creating stylish outfits for our sweet fashionista!', '', 'https://html5.gamemonetize.com/80fcgr157d60gyw59udrfjgjll0gtli2/', 'html5', 500, 750, 1576076683, '1', '0'),
// (11, 'gamemonetize-1437', 'barber-cut', 'Barber Cut', 'https://img.gamemonetize.com/x7h07vpri80xenqa2bctdihg0m3280s5/512x384.jpg', '0', 4, 0, '0', 'Barber Cut Brand new Satisfying Game with Hair Cut , Just Swipe Your Trimmer cut the Hair in shop of the Barber , Play role of Barber and Earn the Money have fun with Customers Hair Styles .', '', 'https://html5.gamemonetize.com/x7h07vpri80xenqa2bctdihg0m3280s5/', 'html5', 450, 750, 1576076683, '1', '0'),
// (12, 'gamemonetize-1436', 'life-and-death-ninja', 'Life and death ninja', 'https://img.gamemonetize.com/ztmb2o2xmo3lzjh7igpo8yq2ixuso25n/512x384.jpg', '0', 4, 0, '0', 'Mouse control lets the ninja climb up, avoid the traps and see how many points you can get', '', 'https://html5.gamemonetize.com/ztmb2o2xmo3lzjh7igpo8yq2ixuso25n/', 'html5', 624, 1040, 1576076683, '1', '0'),
// (13, 'gamemonetize-1435', 'the-impossible-dash', 'The Impossible Dash', 'https://img.gamemonetize.com/0nymmbejllbo5qewsrvbly2xp4fujglj/512x384.jpg', '0', 4, 0, '0', 'The Impossible Dash is a click-moving game, the game has 7 levels with different obstacles, you need to click to move so as not to collide with obstacles. This is a funny game and lively sound. Wish you happy.', '', 'https://html5.gamemonetize.com/0nymmbejllbo5qewsrvbly2xp4fujglj/', 'html5', 800, 600, 1576076683, '1', '0'),
// (14, 'gamemonetize-1434', 'lovely-christmas-slide', 'Lovely Christmas Slide', 'https://img.gamemonetize.com/c842twvnn3212ajjspzldmr827ttldlx/512x384.jpg', '0', 5, 0, '0', 'Play this slide puzzle games of lovely christmas. It&#039;s include 3 images and 3 modes to play.', '', 'https://html5.gamemonetize.com/c842twvnn3212ajjspzldmr827ttldlx/', 'html5', 1920, 1080, 1576076683, '1', '0'),
// (15, 'gamemonetize-1433', 'christmas-mahjong-2019', 'Christmas Mahjong 2019', 'https://img.gamemonetize.com/pzvy1xjicqi1hz1uzgn2p34w5pczrc3g/512x384.jpg', '0', 5, 0, '0', 'Combine 2 of the same christmas mahjong tiles to remove them from the board. You only can use free tiles. A free tile is not covered by another stone and at least 1 side (left or right) is open.You have 25 levels to challenge in this mahjong games. You can play this mahjong game as many times as you like (with different challenge).', '', 'https://html5.gamemonetize.com/pzvy1xjicqi1hz1uzgn2p34w5pczrc3g/', 'html5', 800, 480, 1576076683, '1', '0'),
// (16, 'gamemonetize-1432', 'santa-gift-race', 'Santa Gift Race', 'https://img.gamemonetize.com/818wk1cler26dq7rpyomlp6w0qn17mtf/512x384.jpg', '0', 2, 0, '0', 'In this Christmas game, Santa is on his way to collect presents. But this time he is with his motorbike. Your job is to control the bike and to collect more gifts as you can, so you will make more children happy this year.', '', 'https://html5.gamemonetize.com/818wk1cler26dq7rpyomlp6w0qn17mtf/', 'html5', 860, 480, 1576076683, '1', '0'),
// (17, 'gamemonetize-1431', 'christmas-trend-2019-riding-boots', 'Christmas Trend 2019 Riding Boots', 'https://img.gamemonetize.com/noe53u362f9xwqgkd59uyhijr53fbt6y/512x384.jpg', '0', 1, 0, '0', 'Eliza and Tiara are famous fashionistas among princesses. They always want to be in trend! This year, Christmas riding boots are incredibly popular, combined with long sweaters and short dresses or skirts. It is ideal for strolling through the Christmas streets. Complement your look with a cozy scarf, cute hat or fur headphones. Do not forget to grab a clutch. Let&#039;s enjoy the holiday in style!', '', 'https://html5.gamemonetize.com/noe53u362f9xwqgkd59uyhijr53fbt6y/', 'html5', 800, 600, 1576076683, '1', '0'),
// (18, 'gamemonetize-1430', 'zombies-night-2', 'Zombies Night 2', 'https://img.gamemonetize.com/7xc6769oze1twzvd46paczg8pe2sc53j/512x384.jpg', '0', 3, 0, '0', 'Zombies Night is a first person shooting game. This is a second part of this shooting game. In the dark night zombies come out and attack city. Your mission is to protect the city and kill all zombies. Use mouse to shoot and aim, R for reload, G for grenade and 1-6 number to change weapons. Enjoy!', '', 'https://html5.gamemonetize.com/7xc6769oze1twzvd46paczg8pe2sc53j/', 'html5', 1280, 720, 1576076683, '1', '0'),
// (19, 'gamemonetize-1429', 'fz-foosball', 'FZ FoosBall', 'https://img.gamemonetize.com/eywam29gwpkday25nufp9z26ftfos0j6/512x384.jpg', '0', 8, 0, '0', 'FZ FoosBall - HTML5 games. use your skill to play game. Foxzin.com with tons of games for all ages and bringing fun to player Play free online games.', '', 'https://html5.gamemonetize.com/eywam29gwpkday25nufp9z26ftfos0j6/', 'html5', 800, 600, 1576076683, '1', '0'),
// (20, 'gamemonetize-1428', 'baby-sisters-christmas-day', 'Baby Sisters Christmas Day', 'https://img.gamemonetize.com/0zpwi6orqxxmon1h8rthxonvm300vkpw/512x384.jpg', '0', 1, 0, '0', 'The baby sisters Bella and Mia are planning their Christmas party. Give them ideas for their outlook and party hall decoration. Wish them happy Christmas!', '', 'https://html5.gamemonetize.com/0zpwi6orqxxmon1h8rthxonvm300vkpw/', 'html5', 800, 600, 1576076683, '1', '0'),
// (21, 'gamemonetize-1427', 'infinity-battlefield-ops', 'Infinity Battlefield Ops', 'https://img.gamemonetize.com/rko2tmgf6e58yquufwod2nwxg7cfzk4r/512x384.jpg', '0', 3, 0, '0', 'It’s time to take an action in the battlefield as an army commando and experience the best FPS shooting adventure. Shoot to kill in special ops with different army guns and survive in this survival action. You need to develop the strategy against enemies then you will be able to win the sniper ops commando shooter game.', '', 'https://html5.gamemonetize.com/rko2tmgf6e58yquufwod2nwxg7cfzk4r/', 'html5', 960, 640, 1576076683, '1', '0'),
// (22, 'gamemonetize-1426', 'clash-of-blocks', 'Clash of Blocks', 'https://img.gamemonetize.com/l7bzeu9rnblbms80475ptxw9jgv2usgg/512x384.jpg', '0', 5, 0, '0', 'In Clash of Blocks 2, your job is to strategically place your own block so that it rolls out faster than your opponents. Your goal is to win majority of the board, to have your color take up the majority of the board! Can you get a 60% majority? Or 70%? Or 80%? Or even over 90%?', '', 'https://html5.gamemonetize.com/l7bzeu9rnblbms80475ptxw9jgv2usgg/', 'html5', 500, 750, 1576076683, '1', '0'),
// (23, 'gamemonetize-1425', 'cinderella-dress-up', 'Cinderella Dress Up', 'https://img.gamemonetize.com/eftk5uktx50nzz6xbl8y521h91tfz4ie/512x384.jpg', '0', 1, 0, '0', 'Cinderella goes to the ball, where she will meet a handsome Prince. Before such an important event, Princess Cinderella needs to be brought to a beauty salon and dressed together with other princesses, fairies and brides. How else can girls develop a sense of style and the ability to dress fashionably and stylishly as not through dress-up games for girls, where princesses, fairies and brides are just waiting for young fashion lovers to start dressing and dressing them in the most beautiful.', '', 'https://html5.gamemonetize.com/eftk5uktx50nzz6xbl8y521h91tfz4ie/', 'html5', 450, 750, 1576076683, '1', '0'),
// (24, 'gamemonetize-1424', 'ludo-online-xmas', 'Ludo Online Xmas', 'https://img.gamemonetize.com/5bhq6b55mpkspxnmjjbsi213ig3ie3lj/512x384.jpg', '0', 7, 0, '0', 'Have fun with friends during Christmas holidays by playing Ludo Online Xmas game. The game has 3 modes: - Vs Bot: Playing against the computer (offline) - Online: Playing with randomly matched people - Private: Playing with your friends, simply share a private code and connect to each other. Merry Christmas! Play now!', '', 'https://html5.gamemonetize.com/5bhq6b55mpkspxnmjjbsi213ig3ie3lj/', 'html5', 960, 640, 1576076683, '1', '0'),
// (25, 'gamemonetize-1423', 'christmas-2019-puzzle', 'Christmas 2019 Puzzle', 'https://img.gamemonetize.com/cv8zdbnow24gwnm7t7lvqdsw4xsnp182/512x384.jpg', '0', 5, 0, '0', 'Play with 6 images in this perfect jigsaw puzzle game: Christmas 2019 Puzzle. All images is with the christmas 2019. Solve all puzzles and keep your brain sharp. You have four modes for each picture, 16 pieces, 36 pieces, 64 pieces and 100 pieces. Enjoy and have fun.', '', 'https://html5.gamemonetize.com/cv8zdbnow24gwnm7t7lvqdsw4xsnp182/', 'html5', 1920, 1080, 1576076683, '1', '0'),
// (26, 'gamemonetize-1422', 'captain-of-the-sea-difference', 'Captain Of The Sea Difference', 'https://img.gamemonetize.com/jtldja08kzzunv6e9sjzx2i58yu9d0nx/512x384.jpg', '0', 5, 0, '0', 'Captain of the Sea Difference is interesting kids game and it&#039;s time for you to have fun!In this game you need to find the differences in these funny kids images. Behind these pictures are small differences. Can you find them? They are fun designs for you to play with. A game that is fun and educational because it will help you improve your observation and concentration skills. You have 10 levels and 7 differences, for each level you have one minute to finish the same. Have fun!', '', 'https://html5.gamemonetize.com/jtldja08kzzunv6e9sjzx2i58yu9d0nx/', 'html5', 1280, 720, 1576076683, '1', '0'),
// (27, 'gamemonetize-1421', 'santa-gravity-run', 'Santa Gravity Run', 'https://img.gamemonetize.com/33mfamh63m7g1cr8rtq4b59ltp6s1hz5/512x384.jpg', '0', 4, 0, '0', 'Switch the gravity to control your Santa to avoid the obstacles and reach the door. 12 levels to go. Play now!', '', 'https://html5.gamemonetize.com/33mfamh63m7g1cr8rtq4b59ltp6s1hz5/', 'html5', 1280, 720, 1576076683, '1', '0'),
// (28, 'gamemonetize-1420', 'yamaha-2020-slide', 'Yamaha 2020 Slide', 'https://img.gamemonetize.com/58o2tshpk5iraa6jm4mr876u2lnnitsn/512x384.jpg', '0', 5, 0, '0', 'Play this slide puzzle games of yamaha 2020. It&#039;s include 3 images and 3 modes to play.', '', 'https://html5.gamemonetize.com/58o2tshpk5iraa6jm4mr876u2lnnitsn/', 'html5', 1920, 1080, 1576076683, '1', '0'),
// (29, 'gamemonetize-1419', 'christmas-carols-jigsaw', 'Christmas Carols Jigsaw', 'https://img.gamemonetize.com/kbij7josr9vq4ddrl5e8c3ahv0uym9a7/512x384.jpg', '0', 5, 0, '0', 'Christmas Carols Jigsaw is a free online game from genre of puzzle and jigsaw games. You can select one of the 12 images and then select one of the three modes: easy with 25 pieces, medium with 49 pieces and hard with 100 pieces. Have fun and enjoy!', '', 'https://html5.gamemonetize.com/kbij7josr9vq4ddrl5e8c3ahv0uym9a7/', 'html5', 1280, 720, 1576076683, '1', '0'),
// (1447, 'gamemonetize-1', 'parking-space', 'Parking Space', 'https://img.gamemonetize.com/fqlk4iyjezi097cis8nk7khn9rtarax6/512x384.jpg', '0', 2, 0, '0', 'Parking is an online game that you can play for free. In this fun parking game, you will challenge multiple levels. You must drive the car to a free parking space and park the car. Be sure not to hit anywhere or your car will crash. If some cars are blocking the road just move it and continue driving. Use your excellent driving skills to complete this game! Do you have confidence in your parking skill? Have fun with Parking!', '', 'https://html5.gamemonetize.com/fqlk4iyjezi097cis8nk7khn9rtarax6/', 'html5', 854, 480, 1576076683, '1', '0')";

    # >>
    $db[11] = "CREATE TABLE IF NOT EXISTS `gm_media` (
                `id` int(250) NOT NULL AUTO_INCREMENT,
                `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
                `extension` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
                `type` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
                `url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
    # >>
    $db[12] = "CREATE TABLE IF NOT EXISTS `gm_setting` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `site_name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
                `site_url` varchar(500) CHARACTER SET utf8 NOT NULL,
                `site_theme` varchar(500) CHARACTER SET utf8 NOT NULL,
                `site_description` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Best Free Online Games',
                `site_keywords` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'games, online, arcade, html5, gamemonetize',
                `ads_status` enum('0','1') CHARACTER SET utf8 NOT NULL DEFAULT '0',
                `ad_time` int(11) NOT NULL DEFAULT '10',
                `language` varchar(250) CHARACTER SET utf8 NOT NULL,
                `featured_game_limit` int(11) NOT NULL,
                `mp_game_limit` int(11) NOT NULL,
                `xp_play` int(11) NOT NULL,
                `xp_report` int(11) NOT NULL,
                `xp_register` int(11) NOT NULL,
                `plays` int(255) NOT NULL,
                `custom_game_feed_url` VARCHAR(1000) DEFAULT NULL,
                `settings_1` varchar(500) NOT NULL,
                `settings_2` varchar(500) NOT NULL,
                `settings_3` varchar(500) NOT NULL,
                `settings_4` varchar(500) NOT NULL,
                `settings_5` varchar(500) NOT NULL,
                `settings_6` varchar(500) NOT NULL,
                `settings_7` varchar(500) NOT NULL,
                `settings_8` varchar(500) NOT NULL,
                `settings_9` varchar(500) NOT NULL,
                `settings_10` varchar(500) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
    # >>
    $default_link = "https://gamemonetize.com/feed.php?format=0&num=60";
    $db[13] = "INSERT INTO `gm_setting` (`id`, `site_name`, `site_url`, `site_theme`, `ad_time`, `language`, `featured_game_limit`, `mp_game_limit`, `xp_play`, `xp_report`, `xp_register`, `custom_game_feed_url`) VALUES (1, '{$site_title}', '{$site_url}', 'kizi', 10, 'english', 8, 12, 50, 100, 10, '{$default_link}')";
    # >>
    $db[14] = "CREATE TABLE IF NOT EXISTS `gm_theme` (
                `theme_id` int(11) NOT NULL AUTO_INCREMENT,
                `theme_class` varchar(250) CHARACTER SET utf8 NOT NULL,
                PRIMARY KEY (`theme_id`), 
                UNIQUE KEY `theme_class` (`theme_class`), 
                UNIQUE KEY `theme_class_3` (`theme_class`), 
                KEY `theme_class_2` (`theme_class`)
            ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
    # >>
    $db[15] = "INSERT INTO `gm_theme` (`theme_id`, `theme_class`) VALUES (1, 'style-1'), (2, 'style-1-image'), (3, 'style-2'), (4, 'style-2-image'), (5, 'style-3'), (6, 'style-3-image'), (7, 'style-4'), (8, 'style-5'), (9, 'style-6'), (10, 'style-7')";
    # >>
    $db[32] = "CREATE TABLE IF NOT EXISTS `gm_tags` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `url` varchar(100) NOT NULL,
        `name` varchar(100) NOT NULL,
        `footer_description` text DEFAULT '',
        PRIMARY KEY (`id`),
        UNIQUE KEY `url` (`url`)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    # >>
    $db[33] = "CREATE TABLE IF NOT EXISTS `gm_footer_description` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `page_name` varchar(100) NOT NULL,
        `page_url` varchar(100) NOT NULL,
        `description` text NOT NULL,
        `has_content` enum('1','0') NOT NULL DEFAULT '0',
        `content_value` text DEFAULT '',
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    # >>
    $db[34] = "INSERT INTO `gm_footer_description` (`page_name`, `page_url`, `description`, `has_content`, `content_value`) VALUES
    ('home', '/', '', '0', ''),
    ('new games', '/new-games', '', '0', ''),
    ('best games', '/best-games', '', '0', ''),
    ('featured games', '/featured-games', '', '0', ''),
    ('played games', '/played-games', '', '0', ''),
    ('about', '/about', '', '0', ''),
    ('contact', '/contact', '', '0', ''),
    ('privacy', '/privacy', '', '0', ''),
    ('terms', '/terms', '', '0', ''),
    ('blogs', '/blogs', '', '0', ''),
    ('categories', '/categories', '', '0', ''),
    ('search', '/search', '', '0', '')";

    $db[35] = "CREATE TABLE IF NOT EXISTS `gm_blogs` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(100) NOT NULL,
        `url` varchar(100) NOT NULL,
        `image_url` varchar(200) DEFAULT NULL,
        `post` text DEFAULT NULL,
        `date_created` date NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    return (array) $db;
}

function addGameXml(string $gameUrl)
{
    $largestXml = findLargestXml('games');

    if (is_null($largestXml)) {
        echo "not found";die;
    }

    // Load the XML file
    $xml = simplexml_load_file($largestXml->filePath);

    // count xml child
    $xmlChild = count($xml->children());
    if($xmlChild > 1000){
        $xmlGames = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>' . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
        $urlElement = $xmlGames->addChild('url');
        $urlElement->addChild('loc', $gameUrl);
        $xmlGames->asXML('./' . ($largestXml->largestNumber + 1000) . 'games.xml');
    }else{
        // Add child
        $urlElement = $xml->addChild('url');
        $urlElement->addChild('loc', $gameUrl);
        // Save
        $xml->asXML($largestXml->filePath);
    }
}

function findLargestXml($title = 'games')
{
    $directory = $_SERVER['DOCUMENT_ROOT'];
    $files = glob($directory . '/*.xml');
    if (empty($files)) {
        return null;
    }

    $largestNumber = 0;
    $largestFile = '';

    foreach ($files as $file) {
        $fileName = basename($file);

        // Extract numeric part of the file name using regular expression
        if (preg_match('/(\d+)' . $title . '\.xml/', $fileName, $matches)) {
            $currentNumber = (int)$matches[1];

            if ($currentNumber > $largestNumber) {
                $largestNumber = $currentNumber;
                $largestFile = $fileName;
            }
        }
    }

    
    if (!empty($largestFile)) {
        return (object) [
            'filePath' => $directory . '/' . $largestFile,
            'largestNumber' => $largestNumber
        ];
    } 
    return null;
}

function addCategoryXml(string $categoryName)
{
    // Load the XML file
    $xml = simplexml_load_file('categories.xml');

    // Add child
    $xml->addChild('url')->addChild('loc', siteUrl() . '/' . $categoryName);
    // Save
    $xml->asXML('categories.xml');
}

function addTagsXml(string $tagsName)
{
    // Load the XML file
    $xml = simplexml_load_file('tags.xml');

    // Add child
    $xml->addChild('url')->addChild('loc', siteUrl() . '/' . $tagsName);
    // Save
    $xml->asXML('tags.xml');
}