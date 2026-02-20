<?php
// views/components/checkbox.php

/**
 * Checkbox component with label and help text.
 *
 * @var array $atts  Checkbox attributes from ComponentRenderer::checkbox().
 */

defined( 'ABSPATH' ) || exit;

$checkbox_id = 'pw-checkbox-' . sanitize_title( $atts['name'] );
?>

<div class="pw-flex pw-items-start pw-gap-3 pw-mb-4 <?php echo esc_attr( $atts['class'] ); ?>">
    <input
        type="checkbox"
        id="<?php echo esc_attr( $checkbox_id ); ?>"
        name="<?php echo esc_attr( $atts['name'] ); ?>"
        value="<?php echo esc_attr( $atts['value'] ); ?>"
        class="pw-mt-0.5 pw-h-4 pw-w-4 pw-rounded pw-border-surface-300 pw-text-brand-600 focus:pw-ring-brand-500 focus:pw-ring-2"
        <?php checked( $atts['checked'] ); ?>
        <?php echo $atts['disabled'] ? 'disabled' : ''; ?>
    />

    <div>
        <?php if ( ! empty( $atts['label'] ) ) : ?>
            <label for="<?php echo esc_attr( $checkbox_id ); ?>" class="pw-text-sm pw-font-medium pw-text-surface-700 pw-cursor-pointer">
                <?php echo esc_html( $atts['label'] ); ?>
            </label>
        <?php endif; ?>

        <?php if ( ! empty( $atts['help'] ) ) : ?>
            <p class="pw-text-xs pw-text-surface-400 pw-mt-0.5 pw-m-0"><?php echo esc_html( $atts['help'] ); ?></p>
        <?php endif; ?>
    </div>
</div>
