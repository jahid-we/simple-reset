<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$deleted             = isset( $_GET['deleted'] ) ? sanitize_text_field( wp_unslash( $_GET['deleted'] ) ) : '';
$sr_enable_reset     = get_option( 'sr_enable_reset', '1' );
$allowed_ids_str     = get_option( 'sr_allowed_user_ids', '' );
$is_authorized       = true;

if ( ! empty( $allowed_ids_str ) ) {
    $allowed_ids = array_map( 'intval', array_filter( array_map( 'trim', explode( ',', $allowed_ids_str ) ) ) );
    $is_authorized = in_array( get_current_user_id(), $allowed_ids, true );
}

$GLOBALS['sr_disable_all_buttons'] = ( '1' !== $sr_enable_reset || ! $is_authorized );
$delete_svg = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>';
?>

<?php if ( '1' === $deleted ) : ?>
    <div class="sr-toast sr-toast--success" id="sr-toast">
        <span class="sr-toast__icon">✓</span>
        <span>Custom post type content deleted successfully.</span>
        <button class="sr-toast__close" onclick="this.parentElement.remove()">✕</button>
    </div>
<?php endif; ?>

<div class="sr-page-wrap">
    <div class="sr-page-header">
        <div class="sr-page-header__left">
            <div class="sr-page-header__icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2 2L5 6"/></svg>
            </div>
            <div>
                <h1 class="sr-page-header__title">Custom Post Types</h1>
                <p class="sr-page-header__subtitle">Permanently remove content created by registered custom post types.</p>
            </div>
        </div>
        <div class="sr-danger-badge">Destructive Actions</div>
    </div>

    <div class="sr-warning-banner">
        <p><strong>Warning:</strong> These deletions are permanent and irreversible. Please back up your database before proceeding.</p>
    </div>

    <?php if ( empty( $custom_post_types ) ) : ?>
        <div class="sr-dash-card" style="margin-top: 24px;">
            <div class="sr-dash-card__body" style="padding: 24px;">
                <p>No custom post types are currently registered.</p>
            </div>
        </div>
    <?php else : ?>
        <div class="sr-grid">
            <?php foreach ( $custom_post_types as $post_type => $post_type_object ) : ?>
                <?php
                $label       = ! empty( $post_type_object->labels->singular_name ) ? $post_type_object->labels->singular_name : $post_type;
                $description = ! empty( $post_type_object->description ) ? $post_type_object->description : sprintf( 'Permanently removes all %s content.', $label );
                $note        = '';

                if ( 'elementor_library' === $post_type ) {
                    $note = 'Elementor’s active Site Settings kit will be preserved.';
                }

                $card        = [
                    'type'          => $post_type,
                    'badge'         => $label,
                    'title'         => sprintf( 'Delete All %s', $label ),
                    'description'   => $description,
                    'count'         => $statistics->get_post_type_count( $post_type ),
                    'singular'      => strtolower( $label ),
                    'plural'        => strtolower( $label ),
                    'icon'          => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>',
                    'button_icon'   => $delete_svg,
                    'icon_class'    => 'sr-card__icon--red',
                    'counter_class' => 'sr-card__counter--red',
                    'action'        => 'sr_delete_cpt_' . $post_type,
                    'nonce'         => 'sr_delete_cpt_' . $post_type,
                    'button_text'   => sprintf( 'Delete All %s', $label ),
                    'note'          => $note,
                    'hidden_fields' => [],
                ];

                include SR_PATH . 'templates/parts/reset-card.php';
                ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require SR_PATH . 'templates/parts/reset-modal.php'; ?>
