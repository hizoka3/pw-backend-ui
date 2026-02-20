<?php
// views/components/link.php

/**
 * Link component.
 *
 * @var array $atts  Link attributes from ComponentRenderer::link().
 */

defined( 'ABSPATH' ) || exit;

$variant_classes = [
    'default' => 'pw-text-brand-600 hover:pw-text-brand-700',
    'muted'   => 'pw-text-surface-500 hover:pw-text-surface-700',
    'danger'  => 'pw-text-danger-500 hover:pw-text-danger-700',
];

$classes = 'pw-text-sm pw-font-medium pw-underline pw-underline-offset-2 pw-decoration-1 pw-transition-colors '
    . ( $variant_classes[ $atts['variant'] ] ?? $variant_classes['default'] ) . ' '
    . $atts['class'];
?>

<a
    href="<?php echo esc_url( $atts['href'] ); ?>"
    target="<?php echo esc_attr( $atts['target'] ); ?>"
    class="<?php echo esc_attr( $classes ); ?>"
    <?php echo $atts['target'] === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>
>
    <?php echo esc_html( $atts['label'] ); ?>
</a>
