<?php
// views/components/toggle.php

/**
 * Toggle switch component with label and help text.
 *
 * @var array $atts  Toggle attributes from ComponentRenderer::toggle().
 */

defined( 'ABSPATH' ) || exit;

$toggle_id = 'pw-toggle-' . sanitize_title( $atts['name'] );
?>

<div class="pw-flex pw-items-center pw-justify-between pw-gap-4 pw-mb-4 <?php echo esc_attr( $atts['class'] ); ?>">
    <div>
        <?php if ( ! empty( $atts['label'] ) ) : ?>
            <label for="<?php echo esc_attr( $toggle_id ); ?>" class="pw-text-sm pw-font-medium pw-text-surface-700 pw-cursor-pointer">
                <?php echo esc_html( $atts['label'] ); ?>
            </label>
        <?php endif; ?>

        <?php if ( ! empty( $atts['help'] ) ) : ?>
            <p class="pw-text-xs pw-text-surface-400 pw-mt-0.5 pw-m-0"><?php echo esc_html( $atts['help'] ); ?></p>
        <?php endif; ?>
    </div>

    <button
        type="button"
        role="switch"
        id="<?php echo esc_attr( $toggle_id ); ?>"
        aria-checked="<?php echo $atts['checked'] ? 'true' : 'false'; ?>"
        class="pw-bui-toggle pw-relative pw-inline-flex pw-h-6 pw-w-11 pw-shrink-0 pw-cursor-pointer pw-rounded-full pw-border-2 pw-border-transparent pw-transition-colors pw-duration-200 pw-ease-in-out focus:pw-outline-none focus:pw-ring-2 focus:pw-ring-brand-500 focus:pw-ring-offset-2 <?php echo $atts['checked'] ? 'pw-bg-brand-600' : 'pw-bg-surface-200'; ?> <?php echo $atts['disabled'] ? 'pw-opacity-50 pw-cursor-not-allowed' : ''; ?>"
        data-name="<?php echo esc_attr( $atts['name'] ); ?>"
        data-value="<?php echo esc_attr( $atts['value'] ); ?>"
        <?php echo $atts['disabled'] ? 'disabled' : ''; ?>
    >
        <span
            aria-hidden="true"
            class="pw-pointer-events-none pw-inline-block pw-h-5 pw-w-5 pw-transform pw-rounded-full pw-bg-white pw-shadow pw-ring-0 pw-transition pw-duration-200 pw-ease-in-out <?php echo $atts['checked'] ? 'pw-translate-x-5' : 'pw-translate-x-0'; ?>"
        ></span>
    </button>

    <input
        type="hidden"
        name="<?php echo esc_attr( $atts['name'] ); ?>"
        value="<?php echo $atts['checked'] ? esc_attr( $atts['value'] ) : ''; ?>"
    />
</div>
