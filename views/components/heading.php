<?php
// views/components/heading.php

/**
 * Heading component (h1-h6).
 *
 * @var array $atts  Heading attributes from ComponentRenderer::heading().
 */

defined( 'ABSPATH' ) || exit;

$level = max( 1, min( 6, (int) $atts['level'] ) );
$tag   = 'h' . $level;

$level_classes = [
    1 => 'pw-text-2xl pw-font-bold',
    2 => 'pw-text-xl pw-font-semibold',
    3 => 'pw-text-lg pw-font-semibold',
    4 => 'pw-text-base pw-font-semibold',
    5 => 'pw-text-sm pw-font-medium',
    6 => 'pw-text-xs pw-font-medium pw-uppercase pw-tracking-wider',
];

$classes = 'pw-text-surface-900 pw-m-0 '
    . ( $level_classes[ $level ] ?? $level_classes[2] ) . ' '
    . $atts['class'];
?>

<<?php echo $tag; ?> class="<?php echo esc_attr( $classes ); ?>">
    <?php echo esc_html( $atts['text'] ); ?>
</<?php echo $tag; ?>>
