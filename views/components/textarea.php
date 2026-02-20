<?php
// views/components/textarea.php

/**
 * Textarea component with label, help text, and error state.
 *
 * @var array $atts  Textarea attributes from ComponentRenderer::textarea().
 */

defined( 'ABSPATH' ) || exit;

$has_error      = ! empty( $atts['error'] );
$textarea_id    = 'pw-textarea-' . sanitize_title( $atts['name'] );
$textarea_class = 'pw-block pw-w-full pw-rounded-lg pw-border pw-px-3 pw-py-2 pw-text-sm pw-text-surface-800 pw-bg-white pw-shadow-sm pw-transition-colors pw-resize-y placeholder:pw-text-surface-400 focus:pw-outline-none focus:pw-ring-2 focus:pw-ring-offset-0 disabled:pw-bg-surface-50 disabled:pw-text-surface-400';

$textarea_class .= $has_error
    ? ' pw-border-danger-500 focus:pw-ring-danger-500'
    : ' pw-border-surface-300 focus:pw-ring-brand-500 focus:pw-border-brand-500';

$textarea_class .= ' ' . $atts['class'];
?>

<div class="pw-space-y-1.5 pw-mb-4">
    <?php if ( ! empty( $atts['label'] ) ) : ?>
        <label for="<?php echo esc_attr( $textarea_id ); ?>" class="pw-block pw-text-sm pw-font-medium pw-text-surface-700">
            <?php echo esc_html( $atts['label'] ); ?>
            <?php if ( $atts['required'] ) : ?>
                <span class="pw-text-danger-500">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <textarea
        id="<?php echo esc_attr( $textarea_id ); ?>"
        name="<?php echo esc_attr( $atts['name'] ); ?>"
        placeholder="<?php echo esc_attr( $atts['placeholder'] ); ?>"
        rows="<?php echo esc_attr( $atts['rows'] ); ?>"
        class="<?php echo esc_attr( $textarea_class ); ?>"
        <?php echo $atts['required'] ? 'required' : ''; ?>
        <?php echo $atts['disabled'] ? 'disabled' : ''; ?>
    ><?php echo esc_textarea( $atts['value'] ); ?></textarea>

    <?php if ( $has_error ) : ?>
        <p class="pw-text-xs pw-text-danger-500 pw-mt-1 pw-m-0"><?php echo esc_html( $atts['error'] ); ?></p>
    <?php elseif ( ! empty( $atts['help'] ) ) : ?>
        <p class="pw-text-xs pw-text-surface-400 pw-mt-1 pw-m-0"><?php echo esc_html( $atts['help'] ); ?></p>
    <?php endif; ?>
</div>
