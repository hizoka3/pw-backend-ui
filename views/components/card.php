<?php
// views/components/card.php

/**
 * Card container component.
 *
 * @var array $atts  Card attributes from ComponentRenderer::card().
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="pw-bg-white pw-rounded-xl pw-border pw-border-surface-200 pw-shadow-sm pw-overflow-hidden <?php echo esc_attr( $atts['class'] ); ?>">
    <?php if ( ! empty( $atts['title'] ) || ! empty( $atts['description'] ) ) : ?>
        <div class="pw-px-6 pw-py-4 pw-border-b pw-border-surface-100">
            <?php if ( ! empty( $atts['title'] ) ) : ?>
                <h3 class="pw-text-base pw-font-semibold pw-text-surface-900 pw-m-0">
                    <?php echo esc_html( $atts['title'] ); ?>
                </h3>
            <?php endif; ?>
            <?php if ( ! empty( $atts['description'] ) ) : ?>
                <p class="pw-text-sm pw-text-surface-500 pw-mt-1 pw-m-0">
                    <?php echo esc_html( $atts['description'] ); ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="<?php echo $atts['padded'] ? 'pw-px-6 pw-py-4' : ''; ?>">
        <?php
        if ( is_callable( $atts['content'] ) ) {
            call_user_func( $atts['content'] );
        }
        ?>
    </div>

    <?php if ( is_callable( $atts['footer'] ) ) : ?>
        <div class="pw-px-6 pw-py-3 pw-bg-surface-50 pw-border-t pw-border-surface-100">
            <?php call_user_func( $atts['footer'] ); ?>
        </div>
    <?php endif; ?>
</div>
