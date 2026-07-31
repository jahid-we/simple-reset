<?php
if (!defined("ABSPATH")) {
    exit();
}

// $counts is injected by Admin::reset_tools_page() via Statistics.
$deleted = isset($_GET["deleted"])
    ? sanitize_text_field(wp_unslash($_GET["deleted"]))
    : "";

// Fetch safety option settings
$sr_enable_reset    = get_option( 'sr_enable_reset', '1' );
$allowed_ids_str    = get_option( 'sr_allowed_user_ids', '' );
$require_backup     = get_option( 'sr_require_backup', '0' );
$warning_message    = get_option( 'sr_warning_message', '' );
$warning_message    = '' !== trim( $warning_message )
    ? $warning_message
    : 'All deletions below are permanent and irreversible. Please back up your database before proceeding.';

$is_authorized = true;
if ( ! empty( $allowed_ids_str ) ) {
    $allowed_ids = array_map( 'intval', array_filter( array_map( 'trim', explode( ',', $allowed_ids_str ) ) ) );
    if ( ! in_array( get_current_user_id(), $allowed_ids, true ) ) {
        $is_authorized = false;
    }
}

// Global button disable logic
$GLOBALS['sr_disable_all_buttons'] = ( '1' !== $sr_enable_reset || ! $is_authorized );

// Card SVG icons definition
$posts_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>';
$pages_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>';
$media_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>';
$comments_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>';
$categories_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>';
$tags_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>';
$users_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>';
$menus_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>';
$delete_svg = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>';
$revisions_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><polyline points="3 3 3 8 8 8"/><line x1="12" y1="7" x2="12" y2="12"/><line x1="12" y1="12" x2="16" y2="14"/></svg>';
$post_auto_draft_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4z"/></svg>';
$page_auto_draft_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polygon points="2 17 12 22 22 17"/><polygon points="2 12 12 17 22 12"/></svg>';
$trashed_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>';
$customizer_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>';

$wc_products_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V4H2v5a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V9"/><path d="M16 9V4h4v5a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2V9"/><path d="M10 15h4"/><path d="M4 20h16"/><path d="M10 12h4"/></svg>';
$wc_coupons_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12a2 2 0 0 1 0-4V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v2a2 2 0 0 1 0 4v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2a2 2 0 0 1 0-4z"/><line x1="9" y1="15" x2="15" y2="9"/><circle cx="9" cy="9" r="1"/><circle cx="15" cy="15" r="1"/></svg>';
$wc_product_categories_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z"/><rect x="8" y="11" width="3" height="3"/><rect x="13" y="11" width="3" height="3"/></svg>';
$wc_product_tags_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><circle cx="7" cy="7" r="1"/><rect x="12" y="8" width="3" height="3"/><rect x="16" y="12" width="3" height="3"/></svg>';
$wc_product_attribute_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6a6 6 0 0 1 0 12"/><path d="M9 18a6 6 0 0 1 0-12"/><path d="M9 18c-1 1-2 2-4 2"/><path d="M15 18c1 1 2 2 4 2"/><line x1="4" y1="16" x2="4" y2="20"/><line x1="20" y1="16" x2="20" y2="20"/></svg>';
$wc_orders_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/><circle cx="12" cy="14" r="2"/></svg>';
$wc_customers_svg = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>';

$is_wc_active = class_exists( 'WooCommerce' );
?>

<?php if ("1" === $deleted): ?>
<div class="sr-toast sr-toast--success" id="sr-toast">
    <span class="sr-toast__icon">✓</span>
    <span>Reset operation completed successfully.</span>
    <button class="sr-toast__close" onclick="this.parentElement.remove()">✕</button>
</div>
<?php endif; ?>

<div class="sr-page-wrap">

    <!-- Page Header -->
    <div class="sr-page-header">
        <div class="sr-page-header__left">
            <div class="sr-page-header__icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
            </div>
            <div>
                <h1 class="sr-page-header__title">Reset Tools</h1>
                <p class="sr-page-header__subtitle">Permanently remove WordPress content. These actions cannot be undone.</p>
            </div>
        </div>
        <div class="sr-danger-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L1 21h22L12 2zm0 3.5L20.5 19h-17L12 5.5zM11 10v4h2v-4h-2zm0 6v2h2v-2h-2z"/></svg>
            Destructive Actions
        </div>
    </div>

    <!-- Warning Banner -->
    <div class="sr-warning-banner">
        <svg class="sr-warning-banner__icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L1 21h22L12 2zm0 3.5L20.5 19h-17L12 5.5zM11 10v4h2v-4h-2zm0 6v2h2v-2h-2z"/></svg>
        <p><strong>Warning:</strong> <?php echo esc_html( $warning_message ); ?></p>
    </div>

    <!-- Filter Tabs -->
    <div class="sr-filter-tabs">
        <div class="sr-filter-tab active" data-group="all">
            All Tools
        </div>
        <div class="sr-filter-tab" data-group="content">
            📝 WordPress Content
        </div>
        <div class="sr-filter-tab" data-group="taxonomies">
            👥 Taxonomies &amp; Users
        </div>
        <div class="sr-filter-tab" data-group="system">
            ⚙️ System &amp; Cleanup
        </div>
        <?php if ( $is_wc_active ) : ?>
            <div class="sr-filter-tab" data-group="woocommerce">
                🛒 WooCommerce Store
            </div>
        <?php endif; ?>
    </div>

    <!-- SECTION 1: CORE WORDPRESS CONTENT -->
    <div class="sr-section-block" data-group="content">
        <div class="sr-section-header">
            <div class="sr-section-header__title-wrap">
                <div class="sr-section-header__icon sr-section-header__icon--indigo">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <h2 class="sr-section-header__title">WordPress Core Content</h2>
            </div>
        </div>

        <div class="sr-grid">
            <!-- Delete Posts -->
            <?php
            $card = [
                'type'          => 'posts',
                'badge'         => 'Posts',
                'title'         => 'Delete All Posts',
                'description'   => 'Permanently removes all blog posts from your WordPress site, including drafts, scheduled, and trashed posts.',
                'count'         => $counts['posts'],
                'singular'      => 'post',
                'plural'        => 'posts',
                'icon'          => $posts_svg,
                'button_icon'   => $delete_svg,
                'icon_class'    => 'sr-card__icon--red',
                'counter_class' => 'sr-card__counter--red',
                'action'        => 'sr_delete_posts',
                'nonce'         => 'sr_delete_posts',
                'button_text'   => 'Delete All Posts',
                'note'          => '',
                'hidden_fields' => [],
            ];
            include SR_PATH . 'templates/parts/reset-card.php';
            ?>

            <!-- Delete Pages -->
            <?php
            $card = [
                'type'          => 'pages',
                'badge'         => 'Pages',
                'title'         => 'Delete All Pages',
                'description'   => 'Permanently removes all static pages from your WordPress site, including your homepage and all subpages.',
                'count'         => $counts['pages'],
                'singular'      => 'page',
                'plural'        => 'pages',
                'icon'          => $pages_svg,
                'button_icon'   => $delete_svg,
                'icon_class'    => 'sr-card__icon--orange',
                'counter_class' => 'sr-card__counter--orange',
                'action'        => 'sr_delete_pages',
                'nonce'         => 'sr_delete_pages',
                'button_text'   => 'Delete All Pages',
                'note'          => '',
                'hidden_fields' => [],
            ];
            include SR_PATH . 'templates/parts/reset-card.php';
            ?>

            <!-- Delete Media -->
            <?php
            $card = [
                'type'          => 'media',
                'badge'         => 'Media',
                'title'         => 'Delete All Media',
                'description'   => 'Permanently removes all uploaded images, videos, documents, and other files from your media library.',
                'count'         => $counts['media'],
                'singular'      => 'file',
                'plural'        => 'files',
                'icon'          => $media_svg,
                'button_icon'   => $delete_svg,
                'icon_class'    => 'sr-card__icon--purple',
                'counter_class' => 'sr-card__counter--purple',
                'action'        => 'sr_delete_media',
                'nonce'         => 'sr_delete_media',
                'button_text'   => 'Delete All Media',
                'note'          => '',
                'hidden_fields' => [],
            ];
            include SR_PATH . 'templates/parts/reset-card.php';
            ?>

            <!-- Delete Comments -->
            <?php
            $card = [
                'type'          => 'comments',
                'badge'         => 'Comments',
                'title'         => 'Delete All Comments',
                'description'   => 'Permanently removes all comments from your site, including approved, pending, spam, and trashed comments.',
                'count'         => $counts['comments'],
                'singular'      => 'comment',
                'plural'        => 'comments',
                'icon'          => $comments_svg,
                'button_icon'   => $delete_svg,
                'icon_class'    => 'sr-card__icon--blue',
                'counter_class' => 'sr-card__counter--blue',
                'action'        => 'sr_delete_comments',
                'nonce'         => 'sr_delete_comments',
                'button_text'   => 'Delete All Comments',
                'note'          => '',
                'hidden_fields' => [],
            ];
            include SR_PATH . 'templates/parts/reset-card.php';
            ?>
        </div>
    </div>

    <!-- SECTION 2: TAXONOMIES & USERS -->
    <div class="sr-section-block" data-group="taxonomies">
        <div class="sr-section-header">
            <div class="sr-section-header__title-wrap">
                <div class="sr-section-header__icon sr-section-header__icon--teal">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <h2 class="sr-section-header__title">Taxonomies &amp; Users</h2>
            </div>
        </div>

        <div class="sr-grid">
            <!-- Delete Categories -->
            <?php
            $card = [
                'type'          => 'categories',
                'badge'         => 'Categories',
                'title'         => 'Delete All Categories',
                'description'   => 'Permanently removes all custom categories. The default WordPress category will be automatically preserved.',
                'count'         => $counts['categories'],
                'singular'      => 'category',
                'plural'        => 'categories',
                'icon'          => $categories_svg,
                'button_icon'   => $delete_svg,
                'icon_class'    => 'sr-card__icon--teal',
                'counter_class' => 'sr-card__counter--teal',
                'action'        => 'sr_delete_categories',
                'nonce'         => 'sr_delete_categories',
                'button_text'   => 'Delete All Categories',
                'note'          => '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg> Default category will be preserved',
                'hidden_fields' => [],
            ];
            include SR_PATH . 'templates/parts/reset-card.php';
            ?>

            <!-- Delete Tags -->
            <?php
            $card = [
                'type'          => 'tags',
                'badge'         => 'Tags',
                'title'         => 'Delete All Tags',
                'description'   => 'Permanently removes all post tags from your WordPress site. Tagged posts will remain but become untagged.',
                'count'         => $counts['tags'],
                'singular'      => 'tag',
                'plural'        => 'tags',
                'icon'          => $tags_svg,
                'button_icon'   => $delete_svg,
                'icon_class'    => 'sr-card__icon--pink',
                'counter_class' => 'sr-card__counter--pink',
                'action'        => 'sr_delete_tags',
                'nonce'         => 'sr_delete_tags',
                'button_text'   => 'Delete All Tags',
                'note'          => '',
                'hidden_fields' => [],
            ];
            include SR_PATH . 'templates/parts/reset-card.php';
            ?>

            <!-- Delete Users -->
            <?php
            $card = [
                'type'          => 'users',
                'badge'         => 'Users',
                'title'         => 'Delete All Users',
                'description'   => 'Permanently removes all users from your WordPress site. Administrator accounts are protected.',
                'count'         => $counts['users'],
                'singular'      => 'user',
                'plural'        => 'users',
                'icon'          => $users_svg,
                'button_icon'   => $delete_svg,
                'icon_class'    => 'sr-card__icon--indigo',
                'counter_class' => 'sr-card__counter--indigo',
                'action'        => 'sr_delete_users',
                'nonce'         => 'sr_delete_users',
                'button_text'   => 'Delete All Users',
                'note'          => '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg> Administrators and current user protected',
                'hidden_fields' => [],
            ];
            include SR_PATH . 'templates/parts/reset-card.php';
            ?>

            <!-- Delete All Menus -->
            <?php
            $card = [
                'type'          => 'menus',
                'badge'         => 'Menus',
                'title'         => 'Delete All Menus',
                'description'   => 'Permanently removes all navigation menus from your WordPress site.',
                'count'         => $counts['menus'],
                'singular'      => 'menu',
                'plural'        => 'menus',
                'icon'          => $menus_svg,
                'button_icon'   => $delete_svg,
                'icon_class'    => 'sr-card__icon--emerald',
                'counter_class' => 'sr-card__counter--emerald',
                'action'        => 'sr_delete_menus',
                'nonce'         => 'sr_delete_menus',
                'button_text'   => 'Delete All Menus',
                'note'          => '',
                'hidden_fields' => [],
            ];
            include SR_PATH . 'templates/parts/reset-card.php';
            ?>
        </div>
    </div>

    <!-- SECTION 3: SYSTEM & MAINTENANCE -->
    <div class="sr-section-block" data-group="system">
        <div class="sr-section-header">
            <div class="sr-section-header__title-wrap">
                <div class="sr-section-header__icon sr-section-header__icon--rose">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><polyline points="3 3 3 8 8 8"/></svg>
                </div>
                <h2 class="sr-section-header__title">System &amp; Maintenance</h2>
            </div>
        </div>

        <div class="sr-grid">
            <!-- Delete All Revisions -->
            <?php
            $card = [
                'type'          => 'revisions',
                'badge'         => 'Revisions',
                'title'         => 'Delete All Revisions',
                'description'   => 'Permanently removes all post revisions from your WordPress site.',
                'count'         => $counts['revisions'],
                'singular'      => 'revision',
                'plural'        => 'revisions',
                'icon'          => $revisions_svg,
                'button_icon'   => $delete_svg,
                'icon_class'    => 'sr-card__icon--cyan',
                'counter_class' => 'sr-card__counter--cyan',
                'action'        => 'sr_delete_revisions',
                'nonce'         => 'sr_delete_revisions',
                'button_text'   => 'Delete All Revisions',
                'note'          => '',
                'hidden_fields' => [],
            ];
            include SR_PATH . 'templates/parts/reset-card.php';
            ?>

            <!-- Delete Post Auto Draft -->
            <?php
            $card = [
                'type'          => 'post_auto-draft',
                'badge'         => 'Post Auto Draft',
                'title'         => 'Delete Post Auto Drafts',
                'description'   => 'Permanently removes all post auto-drafts from your WordPress site.',
                'count'         => $counts['post_auto-draft'],
                'singular'      => 'post auto draft',
                'plural'        => 'post auto drafts',
                'icon'          => $post_auto_draft_svg,
                'button_icon'   => $delete_svg,
                'icon_class'    => 'sr-card__icon--amber',
                'counter_class' => 'sr-card__counter--amber',
                'action'        => 'sr_delete_post_auto-draft',
                'nonce'         => 'sr_delete_post_auto-draft',
                'button_text'   => 'Delete Post Auto Drafts',
                'note'          => '',
                'hidden_fields' => [],
            ];
            include SR_PATH . 'templates/parts/reset-card.php';
            ?>

            <!-- Delete Page Auto Draft -->
            <?php
            $card = [
                'type'          => 'page_auto-draft',
                'badge'         => 'Page Auto Draft',
                'title'         => 'Delete Page Auto Drafts',
                'description'   => 'Permanently removes all page auto-drafts from your WordPress site.',
                'count'         => $counts['page_auto-draft'],
                'singular'      => 'page auto draft',
                'plural'        => 'page auto drafts',
                'icon'          => $page_auto_draft_svg,
                'button_icon'   => $delete_svg,
                'icon_class'    => 'sr-card__icon--fuchsia',
                'counter_class' => 'sr-card__counter--fuchsia',
                'action'        => 'sr_delete_page_auto-draft',
                'nonce'         => 'sr_delete_page_auto-draft',
                'button_text'   => 'Delete Page Auto Drafts',
                'note'          => '',
                'hidden_fields' => [],
            ];
            include SR_PATH . 'templates/parts/reset-card.php';
            ?>

            <!-- Delete All Trashed -->
            <?php
            $card = [
                'type'          => 'trashed',
                'badge'         => 'Trashed Item',
                'title'         => 'Delete All Trashed',
                'description'   => 'Permanently removes all trashed items across all post types from your WordPress site.',
                'count'         => $counts['trashed'],
                'singular'      => 'trashed item',
                'plural'        => 'trashed items',
                'icon'          => $trashed_svg,
                'button_icon'   => $delete_svg,
                'icon_class'    => 'sr-card__icon--rose',
                'counter_class' => 'sr-card__counter--rose',
                'action'        => 'sr_delete_trashed',
                'nonce'         => 'sr_delete_trashed',
                'button_text'   => 'Delete All Trashed',
                'note'          => '',
                'hidden_fields' => [],
            ];
            include SR_PATH . 'templates/parts/reset-card.php';
            ?>

            <!-- Reset Theme Customizer -->
            <?php
            $card = [
                'type'          => 'theme-customizer',
                'badge'         => 'Customizer',
                'title'         => 'Reset Theme Customizer',
                'description'   => "Restore the active theme's Customizer settings to default values.",
                'count'         => $counts['theme_mods'],
                'singular'      => 'setting',
                'plural'        => 'settings',
                'icon'          => $customizer_svg,
                'button_icon'   => $delete_svg,
                'icon_class'    => 'sr-card__icon--blue',
                'counter_class' => 'sr-card__counter--blue',
                'action'        => 'sr_reset_theme_customizer',
                'nonce'         => 'sr_reset_theme_customizer',
                'button_text'   => 'Reset Theme Customizer',
                'note'          => '',
                'hidden_fields' => [],
            ];
            include SR_PATH . 'templates/parts/reset-card.php';
            ?>
        </div>
    </div>

    <!-- SECTION 4: WOOCOMMERCE STORE CLEANUP -->
    <?php if ( $is_wc_active ) : ?>
        <div class="sr-section-block" data-group="woocommerce">
            <div class="sr-section-header">
                <div class="sr-section-header__title-wrap">
                    <div class="sr-section-header__icon sr-section-header__icon--woo">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    </div>
                    <h2 class="sr-section-header__title">WooCommerce Store Cleanup</h2>
                </div>
            </div>

            <div class="sr-grid">
                <!-- Delete All WC Products -->
                <?php
                $card = [
                    'type'          => 'wc-products',
                    'badge'         => 'WC Products',
                    'title'         => 'Delete All WooCommerce Products',
                    'description'   => "Delete all WooCommerce products and product variations from your site.",
                    'count'         => $counts['wc_products'] ?? 0,
                    'singular'      => 'product',
                    'plural'        => 'products',
                    'icon'          => $wc_products_svg,
                    'button_icon'   => $delete_svg,
                    'icon_class'    => 'sr-card__icon--woocommerce',
                    'counter_class' => 'sr-card__counter--woocommerce',
                    'action'        => 'sr_delete_wc_products',
                    'nonce'         => 'sr_delete_wc_products',
                    'button_text'   => 'Delete All Products',
                    'note'          => '',
                    'hidden_fields' => [],
                ];
                include SR_PATH . 'templates/parts/reset-card.php';
                ?>

                <!-- Delete All WC Coupons -->
                <?php
                $card = [
                    'type'          => 'wc-coupons',
                    'badge'         => 'Coupons',
                    'title'         => 'Delete All WooCommerce Coupons',
                    'description'   => "Delete all discount coupons created in WooCommerce.",
                    'count'         => $counts['wc_coupons'] ?? 0,
                    'singular'      => 'coupon',
                    'plural'        => 'coupons',
                    'icon'          => $wc_coupons_svg,
                    'button_icon'   => $delete_svg,
                    'icon_class'    => 'sr-card__icon--woocommerce',
                    'counter_class' => 'sr-card__counter--woocommerce',
                    'action'        => 'sr_delete_wc_coupons',
                    'nonce'         => 'sr_delete_wc_coupons',
                    'button_text'   => 'Delete All Coupons',
                    'note'          => '',
                    'hidden_fields' => [],
                ];
                include SR_PATH . 'templates/parts/reset-card.php';
                ?>

                <!-- Delete All WC Product Categories -->
                <?php
                $card = [
                    'type'          => 'wc-product-categories',
                    'badge'         => 'Product Categories',
                    'title'         => 'Delete All WooCommerce Product Categories',
                    'description'   => "Delete all product categories from your WooCommerce store.",
                    'count'         => $counts['wc_product_categories'] ?? 0,
                    'singular'      => 'product category',
                    'plural'        => 'product categories',
                    'icon'          => $wc_product_categories_svg,
                    'button_icon'   => $delete_svg,
                    'icon_class'    => 'sr-card__icon--woocommerce',
                    'counter_class' => 'sr-card__counter--woocommerce',
                    'action'        => 'sr_delete_wc_product_categories',
                    'nonce'         => 'sr_delete_wc_product_categories',
                    'button_text'   => 'Delete All Product Categories',
                    'note'          => '',
                    'hidden_fields' => [],
                ];
                include SR_PATH . 'templates/parts/reset-card.php';
                ?>

                <!-- Delete All WC Product Tags -->
                <?php
                $card = [
                    'type'          => 'wc-product-tags',
                    'badge'         => 'Product Tags',
                    'title'         => 'Delete All WooCommerce Product Tags',
                    'description'   => "Delete all product tags from your WooCommerce store.",
                    'count'         => $counts['wc_product_tags'] ?? 0,
                    'singular'      => 'product tag',
                    'plural'        => 'product tags',
                    'icon'          => $wc_product_tags_svg,
                    'button_icon'   => $delete_svg,
                    'icon_class'    => 'sr-card__icon--woocommerce',
                    'counter_class' => 'sr-card__counter--woocommerce',
                    'action'        => 'sr_delete_wc_product_tags',
                    'nonce'         => 'sr_delete_wc_product_tags',
                    'button_text'   => 'Delete All Product Tags',
                    'note'          => '',
                    'hidden_fields' => [],
                ];
                include SR_PATH . 'templates/parts/reset-card.php';
                ?>

                <!-- Delete All WC Product Attributes -->
                <?php
                $card = [
                    'type'          => 'wc-product-attribute',
                    'badge'         => 'Product Attributes',
                    'title'         => 'Delete All WooCommerce Product Attributes',
                    'description'   => "Delete all custom product attributes and attribute terms.",
                    'count'         => $counts['wc_product_attribute'] ?? 0,
                    'singular'      => 'product attribute',
                    'plural'        => 'product attributes',
                    'icon'          => $wc_product_attribute_svg,
                    'button_icon'   => $delete_svg,
                    'icon_class'    => 'sr-card__icon--woocommerce',
                    'counter_class' => 'sr-card__counter--woocommerce',
                    'action'        => 'sr_delete_wc_product_attributes',
                    'nonce'         => 'sr_delete_wc_product_attributes',
                    'button_text'   => 'Delete All Product Attributes',
                    'note'          => '',
                    'hidden_fields' => [],
                ];
                include SR_PATH . 'templates/parts/reset-card.php';
                ?>

                <!-- Delete All WC Orders -->
                <?php
                $card = [
                    'type'          => 'wc-orders',
                    'badge'         => 'Orders',
                    'title'         => 'Delete All WooCommerce Orders',
                    'description'   => "Permanently delete all customer orders from your WooCommerce store.",
                    'count'         => $counts['wc_orders'] ?? 0,
                    'singular'      => 'order',
                    'plural'        => 'orders',
                    'icon'          => $wc_orders_svg,
                    'button_icon'   => $delete_svg,
                    'icon_class'    => 'sr-card__icon--woocommerce',
                    'counter_class' => 'sr-card__counter--woocommerce',
                    'action'        => 'sr_delete_wc_orders',
                    'nonce'         => 'sr_delete_wc_orders',
                    'button_text'   => 'Delete All Orders',
                    'note'          => '',
                    'hidden_fields' => [],
                ];
                include SR_PATH . 'templates/parts/reset-card.php';
                ?>

                <!-- Delete All WC Customers -->
                <?php
                $card = [
                    'type'          => 'wc-customers',
                    'badge'         => 'Customers',
                    'title'         => 'Delete All WooCommerce Customers',
                    'description'   => "Delete all user accounts registered with the 'Customer' role.",
                    'count'         => $counts['wc_customers'] ?? 0,
                    'singular'      => 'customer',
                    'plural'        => 'customers',
                    'icon'          => $wc_customers_svg,
                    'button_icon'   => $delete_svg,
                    'icon_class'    => 'sr-card__icon--woocommerce',
                    'counter_class' => 'sr-card__counter--woocommerce',
                    'action'        => 'sr_delete_wc_customers',
                    'nonce'         => 'sr_delete_wc_customers',
                    'button_text'   => 'Delete All Customers',
                    'note'          => '',
                    'hidden_fields' => [],
                ];
                include SR_PATH . 'templates/parts/reset-card.php';
                ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php include SR_PATH . 'templates/parts/reset-modal.php'; ?>

