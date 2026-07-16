<?php
namespace SimpleReset;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Admin {

    public function __construct() {

        add_action(
            'admin_menu',
            [ $this, 'admin_menu' ],
            5
        );

    }

    public function admin_menu() {

        add_menu_page(
            "Reset",
            "Reset",
            "manage_options",
            "simple-reset",
            [$this, "admin_page"],
            "dashicons-update",
            60
        );

        add_submenu_page(
            "simple-reset",
            "Dashboard",
            "Dashboard",
            "manage_options",
            "simple-reset",
            [$this, "admin_page"]
        );

        add_submenu_page(
            "simple-reset",
            "Reset Tools",
            "Reset Tools",
            "manage_options",
            "sr-reset-tools",
            [$this, "reset_tools_page"]
        );

        add_submenu_page(
            "simple-reset",
            "Settings",
            "Settings",
            "manage_options",
            "sr-settings",
            [$this, "settings_page"]
        );

        add_submenu_page(
            "simple-reset",
            "About",
            "About",
            "manage_options",
            "sr-about",
            [$this, "about_page"]
        );

    }

    public function admin_page()
    {
        $statistics = new Statistics();

        $counts = [
            'posts'      => $statistics->get_post_type_count( 'post' ),
            'pages'      => $statistics->get_post_type_count( 'page' ),
            'media'      => $statistics->get_post_type_count( 'attachment' ),
            'comments'   => $statistics->get_comment_count(),
            'categories' => $statistics->get_taxonomy_count( 'category' ),
            'tags'       => $statistics->get_taxonomy_count( 'post_tag' ),
            'users'      => $statistics->get_user_count(),
        ];

        require_once SR_PATH . 'templates/dashboard.php';
    }

    public function reset_tools_page()
    {
    $statistics = new Statistics();

    $counts = [

        'posts'      => $statistics->get_post_type_count( 'post' ),
        'pages'      => $statistics->get_post_type_count( 'page' ),
        'media'      => $statistics->get_post_type_count( 'attachment' ),
        'comments'   => $statistics->get_comment_count(),
        'categories' => $statistics->get_taxonomy_count( 'category' ),
        'tags'       => $statistics->get_taxonomy_count( 'post_tag' ),
        'users'      => $statistics->get_user_count(),

    ];
        require_once SR_PATH . "templates/reset-tools.php";
    }

    public function settings_page()
    {
        require_once SR_PATH . "templates/settings.php";
    }

    public function about_page()
    {
        ?>
        <div class="wrap">
            <h1>About</h1>
        </div>
        <?php
    }

}