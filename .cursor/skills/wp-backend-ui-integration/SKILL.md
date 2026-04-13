---
name: wp-backend-ui-integration
description: Integrates the Composer package pw/backend-ui into WordPress admin plugins with predictable asset loading and BackendUI layouts. Use when adding or fixing BackendUI, PezWeb pw-backend-ui, vendor/pw/backend-ui, admin_enqueue_scripts for the design system CSS/JS, or when submenu admin screens miss package styles.
---

# WordPress + pw/backend-ui integration

## Goal

Use `BackendUI::init()` for **layout + components** (`render_page()`, `$bui->ui()`). Load **CSS/JS from the consuming plugin** — not from the package’s WordPress screen-ID matcher — so submenu pages (`?page=…`) never silently miss assets.

## Map placeholders to your project

Replace these in snippets with your plugin’s real names (constants, functions, or literals):

| Placeholder | Typical WordPress pattern |
|-------------|---------------------------|
| `MY_PLUGIN_FILE` | `__FILE__` of the main plugin file |
| `MY_PLUGIN_DIR` | `plugin_dir_path( MY_PLUGIN_FILE )` or your `*_PLUGIN_DIR` constant |
| `MY_PLUGIN_URL` | `plugin_dir_url( MY_PLUGIN_FILE )` or your `*_PLUGIN_URL` constant |
| `MY_VERSION` | Header version or `X.Y.Z` constant used for `?ver=` |
| `my-plugin` | Slug for handles, body classes, file names |
| `my-admin-slug` | Values of `admin.php?page=` you own |
| `my-textdomain` | Text domain string literal in `__()` (do not use a constant for the domain on org-bound code) |

---

## 1. Composer

- Require `pw/backend-ui` (version or `dev-main`) via Composer; often a `repositories` VCS entry pointing at the upstream GitHub repo.
- **Vendor policy (pick one and document it in the repo):**
  - **Gitignored `vendor/`** (e.g. MobyPress-style): run `composer install` locally and in CI/release scripts; ship `vendor` inside distribution zips only.
  - **Committed `vendor/`**: acceptable for zip-only installs with no Composer on the server; keep autoload paths stable.

---

## 2. Bootstrap autoload

Early in the main plugin file (after the `ABSPATH` guard):

```php
$my_autoload = MY_PLUGIN_DIR . 'vendor/autoload.php';
if (is_readable($my_autoload)) {
	require_once $my_autoload;
}
```

---

## 3. Init BackendUI (layout only)

On `plugins_loaded` at priority **1** (before admin runs), after checking the class exists:

```php
if (! class_exists(\PW\BackendUI\BackendUI::class)) {
	return;
}
\PW\BackendUI\BackendUI::init([
	'assets_url' => MY_PLUGIN_URL . 'vendor/pw/backend-ui/assets/',
	'version'    => MY_VERSION,
	'screens'    => [], // critical: do not let AssetsManager guess WP screen IDs
	'brand'      => [
		'name'        => __('Product or company name', 'my-textdomain'),
		'plugin_name' => __('Plugin name in admin', 'my-textdomain'),
	],
]);
```

**Why `screens => []`:** `get_current_screen()->id` varies (locale, menu structure, MU). Empty `screens` means the package does **not** auto-enqueue assets; the plugin enqueues them in one controlled code path.

---

## 4. Enqueue assets (single source of truth)

1. **Central list** of admin page slugs (`admin.php?page=…`) your plugin registers.
2. Gate enqueues with **`$_GET['page']`** + `sanitize_key` — avoid fragile `$hook` suffix allowlists unless you have a documented exception.
3. In `admin_enqueue_scripts`, when the page is yours and `BackendUI` exists:
   - Use one helper (e.g. `enqueue_backend_ui_bundle()`) that:
     - Gets `$bui = \PW\BackendUI\BackendUI::init();`
     - Reads `slug`, `assets_url`, `version` from `$bui->config()`.
     - Registers/enqueues `{slug}-styles` → `css/backend-ui.css`
     - Registers/enqueues `{slug}-scripts` → `js/backend-ui.js`
     - Adds the **before** inline script that reads `localStorage['pw-bui-theme']` and sets `#pw-backend-ui-app` `data-pw-theme` (mirror package `AssetsManager` if your package version requires it).
   - Return the **style handle** so other styles can depend on it.
4. Enqueue a **bridge/shell** stylesheet **after** that handle (scoped to `#pw-backend-ui-app` / `body.my-plugin-bui-shell`).
5. Enqueue the plugin’s own `admin.css` with the BUI style handle as a dependency so load order stays correct.

**Avoid:** duplicate enqueues, a second “fallback” at priority 99, or `wp_style_is` workarounds unless you are fixing a verified double-registration bug.

---

## 5. Body class (optional)

Filter `admin_body_class`: append e.g. `my-plugin-bui-shell` when `$_GET['page']` is in your slug list — **same condition** as the enqueue block. Use CSS to align `#wpcontent` with the shell background if needed.

---

## 6. Render pages

```php
\PW\BackendUI\BackendUI::init()->render_page([
	'title'       => __('Screen title', 'my-textdomain'),
	'description' => __('Short line', 'my-textdomain'),
	'content'     => static function ($bui) {
		$ui = $bui->ui();
		$ui->card([ /* … */ ]);
	},
]);
```

Build UI with `$bui->ui()` components. Prefer WordPress **submenus** for navigation; add extra in-page **tabs** in `render_page` only when the product really needs them.

---

## 7. Checklist before shipping

- [ ] `'screens' => []` in `BackendUI::init`.
- [ ] BUI CSS/JS enqueued only from your consolidated admin enqueue logic.
- [ ] Same slug list used for enqueue and optional `admin_body_class`.
- [ ] Text domain passed as a **string literal** inside `__()` / `_e()` where WordPress.org or GlotPress rules apply.

---

## Reference

After `composer install`, see `vendor/pw/backend-ui/PW_BACKEND-UI_USAGE.md` in the consuming project for package-specific APIs and examples.

---

## Building screens

This skill covers **integration** (Composer, init, enqueue). For the full **component API, composition patterns, layout recipes, spacing rules, and design tokens**, use the **`pw-backend-ui-build`** skill. It teaches how to construct complete admin screens using `render_page()`, tabs, cards, forms, wizards, and all available components.
