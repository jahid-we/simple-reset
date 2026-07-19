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
                <p class="sr-page-header__subtitle">Safe, swift, and lightweight WordPress cleanup tool.</p>
            </div>
        </div>
        <div class="sr-dash-version-badge">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" style="margin-right:4px; vertical-align:middle;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            v<?php echo esc_html( SR_VERSION ); ?>
        </div>
    </div>

    <!-- Hero Card Section -->
    <div class="sr-dash-card" style="margin-top: 24px; background: linear-gradient(145deg, #ffffff, #fcfdfe); border: 1px solid var(--sr-border); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(16, 185, 129, 0.03); border-radius: 50%; pointer-events: none;"></div>
        <div class="sr-dash-card__body" style="padding: 32px; gap: 16px;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 800; color: var(--sr-text); letter-spacing: -0.5px;">Supercharge Your WordPress Development</h2>
            <p style="margin: 0; font-size: 14.5px; color: var(--sr-text); line-height: 1.6; max-width: 800px;">
                <strong>Simple Reset</strong> is a lightweight, high-performance database utility tailored for developers, theme designers, and QA engineers. Instead of manually cleaning up database tables or running custom SQL scripts, Simple Reset provides a clean, single-click interface to selectively purge specific WordPress contents instantly.
            </p>
        </div>
    </div>

    <!-- Features & Info Grid -->
    <div class="sr-dash-lower" style="margin-top: 24px;">
        
        <!-- Key Features -->
        <div class="sr-dash-card">
            <div class="sr-dash-card__header">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Core Cleanup Actions
            </div>
            <div class="sr-dash-card__body" style="padding: 20px 24px 24px;">
                <ul style="margin: 0; padding: 0; list-style: none; display: flex; flex-direction: column; gap: 12px;">
                    <li style="display: flex; align-items: flex-start; gap: 10px;">
                        <span style="color: var(--sr-emerald); font-weight: bold; margin-top: 2px;">✓</span>
                        <div style="font-size: 13.5px; line-height: 1.5; color: var(--sr-text);">
                            <strong>Posts &amp; Pages Draft Purge:</strong> Easily clean up auto-draft posts and pages separately without wiping active posts.
                        </div>
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 10px;">
                        <span style="color: var(--sr-emerald); font-weight: bold; margin-top: 2px;">✓</span>
                        <div style="font-size: 13.5px; line-height: 1.5; color: var(--sr-text);">
                            <strong>Selective Deletions:</strong> Delete only what you want—attachments, tags, categories, navigation menus, or revisions.
                        </div>
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 10px;">
                        <span style="color: var(--sr-emerald); font-weight: bold; margin-top: 2px;">✓</span>
                        <div style="font-size: 13.5px; line-height: 1.5; color: var(--sr-text);">
                            <strong>Trash Cleaner:</strong> Instantly empty all trashed content across all custom and standard post types.
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Safety Features -->
        <div class="sr-dash-card">
            <div class="sr-dash-card__header">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Safety &amp; Protection Built-in
            </div>
            <div class="sr-dash-card__body" style="padding: 20px 24px 24px;">
                <ul style="margin: 0; padding: 0; list-style: none; display: flex; flex-direction: column; gap: 12px;">
                    <li style="display: flex; align-items: flex-start; gap: 10px;">
                        <span style="color: var(--sr-red); font-weight: bold; margin-top: 2px;">🛡️</span>
                        <div style="font-size: 13.5px; line-height: 1.5; color: var(--sr-text);">
                            <strong>Admin Protection:</strong> The active logged-in administrator account is fully protected and cannot be deleted.
                        </div>
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 10px;">
                        <span style="color: var(--sr-red); font-weight: bold; margin-top: 2px;">🛡️</span>
                        <div style="font-size: 13.5px; line-height: 1.5; color: var(--sr-text);">
                            <strong>Default Category Protection:</strong> Your default post category is preserved automatically to avoid database integrity issues.
                        </div>
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 10px;">
                        <span style="color: var(--sr-red); font-weight: bold; margin-top: 2px;">🛡️</span>
                        <div style="font-size: 13.5px; line-height: 1.5; color: var(--sr-text);">
                            <strong>Security Confirmation:</strong> To prevent accidental clicks, destructive operations require typing "DELETE" as confirmation.
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>

    <!-- Developer Notes / Credits -->
    <div class="sr-dash-card" style="margin-top: 24px; border: 1px solid var(--sr-border);">
        <div class="sr-dash-card__header">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            System &amp; Support Info
        </div>
        <div class="sr-dash-card__body" style="padding: 24px; gap: 12px; font-size: 13.5px; line-height: 1.6; color: var(--sr-muted);">
            <p style="margin: 0; color: var(--sr-text);">
                Designed and maintained for optimal performance. Simple Reset works natively with standard WordPress API hooks ensuring full compatibility with database engines and caching systems.
            </p>
            <p style="margin: 0;">
                For any feedback, issues, or suggestions, please contact your plugin administrator or visit the support pages.
            </p>
        </div>
    </div>

</div>
