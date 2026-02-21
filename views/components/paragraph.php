<?php
// views/components/paragraph.php

/**
 * Paragraph component — PW Design System.
 *
 * @var array $atts  Paragraph attributes from ComponentRenderer::paragraph().
 */

defined("ABSPATH") || exit();

$variant = $atts["variant"] ?? "default";
$classes = implode(
	" ",
	array_filter([
		"pw-bui-paragraph",
		$variant !== "default" ? "pw-bui-paragraph--" . $variant : "",
		$atts["class"] ?? "",
	]),
);
?>
<p class="<?php echo esc_attr($classes); ?>"><?php echo wp_kses_post(
	$atts["text"] ?? "",
); ?></p>
