---
name: pw-backend-ui-build
description: Build, componentize, migrate, and design WordPress admin screens using the PezWeb pw/backend-ui design system. Covers component API, layout composition, spacing rules, design tokens, and construction patterns for PezWeb (PW) plugins. Also use when migrating, converting, or refactoring existing admin screens (raw HTML, WordPress Settings API, Bootstrap, Tailwind) to pw-backend-ui. Use when the user mentions pezweb, PezWeb, PW, pw/, pw-bui, BackendUI, PW\BackendUI, Work OS, admin screen, settings page, render_page, design system, admin UI, card layout, wizard form, tabs page, side nav, pantalla de admin, migrar componentes, convertir a BackendUI, or refactorizar UI.
---

# PezWeb pw/backend-ui — Screen Construction Guide

For bootstrap/integration (Composer, init, enqueue), see the `wp-backend-ui-integration` skill.

## Architecture

```
BackendUI::init($config)          → singleton, call once in plugins_loaded
  ├── ->render_page($page)        → full page layout (header, tabs, content, sidebar, footer)
  └── ->ui()                      → ComponentRenderer (one method per component)
```

Every screen starts with `render_page()`. Inside its `content` callback, compose the page using `$bui->ui()` component methods. Components use **closure-based nesting**: `content`, `footer`, `sidebar`, and `trigger` keys accept `function() use ($ui) { ... }`.

```php
$bui->render_page([
    'title'   => 'Page Title',
    'content' => function (BackendUI $bui) {
        $ui = $bui->ui();
        // build the screen here
    },
]);
```

## render_page() options

| Key | Type | Description |
|-----|------|-------------|
| `title` | string | Page header title |
| `description` | string | Subtitle below title |
| `breadcrumbs` | array | `[['label' => '', 'href' => ''], ...]` |
| `tabs` | array | `[['slug' => '', 'label' => '', 'active' => bool], ...]` |
| `tabs_mode` | string | `'js'` (default) or `'url'` |
| `content` | callable | `function(BackendUI $bui)` — main body |
| `sidenav` | array or callable | Activates side navigation layout |
| `sidebar` | array | `['title' => '', 'content' => callable]` — right column |
| `footer` | array | `['left' => callable, 'right' => callable]` |

---

## Components (quick reference)

For full `$atts` and usage examples, see [components.md](components.md).

| Method | Description |
|--------|-------------|
| `input()` | Text, email, password, url, number, search, tel, file, range, color |
| `date_input()` | Alias for `input()` with `type => 'date'` |
| `textarea()` | Multi-line text with label, help, error |
| `select()` | Dropdown; accepts assoc array or array-of-arrays |
| `checkbox()` | Single checkbox |
| `toggle()` | On/off switch (button + hidden input) |
| `switch()` | Checkbox-based switch; optional `status` variant |
| `radio()` | Single radio button |
| `radio_group()` | Grouped radios with legend |
| `segmented_control()` | Mutually exclusive button group |
| `button()` | Variants: `primary`, `secondary`, `outline`, `ghost`, `danger`, `invisible`. With `href` renders `<a>`. |
| `card()` | Container with title, content closure, optional footer closure. `padded => false` for flush content. |
| `notice()` | Alert: `info`, `success`, `warning`, `danger`. Optional `dismissible`. |
| `badge()` | Label tag: `default`, `primary`, `success`, `warning`, `featured`, `danger`, `info`, `orange`, `muted`, `promo` (marketing / upsell) |
| `separator()` | Horizontal rule |
| `heading()` | h1-h6, or `variant => 'eyebrow'` for small caps `<p>` |
| `section_label()` | Small caps section divider |
| `paragraph()` | Text: `default`, `muted`, `small` |
| `link()` | Anchor: `default`, `muted`, `danger` |
| `spinner()` | Loading indicator: `sm`, `md`, `lg` |
| `progress_bar()` | Determinate progress with semantic variants |
| `skeleton()` | Loading placeholder: `text`, `title`, `box`, `avatar` |
| `tooltip()` | Hover/focus tooltip with trigger closure |
| `stats_bar()` | Horizontal metrics row |
| `data_table()` | Semantic table for key-value or settings layouts |
| `tabs()` / `tab_panel()` | Tab navigation (JS mode). Define tabs in `render_page`, panels in content. |
| `side_nav()` | Vertical nav with groups, separators, active state |
| `breadcrumbs()` | Breadcrumb trail |
| `pagination()` | Page navigation with gaps |
| `accordion()` | Collapsible sections; optional `multiple` |
| `stepper()` | Wizard step indicator; states: `active`, `pending`, `done` |

---

## Page Layout Patterns

### Tabs (JS mode) — client-side switching

```php
$bui->render_page([
    'title' => 'Settings',
    'tabs'  => [
        ['slug' => 'general',  'label' => 'General',  'active' => true],
        ['slug' => 'advanced', 'label' => 'Advanced'],
    ],
    'content' => function (BackendUI $bui) {
        $ui = $bui->ui();
        $ui->tab_panel(['slug' => 'general', 'active' => true, 'content' => function () use ($ui) {
            $ui->card(['title' => 'General', 'content' => function () use ($ui) {
                $ui->input(['name' => 'site_name', 'label' => 'Site Name', 'value' => get_option('site_name', '')]);
            }]);
        }]);
        $ui->tab_panel(['slug' => 'advanced', 'content' => function () use ($ui) {
            $ui->card(['title' => 'Advanced', 'content' => function () use ($ui) {
                $ui->toggle(['name' => 'debug', 'label' => 'Debug Mode']);
            }]);
        }]);
    },
]);
```

### Tabs (URL mode) — server-side routing, NO tab_panel

```php
$tab = sanitize_key($_GET['tab'] ?? 'general');
$url = admin_url('admin.php?page=my-plugin');

$bui->render_page([
    'tabs' => [
        ['slug' => 'general',  'label' => 'General',  'href' => add_query_arg('tab', 'general', $url),  'active' => $tab === 'general'],
        ['slug' => 'advanced', 'label' => 'Advanced', 'href' => add_query_arg('tab', 'advanced', $url), 'active' => $tab === 'advanced'],
    ],
    'tabs_mode' => 'url',
    'content' => function (BackendUI $bui) use ($tab) {
        if ($tab === 'general')  { /* render content */ }
        if ($tab === 'advanced') { /* render content */ }
    },
]);
```

### Side nav / Sidebar / Footer

```php
// Side nav
$bui->render_page([
    'sidenav' => ['items' => [
        ['label' => 'Connection', 'href' => '#connection', 'active' => true],
        ['separator' => true],
        ['group' => 'Danger Zone'],
        ['label' => 'Reset', 'href' => '#reset'],
    ]],
    'content' => function (BackendUI $bui) { /* ... */ },
]);

// Sidebar
'sidebar' => ['title' => 'Status', 'content' => function (BackendUI $bui) {
    $bui->ui()->notice(['type' => 'success', 'message' => 'Connected.']);
}]

// Footer
'footer' => [
    'left'  => function (BackendUI $bui) { $bui->ui()->paragraph(['text' => 'v1.0', 'variant' => 'muted']); },
    'right' => function (BackendUI $bui) { $bui->ui()->button(['label' => 'Save', 'type' => 'submit']); },
]
```

---

## Composition Patterns

### Card with form + footer (most common)

```php
$ui->card([
    'title' => 'API Configuration',
    'content' => function () use ($ui) {
        $ui->input(['name' => 'api_key', 'label' => 'API Key', 'type' => 'password', 'value' => get_option('api_key', '')]);
        $ui->toggle(['name' => 'sandbox', 'label' => 'Sandbox mode', 'checked' => (bool) get_option('sandbox')]);
    },
    'footer' => function () use ($ui) {
        $ui->button(['label' => 'Save Changes', 'type' => 'submit', 'variant' => 'primary']);
    },
]);
```

### Two-column grid

```php
echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--pw-layout-gap);">';
$ui->card(['title' => 'Left', 'content' => function () use ($ui) { /* ... */ }]);
$ui->card(['title' => 'Right', 'content' => function () use ($ui) { /* ... */ }]);
echo '</div>';
```

### Wizard (multi-step form)

Stepper MUST be placed OUTSIDE the `<form>`. Slugs must match exactly between `stepper()` and `data-pw-wizard-step`.

```php
$ui->stepper(['steps' => [
    ['slug' => 'account',  'label' => 'Account',  'state' => 'active'],
    ['slug' => 'settings', 'label' => 'Settings', 'state' => 'pending'],
]]);

echo '<form method="post" data-pw-wizard>';
echo '<div data-pw-wizard-step="account">';
$ui->card(['title' => 'Account', 'content' => function () use ($ui) {
    $ui->input(['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true]);
}]);
echo '<div style="display:flex;justify-content:flex-end;margin-top:var(--pw-form-gap);">';
$ui->button(['label' => 'Next', 'variant' => 'primary', 'attrs' => ['data-pw-wizard-next' => '']]);
echo '</div></div>';

echo '<div data-pw-wizard-step="settings" hidden>';
// ... fields + prev/submit buttons with data-pw-wizard-prev / data-pw-wizard-submit
echo '</div>';
echo '</form>';
```

---

## Migration: Converting Existing UI

Follow this procedure when converting a plugin's existing admin screens to pw/backend-ui.

### Step 1: Identify the render function

Find the `add_menu_page` / `add_submenu_page` callback that outputs the current UI.

### Step 2: Wrap in render_page()

Replace `<div class="wrap">` + `<h1>` + tab wrappers with a single `render_page()` call. Move title, description, and tab definitions into its config array.

### Step 3: Group fields into cards

Each logical section (previously a `<table class="form-table">`, a `<div class="postbox">`, or a group of related fields) becomes a `$ui->card(['content' => ...])`.

### Step 4: Convert elements using the mapping table

| Source pattern | pw/backend-ui replacement |
|----------------|---------------------------|
| `<input class="regular-text">` | `$ui->input([...])` |
| `<textarea>` | `$ui->textarea([...])` |
| `<select>` + `selected()` | `$ui->select(['value' => ..., 'options' => ...])` |
| `<input type="checkbox">` + `checked()` | `$ui->checkbox([...])` or `$ui->toggle([...])` |
| `submit_button()` / `<button class="button-primary">` | `$ui->button(['variant' => 'primary', 'type' => 'submit'])` in card footer |
| `<h2 class="nav-tab-wrapper">` | `render_page(['tabs' => [...]])` + `tab_panel()` |
| `<table class="form-table">` | `$ui->card()` with fields inside; or `$ui->data_table()` for read-only data |
| `<div class="postbox">` / `<div class="card">` | `$ui->card([...])` |
| `<div class="notice">` / `<div class="updated">` | `$ui->notice([...])` |
| `<h2>` / `<h3>` | `$ui->heading(['level' => 2])` |
| `<p class="description">` | `'help' => '...'` on the field, or `$ui->paragraph(['variant' => 'muted'])` |
| `<span class="badge">` / `<span class="tag">` | `$ui->badge([...])` |
| `<a>` links | `$ui->link([...])` |
| Bootstrap `.form-group` / `.form-control` | `$ui->input/select/textarea` (removes Bootstrap dep) |
| Tailwind utility divs | Keep Tailwind utilities OR use `--pw-*` tokens in inline styles |

### Step 5: Move structure into render_page keys

- Notices / help content in the sidebar → `'sidebar' => [...]`
- Save buttons → card `'footer'` closure, or page `'footer'` key
- Tab navigation → `'tabs'` + `tab_panel()` (JS mode) or `'tabs_mode' => 'url'`

### Step 6: Clean up

- Remove old CSS classes (`.wrap`, `.form-table`, `.nav-tab-wrapper`, `.postbox`, `.button-primary`)
- Remove inline styles that the design system now handles
- Keep `settings_fields()` / `wp_nonce_field()` / `do_settings_sections()` — these are WP plumbing, not UI
- Test in both dark and light themes

For a complete before/after example, see [examples.md](examples.md).

---

## Critical Rules

1. **Stepper outside `<form>`** — wizard stepper goes before `<form data-pw-wizard>`, never inside.
2. **URL tabs: no `tab_panel()`** — when `tabs_mode => 'url'`, use `if ($tab === '...')` directly.
3. **Closure pattern** — capture `$ui` with `use ($ui)`. For `render_page` callbacks: `function (BackendUI $bui)`.
4. **No `@apply`** — Tailwind CDN only; PostCSS unavailable.
5. **No jQuery** — vanilla JS. Use `data-pw-*` attributes and `pw-bui:*` events.
6. **Package does NOT persist data** — only renders UI. `get_option`/`update_option` in the consuming plugin.
7. **Package does NOT register admin pages** — use `add_menu_page`/`add_submenu_page` yourself.
8. **`screens => []` recommended** — let consuming plugin handle asset enqueue (see `wp-backend-ui-integration`).
9. **Escaping** — `esc_html()` for text, `esc_attr()` for attributes, `wp_kses_post()` for trusted HTML.
10. **BEM naming** — `pw-bui-{block}`, `pw-bui-{block}__{element}`, `pw-bui-{block}--{modifier}`.
11. **Data attributes** prefix: `data-pw-*`. JS events prefix: `pw-bui:*`.
12. **Wizard slug match** — `stepper()` slugs and `data-pw-wizard-step` values must be identical.

---

## Additional Resources

- Full component API with all `$atts` keys: [components.md](components.md)
- Layout recipes, design tokens, spacing rules, JS events, WP hooks: [layouts.md](layouts.md)
- Complete screen example + migration before/after: [examples.md](examples.md)
