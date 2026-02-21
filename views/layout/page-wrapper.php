<?php
// views/layout/page-wrapper.php

/**
 * Main page wrapper layout — PW Design System.
 *
 * No border-radius on layout elements. No extra margin/padding vs WP menu.
 * Header includes the PW logo (red square) + theme toggle + right slot.
 *
 * @var array                       $page  Page config array.
 * @var \PW\BackendUI\BackendUI     $bui   BackendUI instance (passed from render_page / _render_playground).
 */

defined("ABSPATH") || exit();

$brand = $bui->config("brand");
$has_sidebar = !empty($page["sidebar"]);
?>

<div id="pw-backend-ui-app" data-pw-theme="dark">

    <?php
// ── HEADER ─────────────────────────────────────────────────────────
?>
    <header class="pw-bui-header">
        <div class="pw-bui-header__inner">

            <?php
// Logo PW
?>
            <a href="<?php echo esc_url(admin_url()); ?>" class="pw-bui-logo">
                <span class="pw-bui-logo__mark" aria-hidden="true">
                    <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 2h4a3 3 0 0 1 0 6H5v4H3V2zm2 4h2a1 1 0 0 0 0-2H5v2zM9.5 2H12l2.5 10H12.5L12 9.5H10L9.5 12H7.5L9.5 2zm1 5.5h1L11 4l-.5 3.5z" fill="white"/>
                    </svg>
                </span>
                <?php if (!empty($brand["name"])): ?>
                    <span class="pw-bui-logo__name"><?php echo esc_html(
                    	$brand["name"],
                    ); ?></span>
                <?php endif; ?>
            </a>

            <?php
// Page title en el header cuando no hay logo name
?>
            <?php if (!empty($page["title"]) && empty($brand["name"])): ?>
                <h1 style="font-size:14px;font-weight:600;color:var(--pw-color-fg-default);margin:0;">
                    <?php echo esc_html($page["title"]); ?>
                </h1>
            <?php endif; ?>

            <?php
// Header right slot
?>
            <div class="pw-bui-header__right">
                <?php do_action("pw_bui/header_right", $page); ?>

                <?php
// Theme toggle button
?>
                <button
                    type="button"
                    class="pw-bui-theme-toggle"
                    aria-label="<?php esc_attr_e(
                    	"Cambiar tema",
                    	"pw-backend-ui",
                    ); ?>"
                    title="<?php esc_attr_e(
                    	"Cambiar tema claro / oscuro",
                    	"pw-backend-ui",
                    ); ?>"
                >
                    <?php
// Moon icon (visible en dark mode)
?>
                    <svg class="pw-bui-icon-moon" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M9.598 1.591a.749.749 0 0 1 .785-.175 7.001 7.001 0 1 1-8.967 8.967.75.75 0 0 1 .961-.96 5.5 5.5 0 0 0 7.046-7.046.75.75 0 0 1 .175-.786Z"/>
                    </svg>
                    <?php
// Sun icon (visible en light mode)
?>
                    <svg class="pw-bui-icon-sun" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm.25-9.25v-1.5a.25.25 0 0 0-.5 0v1.5a.25.25 0 0 0 .5 0Zm0 10v1.5a.25.25 0 0 0-.5 0v-1.5a.25.25 0 0 0 .5 0ZM2.75 8a.25.25 0 0 0 0-.5h-1.5a.25.25 0 0 0 0 .5ZM14 7.75a.25.25 0 0 0 0-.5h-1.5a.25.25 0 0 0 0 .5ZM4.11 4.64a.25.25 0 0 0 .35-.35l-1.06-1.06a.25.25 0 0 0-.35.35Zm7.79 7.79a.25.25 0 0 0 .35-.35l-1.06-1.06a.25.25 0 0 0-.35.35Zm.35-9.21a.25.25 0 0 0-.35-.35L10.83 4.03a.25.25 0 0 0 .35.35Zm-7.79 7.79a.25.25 0 0 0-.35-.35L3.11 11.88a.25.25 0 0 0 .35.35Z"/>
                    </svg>
                </button>
            </div>

        </div>

        <?php
// ── TABS (dentro del header, estilo Primer UnderlineNav) ──
?>
        <?php if (!empty($page["tabs"])): ?>
            <div class="pw-bui-tabs-nav">
                <?php $bui->ui()->tabs(["tabs" => $page["tabs"]]); ?>
            </div>
        <?php endif; ?>
    </header>

    <?php
// ── MAIN ───────────────────────────────────────────────────────────
?>
    <div class="pw-bui-main">

        <?php
// Page title / description cuando hay brand name (va en el body, no en el header)
?>
        <?php if (!empty($page["title"]) && !empty($brand["name"])): ?>
            <div style="margin-bottom:20px;">
                <h1 style="font-size:20px;font-weight:600;color:var(--pw-color-fg-default);margin:0 0 4px;">
                    <?php echo esc_html($page["title"]); ?>
                </h1>
                <?php if (!empty($page["description"])): ?>
                    <p style="font-size:13px;color:var(--pw-color-fg-muted);margin:0;">
                        <?php echo esc_html($page["description"]); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php elseif (!empty($page["description"])): ?>
            <p style="font-size:13px;color:var(--pw-color-fg-muted);margin:0 0 20px;">
                <?php echo esc_html($page["description"]); ?>
            </p>
        <?php endif; ?>

        <div class="pw-bui-layout <?php echo $has_sidebar
        	? "pw-bui-layout--with-sidebar"
        	: ""; ?>">

            <main class="pw-bui-layout__main" style="min-width:0;">
                <?php if (is_callable($page["content"])) {
                	call_user_func($page["content"], $bui);
                } ?>
            </main>

            <?php if ($has_sidebar): ?>
                <aside class="pw-bui-layout__sidebar" style="min-width:0;">
                    <?php if (!empty($page["sidebar"]["title"])): ?>
                        <p style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;color:var(--pw-color-fg-muted);margin:0 0 10px;">
                            <?php echo esc_html($page["sidebar"]["title"]); ?>
                        </p>
                    <?php endif; ?>
                    <?php if (
                    	is_callable($page["sidebar"]["content"] ?? null)
                    ) {
                    	call_user_func($page["sidebar"]["content"], $bui);
                    } ?>
                </aside>
            <?php endif; ?>

        </div>
    </div>

    <?php
// ── FOOTER ─────────────────────────────────────────────────────────
?>
    <?php if (!empty($page["footer"])): ?>
        <footer class="pw-bui-footer">
            <div>
                <?php if (is_callable($page["footer"]["left"] ?? null)) {
                	call_user_func($page["footer"]["left"], $bui);
                } ?>
            </div>
            <div>
                <?php if (is_callable($page["footer"]["right"] ?? null)) {
                	call_user_func($page["footer"]["right"], $bui);
                } ?>
            </div>
        </footer>
    <?php endif; ?>

</div>
