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

    <!-- Content Overview -->
    <div class="sr-dash-section-label">Content Overview</div>
    <div class="sr-dash-stat-grid">

        <!-- Posts -->
        <div class="sr-dash-stat sr-dash-stat--red">
            <div class="sr-dash-stat__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <div class="sr-dash-stat__body">
                <span class="sr-dash-stat__num"><?php echo number_format( $counts['posts'] ); ?></span>
                <span class="sr-dash-stat__label">Posts</span>
            </div>
        </div>

        <!-- Pages -->
        <div class="sr-dash-stat sr-dash-stat--orange">
            <div class="sr-dash-stat__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div class="sr-dash-stat__body">
                <span class="sr-dash-stat__num"><?php echo number_format( $counts['pages'] ); ?></span>
                <span class="sr-dash-stat__label">Pages</span>
            </div>
        </div>

        <!-- Media -->
        <div class="sr-dash-stat sr-dash-stat--purple">
            <div class="sr-dash-stat__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
            <div class="sr-dash-stat__body">
                <span class="sr-dash-stat__num"><?php echo number_format( $counts['media'] ); ?></span>
                <span class="sr-dash-stat__label">Media Files</span>
            </div>
        </div>

        <!-- Comments -->
        <div class="sr-dash-stat sr-dash-stat--blue">
            <div class="sr-dash-stat__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="sr-dash-stat__body">
                <span class="sr-dash-stat__num"><?php echo number_format( $counts['comments'] ); ?></span>
                <span class="sr-dash-stat__label">Comments</span>
            </div>
        </div>

        <!-- Categories -->
        <div class="sr-dash-stat sr-dash-stat--teal">
            <div class="sr-dash-stat__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="sr-dash-stat__body">
                <span class="sr-dash-stat__num"><?php echo number_format( $counts['categories'] ); ?></span>
                <span class="sr-dash-stat__label">Categories</span>
            </div>
        </div>

        <!-- Tags -->
        <div class="sr-dash-stat sr-dash-stat--pink">
            <div class="sr-dash-stat__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            </div>
            <div class="sr-dash-stat__body">
                <span class="sr-dash-stat__num"><?php echo number_format( $counts['tags'] ); ?></span>
                <span class="sr-dash-stat__label">Tags</span>
            </div>
        </div>

        <!-- Users -->
        <div class="sr-dash-stat sr-dash-stat--indigo">
            <div class="sr-dash-stat__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div class="sr-dash-stat__body">
                <span class="sr-dash-stat__num"><?php echo number_format( $counts['users'] ); ?></span>
                <span class="sr-dash-stat__label">Users</span>
            </div>
        </div>

        <!-- Menus -->
        <div class="sr-dash-stat sr-dash-stat--emerald">
            <div class="sr-dash-stat__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="20" y2="18"/></svg>
            </div>
            <div class="sr-dash-stat__body">
                <span class="sr-dash-stat__num"><?php echo number_format( $counts['menus'] ); ?></span>
                <span class="sr-dash-stat__label">Menus</span>
            </div>
        </div>

    </div>

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
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=sr-about' ) ); ?>" class="sr-dash-action sr-dash-action--gray">
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