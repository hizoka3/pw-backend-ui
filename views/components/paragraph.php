<?php
// views/components/paragraph.php

/**
 * Paragraph component.
 *
 * @var array $atts  Paragraph attributes from ComponentRenderer::paragraph().
 */

defined( 'ABSPATH' ) || exit;

$variant_classes = [
    'default' => 'pw-text-sm pw-text-surface-700',
    'muted'   => 'pw-text-sm pw-text-surface-400',
    'small'   => 'pw-text-xs pw-text-surface-500',
];

$classes = 'pw-m-0 pw-leading-relaxed '
    . ( $variant_classes[ $atts['variant'] ] ?? $variant_classes['default'] ) . ' '
    . $atts['class'];
?>

<p class="<?php echo esc_attr( $classes ); ?>">
    <?php echo wp_kses_post( $atts['text'] ); ?>
</p>
