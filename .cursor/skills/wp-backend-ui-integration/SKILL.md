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
| `my-plugin` | Menu slug / `page=` param (screen IDs), not asset handles |
| `my-admin-slug` | Values of `admin.php?page=` you own |
| `my-textdomain` | Text domain string literal in `__()` (do not use a constant for the domain on org-bound code) |

---

## 1. Composer

- Require `pw/backend-ui` **^1.2** (or `dev-main`) via Composer; often a `repositories` VCS entry pointing at the upstream GitHub repo.
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

## 3. Init BackendUI (1.2+ — sin pelear por el singleton)

En `plugins_loaded` (prioridad por defecto está bien: cada plugin puede llamar `init()` y los fragmentos se fusionan).

```php
if (! class_exists(\PW\BackendUI\BackendUI::class)) {
	return;
}
\PW\BackendUI\BackendUI::init([
	'assets_url' => MY_PLUGIN_URL . 'vendor/pw/backend-ui/assets/',
	'version'    => MY_VERSION,
	'screens'    => [
		'toplevel_page_my-plugin',
		'my-plugin_page_my-plugin-settings',
		// …todos los screen_id de tus pantallas BUI
	],
	'brand'      => [
		'plugin_name' => __('Plugin name in admin', 'my-textdomain'),
		'version'     => MY_VERSION,
	],
]);
```

- **`screens`:** lista explícita de `get_current_screen()->id` donde deben cargarse `backend-ui.css` / `backend-ui.js`. Vacío = el paquete no encola nada (útil solo si tienes un caso muy especial).
- **Varios plugins PezWeb:** cada uno llama `init()` con sus pantallas; el paquete une `screens`, usa **handles fijos** `pw-bui-core-styles` / `pw-bui-core-scripts`, y la cabecera usa `effective_brand()` por pantalla.
- **CSS del plugin:** registra tu hoja con dependencia `\PW\BackendUI\BackendUI::CORE_STYLE_HANDLE` (string `pw-bui-core-styles`). No dupliques el bundle del paquete con handles `{slug}-styles`.

---

## 4. Admin bridge (opcional)

Si usas `admin_bridge` / `bridge_screens` en `init()`, el paquete añade la hoja `pw-bui-core-admin-bridge` y la clase de cuerpo donde corresponde. No hace falta un segundo enqueue manual del bridge salvo reglas muy custom.

---

## 5. Body class propio (opcional)

Para alinear `#wpcontent` con tu shell, puedes seguir usando `admin_body_class` con una clase **tuya** (p. ej. `my-plugin-bui-shell`) en las mismas pantallas que listaste en `screens`. No depende de los handles del paquete.

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

- [ ] Todos los `screen_id` de pantallas BUI listados en `screens` del `init()` de tu plugin.
- [ ] CSS propio del plugin depende de `BackendUI::CORE_STYLE_HANDLE` (no de un handle `{slug}-styles`).
- [ ] Sin loader externo que haga `dequeue` de handles antiguos por slug (rompe 1.2+).
- [ ] Text domain passed as a **string literal** inside `__()` / `_e()` where WordPress.org or GlotPress rules apply.

---

## Reference

After `composer install`, see `vendor/pw/backend-ui/PW_BACKEND-UI_USAGE.md` in the consuming project for package-specific APIs and examples.

---

## Building screens

This skill covers **integration** (Composer, init, enqueue). For the full **component API, composition patterns, layout recipes, spacing rules, and design tokens**, use the **`pw-backend-ui-build`** skill. It teaches how to construct complete admin screens using `render_page()`, tabs, cards, forms, wizards, and all available components.
