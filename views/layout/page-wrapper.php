<?php
// views/layout/page-wrapper.php

/**
 * Main page wrapper layout.
 * Receives $page array and $this (BackendUI instance) from render_page().
 *
 * @var array $page  Page config array.
 * @var \PW\BackendUI\BackendUI $this
 */

defined( 'ABSPATH' ) || exit;

$brand = $this->config( 'brand' );
$has_sidebar = ! empty( $page['sidebar'] );
?>

<div class="pw-wrap pw-font-sans pw-antialiased pw-text-surface-800 pw-bg-surface-50 pw-min-h-screen pw-pb-8" id="pw-backend-ui-app">

    <?php // ── HEADER ──────────────────────────────────────────────────── ?>
    <header class="pw-bg-white pw-border-b pw-border-surface-200 pw-mb-6">
        <div class="pw-max-w-7xl pw-mx-auto pw-px-6 pw-py-5 pw-flex pw-items-center pw-justify-between">
            <div class="pw-flex pw-items-center pw-gap-4">
                <?php if ( ! empty( $brand['logo_url'] ) ) : ?>
                    <img
                        src="<?php echo esc_url( $brand['logo_url'] ); ?>"
                        alt="<?php echo esc_attr( $brand['name'] ); ?>"
                        class="pw-h-8 pw-w-auto"
                    />
                <?php endif; ?>

                <div>
                    <?php if ( ! empty( $page['title'] ) ) : ?>
                        <h1 class="pw-text-xl pw-font-semibold pw-text-surface-900 pw-m-0 pw-p-0">
                            <?php echo esc_html( $page['title'] ); ?>
                        </h1>
                    <?php endif; ?>

                    <?php if ( ! empty( $page['description'] ) ) : ?>
                        <p class="pw-text-sm pw-text-surface-500 pw-mt-1 pw-m-0">
                            <?php echo esc_html( $page['description'] ); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <?php do_action( 'pw_bui/header_right', $page ); ?>
        </div>

        <?php // ── TABS (inside header) ─────────────────────────────── ?>
        <?php if ( ! empty( $page['tabs'] ) ) : ?>
            <div class="pw-max-w-7xl pw-mx-auto pw-px-6">
                <?php $this->ui()->tabs( [ 'tabs' => $page['tabs'] ] ); ?>
            </div>
        <?php endif; ?>
    </header>

    <?php // ── BODY ────────────────────────────────────────────────────── ?>
    <div class="pw-max-w-7xl pw-mx-auto pw-px-6">
        <div class="<?php echo $has_sidebar ? 'pw-grid pw-grid-cols-1 lg:pw-grid-cols-[1fr_320px] pw-gap-6' : ''; ?>">

            <?php // ── MAIN CONTENT ────────────────────────────────── ?>
            <main class="pw-min-w-0">
                <?php
                if ( is_callable( $page['content'] ) ) {
                    call_user_func( $page['content'], $this );
                }
                ?>
            </main>

            <?php // ── SIDEBAR ─────────────────────────────────────── ?>
            <?php if ( $has_sidebar ) : ?>
                <aside class="pw-space-y-4">
                    <?php if ( ! empty( $page['sidebar']['title'] ) ) : ?>
                        <h3 class="pw-text-sm pw-font-medium pw-text-surface-500 pw-uppercase pw-tracking-wider pw-m-0">
                            <?php echo esc_html( $page['sidebar']['title'] ); ?>
                        </h3>
                    <?php endif; ?>

                    <?php
                    if ( is_callable( $page['sidebar']['content'] ?? null ) ) {
                        call_user_func( $page['sidebar']['content'], $this );
                    }
                    ?>
                </aside>
            <?php endif; ?>
        </div>
    </div>

    <?php // ── FOOTER ──────────────────────────────────────────────────── ?>
    <?php if ( ! empty( $page['footer'] ) ) : ?>
        <footer class="pw-max-w-7xl pw-mx-auto pw-px-6 pw-mt-8 pw-pt-6 pw-border-t pw-border-surface-200">
            <div class="pw-flex pw-items-center pw-justify-between">
                <div>
                    <?php
                    if ( is_callable( $page['footer']['left'] ?? null ) ) {
                        call_user_func( $page['footer']['left'], $this );
                    }
                    ?>
                </div>
                <div>
                    <?php
                    if ( is_callable( $page['footer']['right'] ?? null ) ) {
                        call_user_func( $page['footer']['right'], $this );
                    }
                    ?>
                </div>
            </div>
        </footer>
    <?php endif; ?>

</div>
