<?php
// views/components/tab-panel.php

/**
 * Tab panel content wrapper.
 * Paired with tabs.php and toggled by backend-ui.js.
 *
 * @var array $atts  Tab panel attributes from ComponentRenderer::tab_panel().
 */

defined( 'ABSPATH' ) || exit;
?>

<div
    role="tabpanel"
    id="pw-tab-panel-<?php echo esc_attr( $atts['slug'] ); ?>"
    data-pw-tab-panel="<?php echo esc_attr( $atts['slug'] ); ?>"
    class="pw-bui-tab-panel <?php echo $atts['active'] ? '' : 'pw-hidden'; ?> <?php echo esc_attr( $atts['class'] ); ?>"
    <?php echo $atts['active'] ? '' : 'aria-hidden="true"'; ?>
>
    <?php
    if ( is_callable( $atts['content'] ) ) {
        call_user_func( $atts['content'] );
    }
    ?>
</div>
