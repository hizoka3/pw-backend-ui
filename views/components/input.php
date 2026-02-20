<?php
// views/components/input.php

/**
 * Text input component with label, help text, and error state.
 *
 * @var array $atts  Input attributes from ComponentRenderer::input().
 */

defined( 'ABSPATH' ) || exit;

$has_error   = ! empty( $atts['error'] );
$input_id    = 'pw-input-' . sanitize_title( $atts['name'] );
$input_class = 'pw-block pw-w-full pw-rounded-lg pw-border pw-px-3 pw-py-2 pw-text-sm pw-text-surface-800 pw-bg-white pw-shadow-sm pw-transition-colors placeholder:pw-text-surface-400 focus:pw-outline-none focus:pw-ring-2 focus:pw-ring-offset-0 disabled:pw-bg-surface-50 disabled:pw-text-surface-400';

$input_class .= $has_error
    ? ' pw-border-danger-500 focus:pw-ring-danger-500'
    : ' pw-border-surface-300 focus:pw-ring-brand-500 focus:pw-border-brand-500';

$input_class .= ' ' . $atts['class'];
?>

<div class="pw-space-y-1.5 pw-mb-4">
    <?php if ( ! empty( $atts['label'] ) ) : ?>
        <label for="<?php echo esc_attr( $input_id ); ?>" class="pw-block pw-text-sm pw-font-medium pw-text-surface-700">
            <?php echo esc_html( $atts['label'] ); ?>
            <?php if ( $atts['required'] ) : ?>
                <span class="pw-text-danger-500">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <input
        type="<?php echo esc_attr( $atts['type'] ); ?>"
        id="<?php echo esc_attr( $input_id ); ?>"
        name="<?php echo esc_attr( $atts['name'] ); ?>"
        value="<?php echo esc_attr( $atts['value'] ); ?>"
        placeholder="<?php echo esc_attr( $atts['placeholder'] ); ?>"
        class="<?php echo esc_attr( $input_class ); ?>"
        <?php echo $atts['required'] ? 'required' : ''; ?>
        <?php echo $atts['disabled'] ? 'disabled' : ''; ?>
    />

    <?php if ( $has_error ) : ?>
        <p class="pw-text-xs pw-text-danger-500 pw-mt-1 pw-m-0"><?php echo esc_html( $atts['error'] ); ?></p>
    <?php elseif ( ! empty( $atts['help'] ) ) : ?>
        <p class="pw-text-xs pw-text-surface-400 pw-mt-1 pw-m-0"><?php echo esc_html( $atts['help'] ); ?></p>
    <?php endif; ?>
</div>
