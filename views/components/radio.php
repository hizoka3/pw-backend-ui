<?php
// views/components/radio.php

/**
 * Radio button component — PW Design System.
 * Typically used inside radio_group(). Can be used standalone.
 *
 * @var array $atts  Radio attributes from ComponentRenderer::radio().
 */

defined("ABSPATH") || exit();

$radio_id =
	sanitize_title($atts["name"]) . "-" . sanitize_title($atts["value"]);
$data_attrs = "";
foreach ((array) ($atts["data_attrs"] ?? []) as $key => $val) {
	$data_attrs .= " data-" . esc_attr($key) . '="' . esc_attr($val) . '"';
}
?>

<?php if (!empty($atts["wrapper_class"])): ?><div class="<?php echo esc_attr($atts["wrapper_class"]); ?>"><?php endif; ?>
<div class="pw-bui-radio-item <?php echo esc_attr($atts["class"] ?? ""); ?>">
    <input
        type="radio"
        id="<?php echo esc_attr($radio_id); ?>"
        name="<?php echo esc_attr($atts["name"] ?? ""); ?>"
        value="<?php echo esc_attr($atts["value"] ?? ""); ?>"
        class="pw-bui-radio-item__input"
        <?php checked($atts["checked"] ?? false); ?>
        <?php echo !empty($atts["disabled"]) ? "disabled" : ""; ?>
        <?php echo $data_attrs; ?>
    />
    <div>
        <?php if (!empty($atts["label"])): ?>
            <label for="<?php echo esc_attr(
            	$radio_id,
            ); ?>" class="pw-bui-radio-item__label">
                <?php echo esc_html($atts["label"]); ?>
            </label>
        <?php endif; ?>
        <?php if (!empty($atts["help"])): ?>
            <p class="pw-bui-radio-item__help"><?php echo esc_html(
            	$atts["help"],
            ); ?></p>
        <?php endif; ?>
    </div>
</div>
<?php if (!empty($atts["wrapper_class"])): ?></div><?php endif; ?>
