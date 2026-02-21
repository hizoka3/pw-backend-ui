<?php
// views/components/separator.php

/**
 * Separator / Divider component — PW Design System.
 *
 * @var array $atts  Separator attributes from ComponentRenderer::separator().
 */

defined("ABSPATH") || exit(); ?>
<hr class="pw-bui-separator <?php echo esc_attr($atts["class"] ?? ""); ?>" />
