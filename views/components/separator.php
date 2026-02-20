<?php
// views/components/separator.php

/**
 * Separator/Divider component.
 *
 * @var array $atts  Separator attributes from ComponentRenderer::separator().
 */

defined( 'ABSPATH' ) || exit;
?>

<hr class="pw-border-0 pw-border-t pw-border-surface-200 pw-my-6 <?php echo esc_attr( $atts['class'] ); ?>" />
