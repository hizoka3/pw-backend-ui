<?php
// views/components/spinner.php

/**
 * Spinner component — PW Design System.
 *
 * @var array $atts  Spinner attributes from ComponentRenderer::spinner().
 */

defined("ABSPATH") || exit();

$classes = implode(
	" ",
	array_filter([
		"pw-bui-spinner",
		"pw-bui-spinner--" . ($atts["size"] ?? "md"),
		$atts["class"] ?? "",
	]),
);
?>
<span
    class="<?php echo esc_attr($classes); ?>"
    role="status"
    aria-label="<?php echo esc_attr($atts["label"] ?? "Cargando..."); ?>"
></span>
