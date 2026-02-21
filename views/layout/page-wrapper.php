<?php
// views/layout/page-wrapper.php

/**
 * Main page layout — full-bleed, no border-radius, flush with WP admin menu.
 *
 * @var array                       $page
 * @var \PW\BackendUI\BackendUI     $this
 */

defined("ABSPATH") || exit();

$brand = $this->config("brand");
$theme = $this->config("theme") ?: "dark";
$has_sidebar = !empty($page["sidebar"]);
?>
<div
    id="pw-backend-ui-app"
    class="pw-bui-layout"
    data-pw-theme="<?php echo esc_attr($theme); ?>"
>
    <?php
/* ── HEADER ─────────────────────────────────────────────── */
?>
    <header class="pw-bui-header">

        <div class="pw-bui-header-left">
            <?php
/* Logo PW — siempre visible */
?>
            <a class="pw-bui-logo" href="#" aria-label="PW Backend UI">
                <span class="pw-bui-logo-mark">
                    <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M3 2h4.5a3.5 3.5 0 0 1 0 7H5v5H3V2zm2 5h2.5a1.5 1.5 0 0 0 0-3H5v3z"/>
                    </svg>
                </span>
                <?php if (!empty($brand["name"])): ?>
                    <span class="pw-bui-logo-text"><?php echo esc_html(
                    	$brand["name"],
                    ); ?></span>
                <?php endif; ?>
            </a>

            <?php if (!empty($page["title"])): ?>
                <span style="color: var(--pw-fg-subtle); font-size: 14px; margin: 0 2px;">/</span>
                <h1 style="font-size: var(--pw-text-sm); font-weight: 500; color: var(--pw-header-fg); margin: 0; padding: 0;">
                    <?php echo esc_html($page["title"]); ?>
                </h1>
            <?php endif; ?>
        </div>

        <div class="pw-bui-header-right">
            <?php
/* Plugin-defined content (hook) */
?>
            <?php do_action("pw_bui/header_right", $page); ?>

            <?php
/* Theme toggle — sun/moon */
?>
            <button
                class="pw-bui-theme-toggle"
                data-pw-theme-toggle
                type="button"
                aria-label="Switch to light mode"
                title="Light mode"
            >
                <?php
/* Sun icon — shown when in dark mode (click → light) */
?>
                <svg class="pw-bui-icon-moon" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path fill-rule="evenodd" d="M9.598 1.591a.75.75 0 01.785-.175 7 7 0 11-8.967 8.967.75.75 0 01.961-.96 5.5 5.5 0 007.046-7.046.75.75 0 01.175-.786zm1.616 1.945a7 7 0 01-7.678 7.678 5.5 5.5 0 107.678-7.678z"/>
                </svg>
                <?php
/* Moon icon — shown when in light mode (click → dark) */
?>
                <svg class="pw-bui-icon-sun" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="display:none">
                    <path fill-rule="evenodd" d="M8 10.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5zM8 12a4 4 0 100-8 4 4 0 000 8zM8 0a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0V.75A.75.75 0 018 0zm0 13a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 018 13zM2.343 2.343a.75.75 0 011.061 0l1.06 1.061a.75.75 0 01-1.06 1.06l-1.061-1.06a.75.75 0 010-1.061zm9.193 9.193a.75.75 0 011.06 0l1.061 1.06a.75.75 0 01-1.06 1.061l-1.061-1.06a.75.75 0 010-1.061zM0 8a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5H.75A.75.75 0 010 8zm13 0a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5A.75.75 0 0113 8zM2.343 13.657a.75.75 0 010-1.06l1.061-1.061a.75.75 0 011.06 1.06l-1.06 1.061a.75.75 0 01-1.061 0zm9.193-9.193a.75.75 0 010-1.06l1.06-1.061a.75.75 0 111.061 1.06l-1.06 1.061a.75.75 0 01-1.061 0z"/>
                </svg>
            </button>
        </div>
    </header>

    <?php
/* ── TABS (underline nav style) ────────────────────────── */
?>
    <?php if (!empty($page["tabs"])): ?>
        <nav class="pw-bui-tabnav" role="tablist" aria-label="Page sections">
            <?php foreach ($page["tabs"] as $tab):

            	$slug = $tab["slug"] ?? "";
            	$label = $tab["label"] ?? "";
            	$active = !empty($tab["active"]);
            	$count = $tab["count"] ?? null;
            	?>
                <button
                    type="button"
                    role="tab"
                    class="pw-bui-tabnav-item<?php echo $active
                    	? " pw-bui-active"
                    	: ""; ?>"
                    data-pw-tab="<?php echo esc_attr($slug); ?>"
                    aria-selected="<?php echo $active ? "true" : "false"; ?>"
                    aria-controls="pw-tab-panel-<?php echo esc_attr($slug); ?>"
                    <?php echo $active ? 'tabindex="0"' : 'tabindex="-1"'; ?>
                >
                    <?php echo esc_html($label); ?>
                    <?php if ($count !== null): ?>
                        <span class="pw-bui-counter"><?php echo esc_html(
                        	$count,
                        ); ?></span>
                    <?php endif; ?>
                </button>
            <?php
            endforeach; ?>
        </nav>
    <?php endif; ?>

    <?php
/* ── BODY ─────────────────────────────────────────────── */
?>
    <div class="pw-bui-body">
        <div class="pw-bui-content-grid<?php echo $has_sidebar
        	? " has-sidebar"
        	: ""; ?>">

            <main class="pw-bui-main" style="min-width: 0;">
                <?php if (!empty($page["description"])): ?>
                    <p style="font-size: var(--pw-text-sm); color: var(--pw-fg-muted); margin-bottom: 20px;">
                        <?php echo esc_html($page["description"]); ?>
                    </p>
                <?php endif; ?>

                <?php if (is_callable($page["content"])) {
                	call_user_func($page["content"], $this);
                } ?>
            </main>

            <?php if ($has_sidebar): ?>
                <aside class="pw-bui-sidebar">
                    <?php if (!empty($page["sidebar"]["title"])): ?>
                        <p class="pw-bui-text-small" style="text-transform: uppercase; letter-spacing: 0.06em; font-weight: 500; margin-bottom: 8px;">
                            <?php echo esc_html($page["sidebar"]["title"]); ?>
                        </p>
                    <?php endif; ?>
                    <?php if (
                    	is_callable($page["sidebar"]["content"] ?? null)
                    ) {
                    	call_user_func($page["sidebar"]["content"], $this);
                    } ?>
                </aside>
            <?php endif; ?>

        </div>
    </div>

    <?php
/* ── FOOTER ──────────────────────────────────────────── */
?>
    <?php if (!empty($page["footer"])): ?>
        <footer class="pw-bui-footer">
            <div>
                <?php if (is_callable($page["footer"]["left"] ?? null)) {
                	call_user_func($page["footer"]["left"], $this);
                } ?>
            </div>
            <div>
                <?php if (is_callable($page["footer"]["right"] ?? null)) {
                	call_user_func($page["footer"]["right"], $this);
                } ?>
            </div>
        </footer>
    <?php endif; ?>

</div>
