<?php
// views/components/logo.php

/**
 * Logo component — PW Design System.
 *
 * @var array $atts  Logo attributes from ComponentRenderer::logo().
 */

defined("ABSPATH") || exit();

$classes = implode(
	" ",
	array_filter([
		"pw-bui-logo",
		$atts["class"] ?? "",
	]),
);
?>
<div class="<?php echo esc_attr($classes); ?>">
	<div class="pw-bui-logo__top">
		<span class="pw-bui-logo__dot" aria-hidden="true"></span>
		<span class="pw-bui-logo__brand"><?php echo esc_html($atts["brand"] ?? ""); ?></span>
	</div>
	<?php if (!empty($atts["plugin_name"])): ?>
	<span class="pw-bui-logo__plugin"><?php echo esc_html($atts["plugin_name"]); ?></span>
	<?php endif; ?>
</div>
