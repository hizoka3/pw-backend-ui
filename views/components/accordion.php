<?php
// views/components/accordion.php

/**
 * Accordion component — PW Design System.
 * Smooth height animation driven by backend-ui.js initAccordion().
 *
 * @var array $atts Accordion attributes from ComponentRenderer::accordion().
 */

defined("ABSPATH") || exit();

$items          = $atts["items"] ?? [];
$allow_multiple = !empty($atts["allow_multiple"]);
$extra_class    = $atts["class"] ?? "";
$uid_base = wp_unique_id("pw-acc-");

if (empty($items)) {
	return;
}
?>
<div class="pw-bui-accordion <?php echo esc_attr($extra_class); ?>" data-pw-accordion<?php echo $allow_multiple ? " data-pw-accordion-multiple" : ""; ?>>
	<?php foreach ($items as $i => $item) :
		$is_open     = !empty($item["open"]);
		$is_disabled = !empty($item["disabled"]);
		$item_class  = "pw-bui-accordion__item";
		if ($is_open) {
			$item_class .= " pw-bui-accordion__item--open";
		}
		if ($is_disabled) {
			$item_class .= " pw-bui-accordion__item--disabled";
		}
		$panel_id = $uid_base . "-panel-" . $i;
		?>
		<div class="<?php echo esc_attr($item_class); ?>" data-pw-accordion-item>
			<button
				class="pw-bui-accordion__trigger"
				data-pw-accordion-trigger
				aria-expanded="<?php echo $is_open ? "true" : "false"; ?>"
				aria-controls="<?php echo esc_attr($panel_id); ?>"
				<?php echo $is_disabled ? "disabled" : ""; ?>
			>
				<span class="pw-bui-accordion__title"><?php echo esc_html($item["title"] ?? ""); ?></span>
				<svg class="pw-bui-accordion__icon" width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
					<path d="M4.427 7.427l3.396 3.396a.25.25 0 00.354 0l3.396-3.396A.25.25 0 0011.396 7H4.604a.25.25 0 00-.177.427z"/>
				</svg>
			</button>
			<div
				id="<?php echo esc_attr($panel_id); ?>"
				class="pw-bui-accordion__panel"
				data-pw-accordion-panel
				<?php echo $is_open ? "" : "hidden"; ?>
			>
				<div class="pw-bui-accordion__body">
					<?php
					if (is_callable($item["content"] ?? null)) {
						call_user_func($item["content"]);
					} elseif (!empty($item["content"])) {
						echo wp_kses_post($item["content"]);
					}
					?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
