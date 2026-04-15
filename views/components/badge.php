<?php
// views/components/badge.php

/**
 * Badge / Label component — PW Design System.
 *
 * @var array $atts  Badge attributes from ComponentRenderer::badge().
 *                    variant: alphanumeric + hyphen/underscore only (sanitized in ComponentRenderer).
 */

defined("ABSPATH") || exit();

$data_attrs = "";
foreach ((array) ($atts["data_attrs"] ?? []) as $key => $val) {
	$data_attrs .= " data-" . esc_attr($key) . '="' . esc_attr($val) . '"';
}
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
<?php if (!empty($atts["wrapper_class"])): ?><div class="<?php echo esc_attr($atts["wrapper_class"]); ?>"><?php endif; ?>
<span class="<?php echo esc_attr($classes); ?>"<?php echo $data_attrs; ?>><?php echo esc_html(
	$atts["label"] ?? "",
); ?></span>
<?php if (!empty($atts["wrapper_class"])): ?></div><?php endif; ?>
