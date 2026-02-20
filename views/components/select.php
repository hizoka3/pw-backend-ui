<?php
// views/components/select.php

/**
 * Select dropdown component with label, help text, and error state.
 *
 * @var array $atts  Select attributes from ComponentRenderer::select().
 */

defined( 'ABSPATH' ) || exit;

$has_error    = ! empty( $atts['error'] );
$select_id    = 'pw-select-' . sanitize_title( $atts['name'] );
$select_class = 'pw-block pw-w-full pw-rounded-lg pw-border pw-px-3 pw-py-2 pw-text-sm pw-text-surface-800 pw-bg-white pw-shadow-sm pw-transition-colors pw-appearance-none focus:pw-outline-none focus:pw-ring-2 focus:pw-ring-offset-0 disabled:pw-bg-surface-50 disabled:pw-text-surface-400';

$select_class .= $has_error
    ? ' pw-border-danger-500 focus:pw-ring-danger-500'
    : ' pw-border-surface-300 focus:pw-ring-brand-500 focus:pw-border-brand-500';

$select_class .= ' ' . $atts['class'];

// Normalize options to [ 'value' => '', 'label' => '' ] format
$normalized_options = [];
foreach ( $atts['options'] as $key => $option ) {
    if ( is_array( $option ) ) {
        $normalized_options[] = $option;
    } else {
        $normalized_options[] = [ 'value' => $key, 'label' => $option ];
    }
}
?>

<div class="pw-space-y-1.5 pw-mb-4">
    <?php if ( ! empty( $atts['label'] ) ) : ?>
        <label for="<?php echo esc_attr( $select_id ); ?>" class="pw-block pw-text-sm pw-font-medium pw-text-surface-700">
            <?php echo esc_html( $atts['label'] ); ?>
            <?php if ( $atts['required'] ) : ?>
                <span class="pw-text-danger-500">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <select
        id="<?php echo esc_attr( $select_id ); ?>"
        name="<?php echo esc_attr( $atts['name'] ); ?>"
        class="<?php echo esc_attr( $select_class ); ?>"
        <?php echo $atts['required'] ? 'required' : ''; ?>
        <?php echo $atts['disabled'] ? 'disabled' : ''; ?>
    >
        <?php if ( ! empty( $atts['placeholder'] ) ) : ?>
            <option value=""><?php echo esc_html( $atts['placeholder'] ); ?></option>
        <?php endif; ?>

        <?php foreach ( $normalized_options as $option ) : ?>
            <option
                value="<?php echo esc_attr( $option['value'] ); ?>"
                <?php selected( $atts['value'], $option['value'] ); ?>
            >
                <?php echo esc_html( $option['label'] ); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php if ( $has_error ) : ?>
        <p class="pw-text-xs pw-text-danger-500 pw-mt-1 pw-m-0"><?php echo esc_html( $atts['error'] ); ?></p>
    <?php elseif ( ! empty( $atts['help'] ) ) : ?>
        <p class="pw-text-xs pw-text-surface-400 pw-mt-1 pw-m-0"><?php echo esc_html( $atts['help'] ); ?></p>
    <?php endif; ?>
</div>
