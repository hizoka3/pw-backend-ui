<?php
// views/components/tabs.php

/**
 * Tabs navigation — Primer UnderlineNav style — PW Design System.
 * Works with tab-panel.php and backend-ui.js.
 *
 * @var array $atts  Tabs attributes from ComponentRenderer::tabs().
 */

defined("ABSPATH") || exit();

if (empty($atts["tabs"])) {
	return;
}
?>

<nav
    class="<?php echo esc_attr($atts["class"] ?? ""); ?>"
    role="tablist"
    aria-label="Tabs"
    style="display:flex;gap:0;"
>
    <?php foreach ($atts["tabs"] as $tab):

    	$slug = $tab["slug"] ?? "";
    	$label = $tab["label"] ?? "";
    	$active = !empty($tab["active"]);
    	$count = $tab["count"] ?? null;
    	?>
        <button
            type="button"
            role="tab"
            class="pw-bui-tab<?php echo $active
            	? " pw-bui-tab--active"
            	: ""; ?>"
            data-pw-tab="<?php echo esc_attr($slug); ?>"
            aria-selected="<?php echo $active ? "true" : "false"; ?>"
            aria-controls="pw-tab-panel-<?php echo esc_attr($slug); ?>"
        >
            <?php echo esc_html($label); ?>
            <?php if ($count !== null): ?>
                <span class="pw-bui-badge pw-bui-badge--default pw-bui-badge--sm" style="margin-left:4px;">
                    <?php echo esc_html($count); ?>
                </span>
            <?php endif; ?>
        </button>
    <?php
    endforeach; ?>
</nav>
