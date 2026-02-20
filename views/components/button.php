<?php
// views/components/button.php

/**
 * Button component.
 *
 * @var array $atts  Button attributes from ComponentRenderer::button().
 */

defined( 'ABSPATH' ) || exit;

$variant_classes = [
    'primary'   => 'pw-bg-brand-600 pw-text-white hover:pw-bg-brand-700 focus:pw-ring-brand-500',
    'secondary' => 'pw-bg-surface-100 pw-text-surface-700 hover:pw-bg-surface-200 focus:pw-ring-surface-400',
    'outline'   => 'pw-border pw-border-surface-300 pw-text-surface-700 pw-bg-white hover:pw-bg-surface-50 focus:pw-ring-brand-500',
    'ghost'     => 'pw-text-surface-600 hover:pw-bg-surface-100 hover:pw-text-surface-800 focus:pw-ring-surface-400',
    'danger'    => 'pw-bg-danger-500 pw-text-white hover:pw-bg-danger-700 focus:pw-ring-danger-500',
];

$size_classes = [
    'sm' => 'pw-px-3 pw-py-1.5 pw-text-xs',
    'md' => 'pw-px-4 pw-py-2 pw-text-sm',
    'lg' => 'pw-px-6 pw-py-3 pw-text-base',
];

$base_classes = 'pw-inline-flex pw-items-center pw-gap-2 pw-font-medium pw-rounded-lg pw-transition-colors pw-duration-150 pw-cursor-pointer focus:pw-outline-none focus:pw-ring-2 focus:pw-ring-offset-2 disabled:pw-opacity-50 disabled:pw-cursor-not-allowed pw-border-0';

$classes = implode( ' ', [
    $base_classes,
    $variant_classes[ $atts['variant'] ] ?? $variant_classes['primary'],
    $size_classes[ $atts['size'] ] ?? $size_classes['md'],
    $atts['class'],
]);

$extra_attrs = '';
foreach ( $atts['attrs'] as $key => $val ) {
    $extra_attrs .= ' ' . esc_attr( $key ) . '="' . esc_attr( $val ) . '"';
}
?>

<button
    type="<?php echo esc_attr( $atts['type'] ); ?>"
    class="<?php echo esc_attr( $classes ); ?>"
    <?php echo $atts['disabled'] ? 'disabled' : ''; ?>
    <?php echo $extra_attrs; ?>
>
    <?php if ( ! empty( $atts['icon'] ) ) : ?>
        <span class="pw-flex pw-shrink-0"><?php echo $atts['icon']; ?></span>
    <?php endif; ?>
    <?php echo esc_html( $atts['label'] ); ?>
</button>
