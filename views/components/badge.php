<?php
// views/components/badge.php

/**
 * Badge / Label component — PW Design System.
 *
 * @var array $atts  Badge attributes from ComponentRenderer::badge().
 */

defined("ABSPATH") || exit();

$classes = implode(
	" ",
	array_filter([
		"pw-bui-badge",
		"pw-bui-badge--" . ($atts["variant"] ?? "default"),
		($atts["size"] ?? "md") === "sm" ? "pw-bui-badge--sm" : "",
		$atts["class"] ?? "",
	]),
);
?>
<span class="<?php echo esc_attr($classes); ?>"><?php echo esc_html(
	$atts["label"] ?? "",
); ?></span>
