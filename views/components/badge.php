<?php
// views/components/badge.php

/**
 * Badge/Tag component.
 *
 * @var array $atts  Badge attributes from ComponentRenderer::badge().
 */

defined( 'ABSPATH' ) || exit;

$variant_classes = [
    'default' => 'pw-bg-surface-100 pw-text-surface-700',
    'primary' => 'pw-bg-brand-100 pw-text-brand-700',
    'success' => 'pw-bg-success-50 pw-text-success-700',
    'warning' => 'pw-bg-warning-50 pw-text-warning-700',
    'danger'  => 'pw-bg-danger-50 pw-text-danger-700',
];

$size_classes = [
    'sm' => 'pw-px-2 pw-py-0.5 pw-text-xs',
    'md' => 'pw-px-2.5 pw-py-1 pw-text-xs',
];

$classes = 'pw-inline-flex pw-items-center pw-font-medium pw-rounded-full '
    . ( $variant_classes[ $atts['variant'] ] ?? $variant_classes['default'] ) . ' '
    . ( $size_classes[ $atts['size'] ] ?? $size_classes['md'] ) . ' '
    . $atts['class'];
?>

<span class="<?php echo esc_attr( $classes ); ?>">
    <?php echo esc_html( $atts['label'] ); ?>
</span>
