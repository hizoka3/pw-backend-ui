<?php
// views/components/tab-panel.php

/**
 * Tab panel content wrapper — PW Design System.
 * Paired with tabs.php and toggled by backend-ui.js.
 *
 * @var array $atts  Tab panel attributes from ComponentRenderer::tab_panel().
 */

defined("ABSPATH") || exit(); ?>

<div
    id="pw-tab-panel-<?php echo esc_attr($atts["slug"] ?? ""); ?>"
    role="tabpanel"
    data-pw-tab-panel="<?php echo esc_attr($atts["slug"] ?? ""); ?>"
    class="pw-bui-tab-panel <?php echo esc_attr($atts["class"] ?? ""); ?>"
    <?php echo empty($atts["active"]) ? 'hidden aria-hidden="true"' : ""; ?>
>
    <?php if (is_callable($atts["content"] ?? null)) {
    	call_user_func($atts["content"]);
    } ?>
</div>
