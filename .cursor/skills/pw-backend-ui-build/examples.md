# pw/backend-ui — Complete Examples

## Full Settings Page (tabs + sidebar + footer)

```php
use PW\BackendUI\BackendUI;

function my_pezweb_plugin_render(): void {
    $bui = BackendUI::init();

    $bui->render_page([
        'title'       => 'Plugin Settings',
        'description' => 'Configure connection and display options.',
        'tabs' => [
            ['slug' => 'connection', 'label' => 'Connection', 'active' => true],
            ['slug' => 'display',    'label' => 'Display'],
            ['slug' => 'advanced',   'label' => 'Advanced'],
        ],
        'content' => function (BackendUI $bui) {
            $ui = $bui->ui();

            // ── Tab 1: Connection ──
            $ui->tab_panel(['slug' => 'connection', 'active' => true, 'content' => function () use ($ui) {
                echo '<form method="post" action="options.php">';
                settings_fields('my_plugin_connection');

                $ui->card([
                    'title'       => 'API Credentials',
                    'description' => 'Enter your API keys to connect.',
                    'content' => function () use ($ui) {
                        $ui->input(['name' => 'api_key', 'label' => 'API Key', 'value' => get_option('api_key', ''), 'required' => true]);
                        $ui->input(['name' => 'api_secret', 'label' => 'API Secret', 'type' => 'password', 'value' => get_option('api_secret', ''), 'required' => true]);
                        $ui->select([
                            'name' => 'environment', 'label' => 'Environment',
                            'value' => get_option('environment', 'production'),
                            'options' => ['production' => 'Production', 'sandbox' => 'Sandbox'],
                        ]);
                    },
                    'footer' => function () use ($ui) {
                        $ui->button(['label' => 'Save', 'type' => 'submit', 'variant' => 'primary']);
                    },
                ]);

                echo '</form>';
            }]);

            // ── Tab 2: Display ──
            $ui->tab_panel(['slug' => 'display', 'content' => function () use ($ui) {
                echo '<form method="post" action="options.php">';
                settings_fields('my_plugin_display');
                echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--pw-layout-gap);">';

                $ui->card(['title' => 'Layout', 'content' => function () use ($ui) {
                    $ui->segmented_control([
                        'name' => 'layout_mode', 'label' => 'View Mode',
                        'value' => get_option('layout_mode', 'grid'),
                        'options' => [['value' => 'grid', 'label' => 'Grid'], ['value' => 'list', 'label' => 'List']],
                    ]);
                    $ui->input(['name' => 'items_per_page', 'label' => 'Items per page', 'type' => 'number', 'value' => get_option('items_per_page', '12'), 'min' => '1', 'max' => '100']);
                }]);

                $ui->card(['title' => 'Colors', 'content' => function () use ($ui) {
                    $ui->input(['name' => 'accent_color', 'label' => 'Accent Color', 'type' => 'color', 'value' => get_option('accent_color', '#dd0000')]);
                    $ui->toggle(['name' => 'show_badges', 'label' => 'Show status badges', 'checked' => (bool) get_option('show_badges', true)]);
                }]);

                echo '</div>';
                echo '<div style="margin-top:var(--pw-form-gap);display:flex;justify-content:flex-end;">';
                $ui->button(['label' => 'Save Display Settings', 'type' => 'submit', 'variant' => 'primary']);
                echo '</div></form>';
            }]);

            // ── Tab 3: Advanced ──
            $ui->tab_panel(['slug' => 'advanced', 'content' => function () use ($ui) {
                $ui->notice(['type' => 'warning', 'title' => 'Caution', 'message' => 'These settings may affect performance.']);
                $ui->card(['title' => 'Debug', 'content' => function () use ($ui) {
                    $ui->toggle(['name' => 'debug_mode', 'label' => 'Enable debug logging']);
                    $ui->toggle(['name' => 'cache', 'label' => 'Enable response cache', 'checked' => true]);
                }]);
                $ui->card(['title' => 'System Info', 'content' => function () use ($ui) {
                    $ui->data_table([
                        'headers' => ['Key', 'Value'],
                        'rows' => [['PHP Version', PHP_VERSION], ['WordPress', get_bloginfo('version')]],
                    ]);
                }]);
            }]);
        },
        'sidebar' => [
            'title'   => 'Status',
            'content' => function (BackendUI $bui) {
                $ui = $bui->ui();
                $ui->notice(['type' => 'success', 'message' => 'Connected to API.']);
                $ui->separator();
                $ui->paragraph(['text' => 'Last sync: 2 minutes ago', 'variant' => 'muted']);
            },
        ],
        'footer' => [
            'left'  => function (BackendUI $bui) { $bui->ui()->paragraph(['text' => 'v1.4.0', 'variant' => 'muted']); },
            'right' => function (BackendUI $bui) { $bui->ui()->link(['label' => 'Docs', 'href' => 'https://docs.pezweb.cl', 'target' => '_blank']); },
        ],
    ]);
}
```

---

## Migration: Before / After

### BEFORE — typical WP Settings API page

```php
function my_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>My Plugin Settings</h1>
        <p class="description">Configure your plugin options.</p>

        <h2 class="nav-tab-wrapper">
            <a href="#general" class="nav-tab nav-tab-active">General</a>
            <a href="#display" class="nav-tab">Display</a>
        </h2>

        <form method="post" action="options.php">
            <?php settings_fields('my_plugin_options'); ?>

            <table class="form-table">
                <tr>
                    <th><label for="api_key">API Key</label></th>
                    <td>
                        <input type="text" id="api_key" name="api_key"
                               value="<?php echo esc_attr(get_option('api_key')); ?>"
                               class="regular-text" required>
                        <p class="description">Your API key from the dashboard.</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="mode">Mode</label></th>
                    <td>
                        <select name="mode" id="mode">
                            <option value="live" <?php selected(get_option('mode'), 'live'); ?>>Live</option>
                            <option value="test" <?php selected(get_option('mode'), 'test'); ?>>Test</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Enable cache</th>
                    <td>
                        <label>
                            <input type="checkbox" name="cache" value="1"
                                   <?php checked(get_option('cache')); ?>>
                            Enable response caching
                        </label>
                    </td>
                </tr>
            </table>

            <?php submit_button('Save Changes'); ?>
        </form>

        <div class="notice notice-info">
            <p>Need help? Visit our <a href="https://docs.example.com">documentation</a>.</p>
        </div>
    </div>
    <?php
}
```

### AFTER — migrated to pw/backend-ui

```php
use PW\BackendUI\BackendUI;

function my_plugin_settings_page(): void {
    $bui = BackendUI::init();

    $bui->render_page([
        'title'       => 'My Plugin Settings',
        'description' => 'Configure your plugin options.',
        'tabs' => [
            ['slug' => 'general', 'label' => 'General', 'active' => true],
            ['slug' => 'display', 'label' => 'Display'],
        ],
        'content' => function (BackendUI $bui) {
            $ui = $bui->ui();

            $ui->tab_panel(['slug' => 'general', 'active' => true, 'content' => function () use ($ui) {
                echo '<form method="post" action="options.php">';
                settings_fields('my_plugin_options');

                $ui->card([
                    'title' => 'General Settings',
                    'content' => function () use ($ui) {
                        $ui->input([
                            'name'  => 'api_key',
                            'label' => 'API Key',
                            'value' => get_option('api_key', ''),
                            'help'  => 'Your API key from the dashboard.',
                            'required' => true,
                        ]);
                        $ui->select([
                            'name'    => 'mode',
                            'label'   => 'Mode',
                            'value'   => get_option('mode', 'live'),
                            'options' => ['live' => 'Live', 'test' => 'Test'],
                        ]);
                        $ui->toggle([
                            'name'    => 'cache',
                            'label'   => 'Enable response caching',
                            'checked' => (bool) get_option('cache'),
                        ]);
                    },
                    'footer' => function () use ($ui) {
                        $ui->button(['label' => 'Save Changes', 'type' => 'submit', 'variant' => 'primary']);
                    },
                ]);

                echo '</form>';
            }]);

            $ui->tab_panel(['slug' => 'display', 'content' => function () use ($ui) {
                $ui->card(['title' => 'Display Settings', 'content' => function () use ($ui) {
                    $ui->paragraph(['text' => 'Display configuration goes here.', 'variant' => 'muted']);
                }]);
            }]);
        },
        'sidebar' => [
            'title'   => 'Help',
            'content' => function (BackendUI $bui) {
                $bui->ui()->notice(['type' => 'info', 'message' => 'Need help? Visit our documentation.']);
                $bui->ui()->link(['label' => 'Documentation', 'href' => 'https://docs.example.com', 'target' => '_blank']);
            },
        ],
    ]);
}
```

### What changed

| Before (WP native) | After (pw/backend-ui) |
|--------------------|-----------------------|
| `<div class="wrap">` + `<h1>` | `render_page(['title' => '...'])` |
| `<h2 class="nav-tab-wrapper">` | `render_page(['tabs' => [...]])` + `tab_panel()` |
| `<table class="form-table">` + `<tr><th><td>` | `$ui->card(['content' => ...])` with component methods |
| `<input class="regular-text">` | `$ui->input([...])` |
| `<select>` + `selected()` | `$ui->select(['value' => ..., 'options' => ...])` |
| `<input type="checkbox">` + `checked()` | `$ui->toggle(['checked' => ...])` |
| `<p class="description">` | `'help' => '...'` key on input, or `$ui->paragraph(['variant' => 'muted'])` |
| `submit_button()` | `$ui->button(['type' => 'submit', 'variant' => 'primary'])` in card footer |
| `<div class="notice notice-info">` | `$ui->notice(['type' => 'info'])` in sidebar |
| Manual `<a>` links | `$ui->link([...])` |
| `settings_fields()` | Kept as-is (WP plumbing, not UI) |
