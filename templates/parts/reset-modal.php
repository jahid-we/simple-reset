<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$require_backup = get_option( 'sr_require_backup', '0' );
?>

<div id="sr-modal" class="sr-modal" role="dialog" aria-modal="true" aria-labelledby="sr-modal-title">
    <div class="sr-modal-box">
        <div class="sr-modal-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <h2 id="sr-modal-title" class="sr-modal-title">Confirm Permanent Deletion</h2>
        <p class="sr-modal-desc">This action is <strong>irreversible</strong>. The selected content will be permanently erased from your database.</p>
        <div class="sr-modal-input-wrap">
            <label for="sr-confirm-input" class="sr-modal-label">Type <strong>DELETE</strong> to confirm</label>
            <input type="text" id="sr-confirm-input" class="sr-modal-input" placeholder="DELETE" autocomplete="off" spellcheck="false">
        </div>
        <?php if ( '1' === $require_backup ) : ?>
            <label class="sr-modal-backup-confirmation">
                <input type="checkbox" id="sr-backup-confirmation" value="1">
                <span>I confirm that I have backed up the database.</span>
            </label>
        <?php endif; ?>
        <div class="sr-modal-buttons">
            <button type="button" id="sr-modal-cancel" class="sr-btn sr-btn--ghost">Cancel</button>
            <button type="button" id="sr-modal-confirm" class="sr-btn sr-btn--danger" disabled>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2 2L5 6"/></svg>
                Delete Permanently
            </button>
        </div>
    </div>
</div>
