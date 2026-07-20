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
            "Custom Post Types",
            "Custom Post Types",
            "manage_options",
            "sr-custom-post-types",
            [$this, "custom_post_types_page"]
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
            'revisions'  => $statistics->get_post_type_count( 'revision' ),
            'comments'   => $statistics->get_comment_count(),
            'categories' => $statistics->get_taxonomy_count( 'category' ),
            'tags'       => $statistics->get_taxonomy_count( 'post_tag' ),
            'users'      => $statistics->get_user_count(),
            'menus'      => $statistics->get_menu_count(),
            'post_auto-draft' => $statistics->get_post_type_count( 'post', 'auto-draft' ),
            'page_auto-draft' => $statistics->get_post_type_count( 'page', 'auto-draft' ),
            'trashed' => $statistics->get_trash_count(),
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
        'revisions'  => $statistics->get_post_type_count( 'revision' ),
        'comments'   => $statistics->get_comment_count(),
        'categories' => $statistics->get_taxonomy_count( 'category' ),
        'tags'       => $statistics->get_taxonomy_count( 'post_tag' ),
        'users'      => $statistics->get_user_count(),
        'menus'      => $statistics->get_menu_count(),
        'post_auto-draft' => $statistics->get_post_type_count( 'post', 'auto-draft' ),
        'page_auto-draft' => $statistics->get_post_type_count( 'page', 'auto-draft' ),
        'trashed' => $statistics->get_trash_count(),

    ];
        require_once SR_PATH . "templates/reset-tools.php";
    }

    public function settings_page()
    {
        require_once SR_PATH . "templates/settings.php";
    }

    public function custom_post_types_page()
    {
        $statistics       = new Statistics();
        $custom_post_types = Reset::get_custom_post_types();

        require_once SR_PATH . "templates/custom-post-types.php";
    }

    public function about_page()
    {
        require_once SR_PATH . "templates/about.php";
    }

}
