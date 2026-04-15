<?php
// views/components/section-label.php

/**
 * @var array $atts  From ComponentRenderer::section_label().
 */

defined("ABSPATH") || exit();

$cls = trim("pw-bui-section-label " . ($atts["class"] ?? ""));
$data_attrs = "";
foreach ((array) ($atts["data_attrs"] ?? []) as $key => $val) {
	$data_attrs .= " data-" . esc_attr($key) . '="' . esc_attr($val) . '"';
}
?>

<?php if (!empty($atts["wrapper_class"])): ?>
<div class="<?php echo esc_attr($atts["wrapper_class"]); ?>">
<?php endif; ?>

<?php if (!empty($atts["for"])): ?>
    <label for="<?php echo esc_attr($atts["for"]); ?>" class="<?php echo esc_attr($cls); ?>"<?php echo $data_attrs; ?>>
        <?php echo esc_html($atts["text"] ?? ""); ?>
    </label>
<?php else: ?>
    <p class="<?php echo esc_attr($cls); ?>"<?php echo $data_attrs; ?>><?php echo esc_html($atts["text"] ?? ""); ?></p>
<?php endif; ?>

<?php if (!empty($atts["wrapper_class"])): ?>
</div>
<?php endif; ?>
