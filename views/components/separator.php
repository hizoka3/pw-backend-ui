<?php
// views/components/separator.php

/**
 * Separator / Divider component — PW Design System.
 *
 * @var array $atts  Separator attributes from ComponentRenderer::separator().
 */

defined("ABSPATH") || exit();
$data_attrs = "";
foreach ((array) ($atts["data_attrs"] ?? []) as $key => $val) {
	$data_attrs .= " data-" . esc_attr($key) . '="' . esc_attr($val) . '"';
}
?>
<?php if (!empty($atts["wrapper_class"])): ?><div class="<?php echo esc_attr($atts["wrapper_class"]); ?>"><?php endif; ?>
<hr class="pw-bui-separator <?php echo esc_attr($atts["class"] ?? ""); ?>"<?php echo $data_attrs; ?> />
<?php if (!empty($atts["wrapper_class"])): ?></div><?php endif; ?>
