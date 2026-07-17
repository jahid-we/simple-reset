<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="sr-card" data-type="<?php echo esc_attr( $card['type'] ); ?>">

    <div class="sr-card__header">

        <div class="sr-card__icon <?php echo esc_attr( $card['icon_class'] ); ?>">
            <?php echo $card['icon']; ?>
        </div>

        <span class="sr-card__badge">
            <?php echo esc_html( $card['badge'] ); ?>
        </span>

    </div>

    <div class="sr-card__body">

        <div class="sr-card__counter <?php echo esc_attr( $card['counter_class'] ); ?>">

            <span class="sr-card__counter-num">
                <?php echo number_format( $card['count'] ); ?>
            </span>

            <span class="sr-card__counter-label">
                <?php
                echo esc_html(
                    1 === $card['count']
                        ? $card['singular'] . ' found'
                        : $card['plural'] . ' found'
                );
                ?>
            </span>

        </div>

        <h3 class="sr-card__title">
            <?php echo esc_html( $card['title'] ); ?>
        </h3>

        <p class="sr-card__desc">
            <?php echo esc_html( $card['description'] ); ?>
        </p>

        <?php if ( ! empty( $card['note'] ) ) : ?>

            <div class="sr-card__note">
                <?php echo wp_kses_post( $card['note'] ); ?>
            </div>

        <?php endif; ?>

    </div>

    <div class="sr-card__footer">

        <form method="post">

            <?php
            wp_nonce_field(
                $card['nonce'],
                $card['nonce'] . '_nonce'
            );
            ?>

            <?php
            if ( ! empty( $card['hidden_fields'] ) ) :

                foreach ( $card['hidden_fields'] as $name => $value ) :
            ?>

                <input
                    type="hidden"
                    name="<?php echo esc_attr( $name ); ?>"
                    value="<?php echo esc_attr( $value ); ?>"
                >

            <?php
                endforeach;

            endif;
            ?>

            <button
                type="submit"
                name="<?php echo esc_attr( $card['action'] ); ?>"
                value="1"
                class="sr-btn sr-btn--danger sr-delete-trigger"
                <?php
                echo 0 === $card['count']
                    ? 'disabled title="Nothing to delete"'
                    : '';
                ?>
            >

                <?php echo $card['button_icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

                <?php
                echo esc_html(
                    0 === $card['count']
                        ? 'Nothing to Delete'
                        : $card['button_text']
                );
                ?>

            </button>

        </form>

    </div>

</div>