<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Fetch current values
$sr_enable_reset      = get_option( 'sr_enable_reset', '1' );
$sr_require_backup     = get_option( 'sr_require_backup', '0' );
$sr_email_alert        = get_option( 'sr_email_alert', '0' );
$sr_allowed_user_ids   = get_option( 'sr_allowed_user_ids', '' );
$sr_warning_message    = get_option( 'sr_warning_message', '' );
?>

<div class="sr-page-wrap">

    <!-- Page Header -->
    <div class="sr-page-header">
        <div class="sr-page-header__left">
            <div class="sr-page-header__icon" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); box-shadow: 0 4px 14px rgba(99,102,241,.35);">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            </div>
            <div>
                <h1 class="sr-page-header__title">Simple Reset Settings</h1>
                <p class="sr-page-header__subtitle">Manage plugin security options, access restrictions, and alert protocols.</p>
            </div>
        </div>
        <div class="sr-dash-version-badge">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" style="margin-right:4px; vertical-align:middle;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            v<?php echo esc_html( SR_VERSION ); ?>
        </div>
    </div>

    <!-- Success Toast on Options Saved -->
    <?php if ( isset( $_GET['settings-updated'] ) && 'true' === $_GET['settings-updated'] ) : ?>
    <div class="sr-toast sr-toast--success" id="sr-toast" style="margin-top: 20px;">
        <span class="sr-toast__icon">✓</span>
        <span>Settings successfully updated.</span>
        <button class="sr-toast__close" onclick="this.parentElement.remove()">✕</button>
    </div>
    <?php endif; ?>

    <form method="post" action="options.php" style="margin-top: 24px;">
        <?php settings_fields( 'sr_settings_group' ); ?>

        <!-- Two-column settings configuration layout -->
        <div class="sr-dash-lower">

            <!-- Card 1: Safety & Access Controls -->
            <div class="sr-dash-card">
                <div class="sr-dash-card__header">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Safety &amp; Access Control
                </div>
                <div class="sr-dash-card__body" style="padding: 24px; gap: 20px;">

                    <!-- Enable Reset globally -->
                    <div style="display: flex; flex-direction: column; gap: 6px; border-bottom: 1px solid var(--sr-border); padding-bottom: 18px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input
                                type="checkbox"
                                name="sr_enable_reset"
                                id="sr_enable_reset"
                                value="1"
                                <?php checked( $sr_enable_reset, '1' ); ?>
                                style="width: 16px; height: 16px; margin: 0; cursor: pointer;"
                            >
                            <label for="sr_enable_reset" style="font-weight: 700; color: var(--sr-text); font-size: 14px; cursor: pointer;">Enable Reset Tools Globally</label>
                        </div>
                        <span style="font-size: 12.5px; color: var(--sr-muted); line-height: 1.5;">If unchecked, all database deletion buttons on the Reset Tools page are locked/disabled.</span>
                    </div>

                    <!-- Allowed User IDs -->
                    <div style="display: flex; flex-direction: column; gap: 6px; border-bottom: 1px solid var(--sr-border); padding-bottom: 18px;">
                        <label for="sr_allowed_user_ids" style="font-weight: 700; color: var(--sr-text); font-size: 14px;">Restrict by User ID</label>
                        <input
                            type="text"
                            name="sr_allowed_user_ids"
                            id="sr_allowed_user_ids"
                            value="<?php echo esc_attr( $sr_allowed_user_ids ); ?>"
                            placeholder="e.g. 1, 3, 5"
                            style="width: 100%; height: 38px; border: 1px solid var(--sr-border); border-radius: var(--sr-radius-sm); padding: 0 12px; font-size: 13.5px; color: var(--sr-text); outline: none; box-sizing: border-box;"
                        >
                        <span style="font-size: 12.5px; color: var(--sr-muted); line-height: 1.5;">Enter comma-separated administrator user IDs allowed to run reset actions. Leave blank to allow all administrators.</span>
                    </div>

                    <!-- Database backup requirement toggle -->
                    <div style="display: flex; flex-direction: column; gap: 6px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input
                                type="checkbox"
                                name="sr_require_backup"
                                id="sr_require_backup"
                                value="1"
                                <?php checked( $sr_require_backup, '1' ); ?>
                                style="width: 16px; height: 16px; margin: 0; cursor: pointer;"
                            >
                            <label for="sr_require_backup" style="font-weight: 700; color: var(--sr-text); font-size: 14px; cursor: pointer;">Require Backup Confirmation</label>
                        </div>
                        <span style="font-size: 12.5px; color: var(--sr-muted); line-height: 1.5;">Force executing admins to verify they have backed up the database before the confirm deletion button is enabled.</span>
                    </div>

                </div>
            </div>

            <!-- Card 2: UI Banners & Alerts -->
            <div class="sr-dash-card">
                <div class="sr-dash-card__header">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    Banners &amp; Alerts
                </div>
                <div class="sr-dash-card__body" style="padding: 24px; gap: 20px;">

                    <!-- Warning Message banner customized text -->
                    <div style="display: flex; flex-direction: column; gap: 6px; border-bottom: 1px solid var(--sr-border); padding-bottom: 18px;">
                        <label for="sr_warning_message" style="font-weight: 700; color: var(--sr-text); font-size: 14px;">Custom Warning Banner Message</label>
                        <textarea
                            name="sr_warning_message"
                            id="sr_warning_message"
                            rows="3"
                            placeholder="All deletions below are permanent and irreversible..."
                            style="width: 100%; border: 1px solid var(--sr-border); border-radius: var(--sr-radius-sm); padding: 10px 12px; font-size: 13.5px; color: var(--sr-text); outline: none; box-sizing: border-box; resize: vertical; line-height: 1.5;"
                        ><?php echo esc_textarea( $sr_warning_message ); ?></textarea>
                        <span style="font-size: 12.5px; color: var(--sr-muted); line-height: 1.5;">Displays a warning message inside the warning alert banner on the tools page. Leave blank for default message.</span>
                    </div>

                    <!-- Email Alert on Cleanup -->
                    <div style="display: flex; flex-direction: column; gap: 6px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input
                                type="checkbox"
                                name="sr_email_alert"
                                id="sr_email_alert"
                                value="1"
                                <?php checked( $sr_email_alert, '1' ); ?>
                                style="width: 16px; height: 16px; margin: 0; cursor: pointer;"
                            >
                            <label for="sr_email_alert" style="font-weight: 700; color: var(--sr-text); font-size: 14px; cursor: pointer;">Email Alerts on Cleanup</label>
                        </div>
                        <span style="font-size: 12.5px; color: var(--sr-muted); line-height: 1.5;">Sends a security email notification to the site admin whenever a reset/deletion action occurs.</span>
                    </div>

                </div>
            </div>

        </div>

        <!-- Submit Button Row -->
        <div style="margin-top: 28px;">
            <button
                type="submit"
                class="sr-btn"
                style="width: auto; padding: 12px 36px; background: linear-gradient(135deg,#6366f1 0%,#4f46e5 100%); color: #fff; border-radius: var(--sr-radius-sm); border: none; font-size: 14px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 14px rgba(99,102,241,.35); transition: opacity var(--sr-transition);"
                onmouseover="this.style.opacity='0.9'"
                onmouseout="this.style.opacity='1'"
            >
                Save Option Settings
            </button>
        </div>

    </form>

</div>