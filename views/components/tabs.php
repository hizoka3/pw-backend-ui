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
    	$href = $tab["href"] ?? null; // link mode vs JS mode

    	$cls = "pw-bui-tab" . ($active ? " pw-bui-tab--active" : "");
    	$badge =
    		$count !== null
    			? '<span class="pw-bui-badge pw-bui-badge--default pw-bui-badge--sm" style="margin-left:4px;">' .
    				esc_html($count) .
    				"</span>"
    			: "";

    	if ($href):// Link mode: navegación de página completa
    		 ?>
        <a
            href="<?php echo esc_url($href); ?>"
            role="tab"
            class="<?php echo esc_attr($cls); ?>"
            aria-selected="<?php echo $active ? "true" : "false"; ?>"
        ><?php
        echo esc_html($label);
        echo $badge;
        ?></a>
    <?php
    		// JS mode: show/hide tab-panels

    		else: ?>
        <button
            type="button"
            role="tab"
            class="<?php echo esc_attr($cls); ?>"
            data-pw-tab="<?php echo esc_attr($slug); ?>"
            aria-selected="<?php echo $active ? "true" : "false"; ?>"
            aria-controls="pw-tab-panel-<?php echo esc_attr($slug); ?>"
        ><?php
        echo esc_html($label);
        echo $badge;
        ?></button>
    <?php endif;
    endforeach; ?>
</nav>
