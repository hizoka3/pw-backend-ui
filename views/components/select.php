<?php
// views/components/select.php

/**
 * Select dropdown component — PW Design System.
 *
 * @var array $atts  Select attributes from ComponentRenderer::select().
 */

defined("ABSPATH") || exit();

$has_error = !empty($atts["error"]);
$select_id = sanitize_title($atts["name"]);
$data_attrs = "";
foreach ((array) ($atts["data_attrs"] ?? []) as $key => $val) {
	$data_attrs .= " data-" . esc_attr($key) . '="' . esc_attr($val) . '"';
}
$classes = implode(
	" ",
	array_filter([
		"pw-bui-select",
		$has_error ? "pw-bui-select--error" : "",
		$atts["class"] ?? "",
	]),
);

// Normalize options to [ 'value' => '', 'label' => '' ] format
$options = [];
foreach ($atts["options"] ?? [] as $key => $option) {
	$options[] = is_array($option)
		? $option
		: ["value" => $key, "label" => $option];
}
?>

<div class="pw-bui-form-group <?php echo esc_attr(
	$atts["wrapper_class"] ?? "",
); ?>">
    <?php if (!empty($atts["label"])): ?>
        <label
            for="<?php echo esc_attr($select_id); ?>"
            class="pw-bui-label<?php echo !empty($atts["required"])
            	? " pw-bui-label--required"
            	: ""; ?>"
        >
            <?php echo esc_html($atts["label"]); ?>
        </label>
    <?php endif; ?>

    <select
        id="<?php echo esc_attr($select_id); ?>"
        name="<?php echo esc_attr($atts["name"] ?? ""); ?>"
        class="<?php echo esc_attr($classes); ?>"
        <?php echo !empty($atts["required"]) ? "required" : ""; ?>
        <?php echo !empty($atts["disabled"]) ? "disabled" : ""; ?>
        <?php echo $data_attrs; ?>
    >
        <?php if (!empty($atts["placeholder"])): ?>
            <option value=""><?php echo esc_html(
            	$atts["placeholder"],
            ); ?></option>
        <?php endif; ?>

        <?php foreach ($options as $option): ?>
            <option
                value="<?php echo esc_attr($option["value"]); ?>"
                <?php selected($atts["value"] ?? "", $option["value"]); ?>
                <?php echo !empty($option["disabled"]) ? "disabled" : ""; ?>
            >
                <?php echo esc_html($option["label"]); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php if ($has_error): ?>
        <p class="pw-bui-form-error"><?php echo esc_html($atts["error"]); ?></p>
    <?php elseif (!empty($atts["help"])): ?>
        <p class="pw-bui-form-help"><?php echo esc_html($atts["help"]); ?></p>
    <?php endif; ?>
</div>
