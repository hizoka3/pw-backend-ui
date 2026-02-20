<?php
// views/components/notice.php

/**
 * Notice/Alert component.
 *
 * @var array $atts  Notice attributes from ComponentRenderer::notice().
 */

defined( 'ABSPATH' ) || exit;

$type_classes = [
    'info'    => 'pw-bg-info-50 pw-border-info-500 pw-text-info-700',
    'success' => 'pw-bg-success-50 pw-border-success-500 pw-text-success-700',
    'warning' => 'pw-bg-warning-50 pw-border-warning-500 pw-text-warning-700',
    'danger'  => 'pw-bg-danger-50 pw-border-danger-500 pw-text-danger-700',
];

$icons = [
    'info'    => '<svg class="pw-h-5 pw-w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>',
    'success' => '<svg class="pw-h-5 pw-w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
    'warning' => '<svg class="pw-h-5 pw-w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>',
    'danger'  => '<svg class="pw-h-5 pw-w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>',
];

$classes = 'pw-flex pw-items-start pw-gap-3 pw-p-4 pw-rounded-lg pw-border-l-4 pw-text-sm '
    . ( $type_classes[ $atts['type'] ] ?? $type_classes['info'] )
    . ' ' . $atts['class'];
?>

<div class="<?php echo esc_attr( $classes ); ?>" role="alert" <?php echo $atts['dismissible'] ? 'data-pw-dismissible' : ''; ?>>
    <span class="pw-shrink-0 pw-mt-0.5"><?php echo $icons[ $atts['type'] ] ?? $icons['info']; ?></span>

    <div class="pw-flex-1">
        <p class="pw-m-0"><?php echo wp_kses_post( $atts['message'] ); ?></p>
    </div>

    <?php if ( $atts['dismissible'] ) : ?>
        <button type="button" class="pw-bui-dismiss pw-shrink-0 pw-text-current pw-opacity-50 hover:pw-opacity-100 pw-transition-opacity pw-cursor-pointer pw-bg-transparent pw-border-0 pw-p-0" aria-label="Dismiss">
            <svg class="pw-h-4 pw-w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
        </button>
    <?php endif; ?>
</div>
