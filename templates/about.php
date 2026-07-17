<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="sr-page-wrap">

    <!-- Page Header -->
    <div class="sr-page-header">
        <div class="sr-page-header__left">
            <div class="sr-page-header__icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 14px rgba(16,185,129,.35);">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            </div>
            <div>
                <h1 class="sr-page-header__title">About Simple Reset</h1>
                <p class="sr-page-header__subtitle">Learn more about the plugin and its features.</p>
            </div>
        </div>
        <div class="sr-dash-version-badge">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" style="margin-right:4px; vertical-align:middle;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            v<?php echo esc_html( SR_VERSION ); ?>
        </div>
    </div>

    <!-- About Content Grid -->
    <div class="sr-dash-lower" style="margin-top: 28px;">
        
        <!-- Description -->
        <div class="sr-dash-card">
            <div class="sr-dash-card__header">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                Plugin Description
            </div>
            <div class="sr-dash-card__body">
                <p style="margin-top: 0; font-size: 14.5px; color: var(--sr-text); line-height: 1.6;">
                    <strong>Simple Reset</strong> is a powerful and lightweight tool designed for WordPress developers and site administrators. It provides a clean, modern interface to quickly and permanently delete various types of content from your database.
                </p>
                <p style="margin-bottom: 0; font-size: 14.5px; color: var(--sr-text); line-height: 1.6;">
                    Whether you are developing a new site, testing themes and plugins, or just doing a fresh start, Simple Reset helps you remove posts, pages, custom post types, users, menus, and more with just a few clicks. It is built to be fast, secure, and user-friendly.
                </p>
            </div>
        </div>

        <!-- Features -->
        <div class="sr-dash-card">
            <div class="sr-dash-card__header">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Key Features
            </div>
            <div class="sr-dash-card__body">
                <ul style="margin: 0; padding-left: 20px; list-style-type: disc; color: var(--sr-text); font-size: 14px; line-height: 1.8;">
                    <li><strong>One-Click Deletions:</strong> Swiftly remove all posts, pages, or comments.</li>
                    <li><strong>Selective Reset:</strong> Only delete what you need (e.g., just media or tags).</li>
                    <li><strong>Safety First:</strong> Current user and default categories are protected.</li>
                    <li><strong>Modern Dashboard:</strong> Beautiful UI with instant statistics summary.</li>
                    <li><strong>Lightweight:</strong> Zero bloat, fast execution, no heavy dependencies.</li>
                </ul>
            </div>
        </div>

    </div>

</div>
