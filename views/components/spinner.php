<?php
// views/components/spinner.php

/**
 * Spinner component — PW Design System.
 *
 * @var array $atts  Spinner attributes from ComponentRenderer::spinner().
 */

defined("ABSPATH") || exit();

$data_attrs = "";
foreach ((array) ($atts["data_attrs"] ?? []) as $key => $val) {
	$data_attrs .= " data-" . esc_attr($key) . '="' . esc_attr($val) . '"';
}
$classes = implode(
	" ",
	array_filter([
		"pw-bui-spinner",
		"pw-bui-spinner--" . ($atts["size"] ?? "md"),
		$atts["class"] ?? "",
	]),
);
?>
<?php if (!empty($atts["wrapper_class"])): ?><div class="<?php echo esc_attr($atts["wrapper_class"]); ?>"><?php endif; ?>
<span
    class="<?php echo esc_attr($classes); ?>"
    role="status"
    aria-label="<?php echo esc_attr($atts["label"] ?? "Cargando..."); ?>"
    <?php echo $data_attrs; ?>
></span>
<?php if (!empty($atts["wrapper_class"])): ?></div><?php endif; ?>
