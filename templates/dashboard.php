<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// $counts injected by Admin::admin_page() via Statistics.
$total_items     = array_sum( array_map( 'intval', $counts ) );
$reset_tools_url = admin_url( 'admin.php?page=sr-reset-tools' );
$settings_url    = admin_url( 'admin.php?page=sr-settings' );
$wp_version      = get_bloginfo( 'version' );
$site_url        = home_url();

$is_wc_active = class_exists( 'WooCommerce' );
$wc_total = 0;
if ( $is_wc_active ) {
    $wc_total = (int) ( $counts['wc_products'] ?? 0 ) +
                (int) ( $counts['wc_coupons'] ?? 0 ) +
                (int) ( $counts['wc_product_categories'] ?? 0 ) +
                (int) ( $counts['wc_product_tags'] ?? 0 ) +
                (int) ( $counts['wc_product_attribute'] ?? 0 ) +
                (int) ( $counts['wc_orders'] ?? 0 ) +
                (int) ( $counts['wc_customers'] ?? 0 );
}

$core_total       = (int) $counts['posts'] + (int) $counts['pages'] + (int) $counts['media'] + (int) $counts['comments'] + (int) $counts['users'] + (int) $counts['menus'];
$system_total     = (int) $counts['revisions'] + (int) $counts['post_auto-draft'] + (int) $counts['page_auto-draft'] + (int) $counts['trashed'];
$taxonomies_total = (int) $counts['categories'] + (int) $counts['tags'] + (int) $counts['theme_mods'];
?>

<div class="sr-page-wrap">

    <!-- Page Header -->
    <div class="sr-page-header">
        <div class="sr-page-header__left">
            <div class="sr-page-header__icon" style="background: linear-gradient(135deg,#6366f1 0%,#4f46e5 100%); box-shadow:0 4px 14px rgba(99,102,241,.35);">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </div>
            <div>
                <h1 class="sr-page-header__title">Dashboard</h1>
                <p class="sr-page-header__subtitle">Overview of your WordPress site content and plugin status.</p>
            </div>
        </div>
        <div class="sr-dash-version-badge">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" style="margin-right:4px; vertical-align:middle;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            v<?php echo esc_html( SR_VERSION ); ?>
        </div>
    </div>

    <!-- Summary Metrics Bar -->
    <div class="sr-stats-bar">
        <div class="sr-stats-bar__item">
            <span class="sr-stats-bar__num sr-stats-bar__num--red"><?php echo number_format( $total_items ); ?></span>
            <span class="sr-stats-bar__label">Total Content</span>
        </div>
        <div class="sr-stats-bar__divider"></div>
        <div class="sr-stats-bar__item">
            <span class="sr-stats-bar__num sr-stats-bar__num--indigo"><?php echo number_format( $core_total ); ?></span>
            <span class="sr-stats-bar__label">Core Content</span>
        </div>
        <div class="sr-stats-bar__divider"></div>
        <div class="sr-stats-bar__item">
            <span class="sr-stats-bar__num sr-stats-bar__num--teal"><?php echo number_format( $taxonomies_total ); ?></span>
            <span class="sr-stats-bar__label">Taxonomies</span>
        </div>
        <div class="sr-stats-bar__divider"></div>
        <div class="sr-stats-bar__item">
            <span class="sr-stats-bar__num sr-stats-bar__num--amber"><?php echo number_format( $system_total ); ?></span>
            <span class="sr-stats-bar__label">Drafts &amp; Trash</span>
        </div>
        <?php if ( $is_wc_active ) : ?>
            <div class="sr-stats-bar__divider"></div>
            <div class="sr-stats-bar__item">
                <span class="sr-stats-bar__num" style="color:#7f54b3;"><?php echo number_format( $wc_total ); ?></span>
                <span class="sr-stats-bar__label">WooCommerce</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Filter Tabs -->
    <div class="sr-filter-tabs">
        <div class="sr-filter-tab active" data-group="all">
            All Overview <span class="sr-filter-tab__count"><?php echo number_format( $total_items ); ?></span>
        </div>
        <div class="sr-filter-tab" data-group="content">
            📝 Core Content <span class="sr-filter-tab__count"><?php echo number_format( $core_total ); ?></span>
        </div>
        <div class="sr-filter-tab" data-group="taxonomies">
            🏷️ Taxonomies &amp; Structure <span class="sr-filter-tab__count"><?php echo number_format( $taxonomies_total ); ?></span>
        </div>
        <div class="sr-filter-tab" data-group="system">
            🧹 System &amp; Maintenance <span class="sr-filter-tab__count"><?php echo number_format( $system_total ); ?></span>
        </div>
        <?php if ( $is_wc_active ) : ?>
            <div class="sr-filter-tab" data-group="woocommerce">
                🛒 WooCommerce <span class="sr-filter-tab__count"><?php echo number_format( $wc_total ); ?></span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Section 1: Core WordPress Content -->
    <div class="sr-section-block" data-group="content">
        <div class="sr-section-header">
            <div class="sr-section-header__title-wrap">
                <div class="sr-section-header__icon sr-section-header__icon--indigo">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <h2 class="sr-section-header__title">Core WordPress Content</h2>
            </div>
            <span class="sr-section-header__count"><?php echo number_format( $core_total ); ?> items</span>
        </div>

        <div class="sr-dash-stat-grid">
            <!-- Posts -->
            <div class="sr-dash-stat sr-dash-stat--red">
                <div class="sr-dash-stat__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <div class="sr-dash-stat__body">
                    <span class="sr-dash-stat__num"><?php echo number_format( $counts['posts'] ); ?></span>
                    <span class="sr-dash-stat__label">Posts</span>
                </div>
            </div>

            <!-- Pages -->
            <div class="sr-dash-stat sr-dash-stat--orange">
                <div class="sr-dash-stat__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                </div>
                <div class="sr-dash-stat__body">
                    <span class="sr-dash-stat__num"><?php echo number_format( $counts['pages'] ); ?></span>
                    <span class="sr-dash-stat__label">Pages</span>
                </div>
            </div>

            <!-- Media -->
            <div class="sr-dash-stat sr-dash-stat--purple">
                <div class="sr-dash-stat__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
                <div class="sr-dash-stat__body">
                    <span class="sr-dash-stat__num"><?php echo number_format( $counts['media'] ); ?></span>
                    <span class="sr-dash-stat__label">Media Files</span>
                </div>
            </div>

            <!-- Comments -->
            <div class="sr-dash-stat sr-dash-stat--blue">
                <div class="sr-dash-stat__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div class="sr-dash-stat__body">
                    <span class="sr-dash-stat__num"><?php echo number_format( $counts['comments'] ); ?></span>
                    <span class="sr-dash-stat__label">Comments</span>
                </div>
            </div>

            <!-- Users -->
            <div class="sr-dash-stat sr-dash-stat--indigo">
                <div class="sr-dash-stat__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="sr-dash-stat__body">
                    <span class="sr-dash-stat__num"><?php echo number_format( $counts['users'] ); ?></span>
                    <span class="sr-dash-stat__label">Users</span>
                </div>
            </div>

            <!-- Menus -->
            <div class="sr-dash-stat sr-dash-stat--emerald">
                <div class="sr-dash-stat__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </div>
                <div class="sr-dash-stat__body">
                    <span class="sr-dash-stat__num"><?php echo number_format( $counts['menus'] ); ?></span>
                    <span class="sr-dash-stat__label">Menus</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Taxonomies & Customizer -->
    <div class="sr-section-block" data-group="taxonomies">
        <div class="sr-section-header">
            <div class="sr-section-header__title-wrap">
                <div class="sr-section-header__icon sr-section-header__icon--teal">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                </div>
                <h2 class="sr-section-header__title">Taxonomies &amp; Structure</h2>
            </div>
            <span class="sr-section-header__count"><?php echo number_format( $taxonomies_total ); ?> items</span>
        </div>

        <div class="sr-dash-stat-grid">
            <!-- Categories -->
            <div class="sr-dash-stat sr-dash-stat--teal">
                <div class="sr-dash-stat__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div class="sr-dash-stat__body">
                    <span class="sr-dash-stat__num"><?php echo number_format( $counts['categories'] ); ?></span>
                    <span class="sr-dash-stat__label">Categories</span>
                </div>
            </div>

            <!-- Tags -->
            <div class="sr-dash-stat sr-dash-stat--pink">
                <div class="sr-dash-stat__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                </div>
                <div class="sr-dash-stat__body">
                    <span class="sr-dash-stat__num"><?php echo number_format( $counts['tags'] ); ?></span>
                    <span class="sr-dash-stat__label">Tags</span>
                </div>
            </div>

            <!-- Theme Customizer -->
            <div class="sr-dash-stat sr-dash-stat--blue">
                <div class="sr-dash-stat__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                </div>
                <div class="sr-dash-stat__body">
                    <span class="sr-dash-stat__num"><?php echo number_format( $counts['theme_mods'] ); ?></span>
                    <span class="sr-dash-stat__label">Customizer Settings</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: System & Maintenance -->
    <div class="sr-section-block" data-group="system">
        <div class="sr-section-header">
            <div class="sr-section-header__title-wrap">
                <div class="sr-section-header__icon sr-section-header__icon--rose">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                </div>
                <h2 class="sr-section-header__title">System &amp; Maintenance</h2>
            </div>
            <span class="sr-section-header__count"><?php echo number_format( $system_total ); ?> items</span>
        </div>

        <div class="sr-dash-stat-grid">
            <!-- Revisions -->
            <div class="sr-dash-stat sr-dash-stat--cyan">
                <div class="sr-dash-stat__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><polyline points="3 3 3 8 8 8"/><line x1="12" y1="7" x2="12" y2="12"/><line x1="12" y1="12" x2="16" y2="14"/></svg>
                </div>
                <div class="sr-dash-stat__body">
                    <span class="sr-dash-stat__num"><?php echo number_format( $counts['revisions'] ); ?></span>
                    <span class="sr-dash-stat__label">Revisions</span>
                </div>
            </div>

            <!-- Post Auto Drafts -->
            <div class="sr-dash-stat sr-dash-stat--amber">
                <div class="sr-dash-stat__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4z"/></svg>
                </div>
                <div class="sr-dash-stat__body">
                    <span class="sr-dash-stat__num"><?php echo number_format( $counts['post_auto-draft'] ); ?></span>
                    <span class="sr-dash-stat__label">Post Auto Drafts</span>
                </div>
            </div>

            <!-- Page Auto Drafts -->
            <div class="sr-dash-stat sr-dash-stat--fuchsia">
                <div class="sr-dash-stat__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polygon points="2 17 12 22 22 17"/><polygon points="2 12 12 17 22 12"/></svg>
                </div>
                <div class="sr-dash-stat__body">
                    <span class="sr-dash-stat__num"><?php echo number_format( $counts['page_auto-draft'] ); ?></span>
                    <span class="sr-dash-stat__label">Page Auto Drafts</span>
                </div>
            </div>

            <!-- Trashed Items -->
            <div class="sr-dash-stat sr-dash-stat--rose">
                <div class="sr-dash-stat__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                </div>
                <div class="sr-dash-stat__body">
                    <span class="sr-dash-stat__num"><?php echo number_format( $counts['trashed'] ); ?></span>
                    <span class="sr-dash-stat__label">Trashed Items</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 4: WooCommerce Store (If WooCommerce active) -->
    <?php if ( $is_wc_active ) : ?>
        <div class="sr-section-block" data-group="woocommerce">
            <div class="sr-section-header">
                <div class="sr-section-header__title-wrap">
                    <div class="sr-section-header__icon sr-section-header__icon--woo">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    </div>
                    <h2 class="sr-section-header__title">WooCommerce Store</h2>
                </div>
                <span class="sr-section-header__count"><?php echo number_format( $wc_total ); ?> items</span>
            </div>

            <div class="sr-dash-stat-grid">
                <!-- WC Products -->
                <div class="sr-dash-stat sr-dash-stat--woocommerce">
                    <div class="sr-dash-stat__icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V4H2v5a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V9"/><path d="M16 9V4h4v5a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2V9"/><path d="M10 15h4"/><path d="M4 20h16"/><path d="M10 12h4"/></svg>
                    </div>
                    <div class="sr-dash-stat__body">
                        <span class="sr-dash-stat__num"><?php echo number_format( $counts['wc_products'] ?? 0 ); ?></span>
                        <span class="sr-dash-stat__label">WC Products</span>
                    </div>
                </div>

                <!-- WC Coupons -->
                <div class="sr-dash-stat sr-dash-stat--woocommerce">
                    <div class="sr-dash-stat__icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12a2 2 0 0 1 0-4V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v2a2 2 0 0 1 0 4v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2a2 2 0 0 1 0-4z"/><line x1="9" y1="15" x2="15" y2="9"/></svg>
                    </div>
                    <div class="sr-dash-stat__body">
                        <span class="sr-dash-stat__num"><?php echo number_format( $counts['wc_coupons'] ?? 0 ); ?></span>
                        <span class="sr-dash-stat__label">WC Coupons</span>
                    </div>
                </div>

                <!-- WC Product Categories -->
                <div class="sr-dash-stat sr-dash-stat--woocommerce">
                    <div class="sr-dash-stat__icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z"/></svg>
                    </div>
                    <div class="sr-dash-stat__body">
                        <span class="sr-dash-stat__num"><?php echo number_format( $counts['wc_product_categories'] ?? 0 ); ?></span>
                        <span class="sr-dash-stat__label">Product Categories</span>
                    </div>
                </div>

                <!-- WC Product Tags -->
                <div class="sr-dash-stat sr-dash-stat--woocommerce">
                    <div class="sr-dash-stat__icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/></svg>
                    </div>
                    <div class="sr-dash-stat__body">
                        <span class="sr-dash-stat__num"><?php echo number_format( $counts['wc_product_tags'] ?? 0 ); ?></span>
                        <span class="sr-dash-stat__label">Product Tags</span>
                    </div>
                </div>

                <!-- WC Product Attributes -->
                <div class="sr-dash-stat sr-dash-stat--woocommerce">
                    <div class="sr-dash-stat__icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6a6 6 0 0 1 0 12"/><path d="M9 18a6 6 0 0 1 0-12"/></svg>
                    </div>
                    <div class="sr-dash-stat__body">
                        <span class="sr-dash-stat__num"><?php echo number_format( $counts['wc_product_attribute'] ?? 0 ); ?></span>
                        <span class="sr-dash-stat__label">Product Attributes</span>
                    </div>
                </div>

                <!-- WC Orders -->
                <div class="sr-dash-stat sr-dash-stat--woocommerce">
                    <div class="sr-dash-stat__icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                    </div>
                    <div class="sr-dash-stat__body">
                        <span class="sr-dash-stat__num"><?php echo number_format( $counts['wc_orders'] ?? 0 ); ?></span>
                        <span class="sr-dash-stat__label">WC Orders</span>
                    </div>
                </div>

                <!-- WC Customers -->
                <div class="sr-dash-stat sr-dash-stat--woocommerce">
                    <div class="sr-dash-stat__icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div class="sr-dash-stat__body">
                        <span class="sr-dash-stat__num"><?php echo number_format( $counts['wc_customers'] ?? 0 ); ?></span>
                        <span class="sr-dash-stat__label">WC Customers</span>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Two-column lower section -->
    <div class="sr-dash-lower">

        <!-- Quick Actions -->
        <div class="sr-dash-card">
            <div class="sr-dash-card__header">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                Quick Actions
            </div>
            <div class="sr-dash-card__body">
                <a href="<?php echo esc_url( $reset_tools_url ); ?>" class="sr-dash-action sr-dash-action--danger">
                    <div class="sr-dash-action__icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    </div>
                    <div class="sr-dash-action__text">
                        <strong>Reset Tools</strong>
                        <span>Delete posts, pages, media &amp; more</span>
                    </div>
                    <svg class="sr-dash-action__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
                <a href="<?php echo esc_url( $settings_url ); ?>" class="sr-dash-action sr-dash-action--indigo">
                    <div class="sr-dash-action__icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    </div>
                    <div class="sr-dash-action__text">
                        <strong>Settings</strong>
                        <span>Configure plugin options</span>
                    </div>
                    <svg class="sr-dash-action__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=sr-log' ) ); ?>" class="sr-dash-action sr-dash-action--purple">
                    <div class="sr-dash-action__icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 8v4l3 3"/>
                            <circle cx="12" cy="12" r="10"/>
                        </svg>
                    </div>
                    <div class="sr-dash-action__text">
                        <strong>Activity Logs</strong>
                        <span>View plugin activity history</span>
                    </div>
                    <svg class="sr-dash-action__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=sr-about' ) ); ?>" class="sr-dash-action sr-dash-action--emerald">
                    <div class="sr-dash-action__icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <div class="sr-dash-action__text">
                        <strong>About</strong>
                        <span>Plugin info &amp; documentation</span>
                    </div>
                    <svg class="sr-dash-action__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
        </div>

        <!-- System Info -->
        <div class="sr-dash-card">
            <div class="sr-dash-card__header">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                System Information
            </div>
            <div class="sr-dash-card__body">
                <div class="sr-dash-info-list">

                    <div class="sr-dash-info-row">
                        <span class="sr-dash-info-row__key">Plugin Name</span>
                        <span class="sr-dash-info-row__val"><?php echo esc_html( SR_NAME ); ?></span>
                    </div>

                    <div class="sr-dash-info-row">
                        <span class="sr-dash-info-row__key">Plugin Version</span>
                        <span class="sr-dash-info-row__val sr-dash-info-row__val--badge sr-dash-info-row__val--red"><?php echo esc_html( SR_VERSION ); ?></span>
                    </div>

                    <div class="sr-dash-info-row">
                        <span class="sr-dash-info-row__key">WordPress Version</span>
                        <span class="sr-dash-info-row__val sr-dash-info-row__val--badge sr-dash-info-row__val--blue"><?php echo esc_html( $wp_version ); ?></span>
                    </div>

                    <div class="sr-dash-info-row">
                        <span class="sr-dash-info-row__key">PHP Version</span>
                        <span class="sr-dash-info-row__val sr-dash-info-row__val--badge sr-dash-info-row__val--purple"><?php echo esc_html( PHP_VERSION ); ?></span>
                    </div>

                    <div class="sr-dash-info-row">
                        <span class="sr-dash-info-row__key">Site URL</span>
                        <a href="<?php echo esc_url( $site_url ); ?>" target="_blank" class="sr-dash-info-row__val sr-dash-info-row__val--link">
                            <?php echo esc_html( $site_url ); ?>
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:2px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        </a>
                    </div>

                    <div class="sr-dash-info-row">
                        <span class="sr-dash-info-row__key">Total Content Items</span>
                        <span class="sr-dash-info-row__val sr-dash-info-row__val--badge sr-dash-info-row__val--red"><?php echo number_format( $total_items ); ?></span>
                    </div>

                </div>
            </div>
        </div>

    </div><!-- .sr-dash-lower -->

</div><!-- .sr-page-wrap -->
