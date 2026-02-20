<?php
// views/components/tabs.php

/**
 * Tabs navigation component.
 * Works with tab-panel.php and backend-ui.js for tab switching.
 *
 * @var array $atts  Tabs attributes from ComponentRenderer::tabs().
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $atts['tabs'] ) ) {
    return;
}
?>

<nav class="pw-flex pw-gap-0 pw-border-b-0 pw--mb-px <?php echo esc_attr( $atts['class'] ); ?>" role="tablist" aria-label="Tabs">
    <?php foreach ( $atts['tabs'] as $tab ) : ?>
        <?php
        $slug   = $tab['slug'] ?? '';
        $label  = $tab['label'] ?? '';
        $active = ! empty( $tab['active'] );

        $classes = 'pw-bui-tab pw-relative pw-px-4 pw-py-3 pw-text-sm pw-font-medium pw-cursor-pointer pw-border-b-2 pw-transition-colors pw-bg-transparent pw-border-l-0 pw-border-r-0 pw-border-t-0';
        $classes .= $active
            ? ' pw-border-brand-600 pw-text-brand-600'
            : ' pw-border-transparent pw-text-surface-500 hover:pw-text-surface-700 hover:pw-border-surface-300';
        ?>
        <button
            type="button"
            role="tab"
            class="<?php echo esc_attr( $classes ); ?>"
            data-pw-tab="<?php echo esc_attr( $slug ); ?>"
            aria-selected="<?php echo $active ? 'true' : 'false'; ?>"
            aria-controls="pw-tab-panel-<?php echo esc_attr( $slug ); ?>"
        >
            <?php echo esc_html( $label ); ?>
        </button>
    <?php endforeach; ?>
</nav>
