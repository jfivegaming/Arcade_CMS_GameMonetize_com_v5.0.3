<?php

/**
 * GameMonetize.com - Copyright © 2021
 *
 *
 * @author GameMonetize.com
 *
 */

#error_reporting(0);

if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(dirname(dirname(__FILE__))) . '/');
}

# Theater mode - full size
$theater_pages = array('play');
$themeData['page_theater_mode'] = (incCheck($theater_pages, $_GET['p'], 'scan')) ? 'theater-mode' : '';
# >>

if (!isset($_GET['p'])) {
    $_GET['p'] = 'home';
}
switch ($_GET['p']) {
        # Index page source
    case 'home':
    case 'index':
        include(ABSPATH . 'assets/sources/home.php');
        break;

        # Admin page source
    case 'admin':
        include(ABSPATH . 'assets/sources/admin-panel.php');
        break;

        # Game page source
    case 'play':
        include(ABSPATH . 'assets/sources/play.php');
        break;

        # Login page source
    case 'login':
        include(ABSPATH . 'assets/sources/login.php');
        break;

        # Register page source
    case 'signup':
        include(ABSPATH . 'assets/sources/register.php');
        break;

        # Settings page source
    case 'setting':
        include(ABSPATH . 'assets/sources/setting.php');
        break;

        # Profile page source
    case 'profile':
        include(ABSPATH . 'assets/sources/profile.php');
        break;

        # Logout
    case 'logout':
        include(ABSPATH . 'assets/sources/logout.php');
        break;

    case 'new-games':
        include(ABSPATH . 'assets/sources/newgames.php');
        break;

    case 'best-games':
        include(ABSPATH . 'assets/sources/bestgames.php');
        break;

    case 'random':
        include(ABSPATH . 'assets/sources/random.php');
        break;

    case 'about':
        include(ABSPATH . 'assets/sources/about.php');
        break;

    case 'terms':
        include(ABSPATH . 'assets/sources/terms.php');
        break;

    case 'contact':
        include(ABSPATH . 'assets/sources/contact.php');
        break;

    case 'privacy':
        include(ABSPATH . 'assets/sources/privacy.php');
        break;

    case 'tags':
        include(ABSPATH . 'assets/sources/tags.php');
        break;

    case 'featured-games':
        include(ABSPATH . 'assets/sources/featuredgames.php');
        break;

    case 'played-games':
        include(ABSPATH . 'assets/sources/playedgames.php');
        break;

    # Categories page source
    case 'categories':
        include(ABSPATH . 'assets/sources/categories.php');
        break;

    case 'tagspage':
        include(ABSPATH . 'assets/sources/tags-page.php');
        break;

    case 'blogs':
        include(ABSPATH . 'assets/sources/blogs.php');
        break;
        
    case 'search':
        include(ABSPATH . 'assets/sources/search.php');
        break;

    case 'feed':
        include(ABSPATH . 'assets/sources/feed.php');
        break;
}

if (empty($themeData['page_content'])) {
    $themeData['page_content'] = \GameMonetize\UI::view('welcome/error');
}
