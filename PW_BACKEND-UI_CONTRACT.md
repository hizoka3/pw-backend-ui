# Package: pw/backend-ui

**Versión:** 2.0.0
**Namespace:** `PW\BackendUI`
**Propósito:** Sistema de diseño para el backend (admin) de plugins WordPress del ecosistema PW. Token-based, dark/light theme, inspirado en GitHub Primer. Sin Tailwind CDN — CSS propio con custom properties.

---

## Instalación

```json
"require": {
    "pw/backend-ui": "^2.0"
}
```

---

## Lo que el package expone

### Entry point

```php
use PW\BackendUI\BackendUI;

$bui = BackendUI::init( array $config );
```

Singleton. Llamadas posteriores a `init()` retornan la misma instancia.

### Métodos públicos de BackendUI

| Método | Parámetros | Retorna | Descripción |
|--------|------------|---------|-------------|
| `init()` | `array $config` | `self` | Inicializa el design system (singleton) |
| `ui()` | — | `ComponentRenderer` | Accede al renderer de componentes |
| `config()` | `?string $key` | `mixed` | Obtiene la config o un valor específico |
| `render_page()` | `array $page` | `void` | Renderiza una página completa con layout |
| `playground()` | `array $options` | `void` | (static) Registra la página de playground |
| `reset()` | — | `void` | Resetea el singleton — solo para testing |

### Config en `init()`

```php
BackendUI::init([
    'assets_url' => plugin_dir_url(__FILE__) . 'vendor/pw/backend-ui/assets/', // requerido
    'version'    => '2.0.0',
    'screens'    => [ 'toplevel_page_mi-plugin' ],  // requerido
    'slug'       => 'pw-backend-ui',
    'theme'      => 'dark',   // 'dark' (default) | 'light'
    'brand'      => [
        'name'     => 'Mi Plugin',
        'logo_url' => '',     // opcional — si vacío se usa solo el logomark rojo PW
    ],
]);
```

---

## Componentes disponibles via `ui()`

### Botones y acciones

| Método | Descripción |
|--------|-------------|
| `button()` | Botón: primary, default, ghost, danger, invisible. Soporta icon + label. |
| `tooltip()` | Wrapper con tooltip CSS-driven (top/bottom). |

### Formularios

| Método | Descripción |
|--------|-------------|
| `input()` | Input texto / email / password / number / url con label, help, error. |
| `date_input()` | Input date / datetime-local / time. |
| `textarea()` | Textarea con label y validación. |
| `select()` | Dropdown select con opciones normalizadas. |
| `checkbox()` | Checkbox individual. |
| `checkbox_group()` | Grupo de checkboxes (name[]). |
| `radio()` | Radio button individual. |
| `radio_group()` | Grupo de radio buttons (fieldset). |
| `toggle()` | Switch on/off interactivo. |
| `segmented_control()` | Selector de opción única tipo SegmentedControl de Primer. |

### Layout y contenedores

| Método | Descripción |
|--------|-------------|
| `card()` | Contenedor card con header (title + description + header_right), body y footer. |

### Feedback y estado

| Método | Descripción |
|--------|-------------|
| `banner()` | Mensaje destacado full-width con título opcional. info/success/warning/danger. |
| `notice()` | Alerta inline con borde izquierdo. info/success/warning/danger. |
| `badge()` | Badge/tag con variantes de color y dot opcional. |
| `spinner()` | Indicador de carga (sm/md/lg). |
| `progress_bar()` | Barra de progreso 0-100% con variantes de color. |

### Navegación

| Método | Descripción |
|--------|-------------|
| `breadcrumbs()` | Navegación breadcrumb tipo Primer. |
| `pagination()` | Paginación con rango de páginas y gaps. Link-based o button-based. |
| `tabs()` | Barra de tabs standalone (dentro de content). |
| `tab_panel()` | Panel de contenido de un tab. |

### Tipografía

| Método | Descripción |
|--------|-------------|
| `heading()` | Headings h1-h6 con estilos consistentes. |
| `paragraph()` | Párrafos: default, muted, small. |
| `link()` | Enlace: default, muted. |
| `separator()` | Línea divisoria horizontal. |

---

## Tema dark / light

El sistema soporta dos temas: **dark** (por defecto) y **light**.

### Configuración del tema por defecto

```php
BackendUI::init([ 'theme' => 'dark' ]);  // o 'light'
```

### Toggle en runtime

El header del plugin incluye un botón ☀️/🌙 que el usuario final puede usar para cambiar el tema en su sesión. La preferencia se persiste en `localStorage` bajo la clave `pw-bui-theme`.

### Implementación

Los temas se implementan con **CSS custom properties** en `backend-ui.css`. El atributo `data-pw-theme="dark|light"` en `#pw-backend-ui-app` activa el set de tokens correspondiente.

```css
/* Dark (default) */
:root, [data-pw-theme="dark"] {
    --pw-bg-canvas: #000000;
    --pw-fg-default: #fafafa;
    ...
}

/* Light */
[data-pw-theme="light"] {
    --pw-bg-canvas: #ffffff;
    --pw-fg-default: #1f2328;
    ...
}
```

### Tokens disponibles

| Token | Uso |
|-------|-----|
| `--pw-bg-canvas` | Fondo de página |
| `--pw-bg-default` | Fondo base |
| `--pw-bg-subtle` | Fondo sutil (sidebar, card header bg) |
| `--pw-bg-component` | Fondo de componentes/cards |
| `--pw-bg-input` | Fondo de inputs |
| `--pw-bg-button` | Fondo de botones default |
| `--pw-fg-default` | Texto principal |
| `--pw-fg-muted` | Texto secundario |
| `--pw-fg-subtle` | Texto muy sutil |
| `--pw-border-default` | Borde estándar |
| `--pw-border-input` | Borde de inputs |
| `--pw-border-input-focus` | Borde focus (= accent = rojo) |
| `--pw-accent` | Color de marca = #ff0000 |
| `--pw-accent-hover` | #cc0000 |
| `--pw-radius` | Border radius global = 2px |
| `--pw-success-fg/bg/border` | Semántico success |
| `--pw-warning-fg/bg/border` | Semántico warning |
| `--pw-danger-fg/bg/border` | Semántico danger |
| `--pw-info-fg/bg/border` | Semántico info |

---

## Layout

El layout es **full-bleed, sin border-radius**. Se monta directamente sobre el área de contenido de WP admin sin márgenes laterales propios.

```
┌────────────────────────────────────────────────┐
│  HEADER (negro #000)  [logo PW]   [slot] [☀️]  │  sticky top: 32px
├────────────────────────────────────────────────┤
│  TABS (underline nav style)                    │  opcional
├────────────────────────────────────────────────┤
│  BODY                                          │
│  ┌─────────────────────┐  ┌──────────────┐     │
│  │  MAIN CONTENT       │  │  SIDEBAR     │     │  opcional
│  └─────────────────────┘  └──────────────┘     │
├────────────────────────────────────────────────┤
│  FOOTER  [left]                     [right]    │  opcional
└────────────────────────────────────────────────┘
```

### Header

- Siempre negro (`#000000`) en ambos temas.
- Logo PW: cuadrado rojo `#ff0000` con letra P en blanco.
- Si `brand.name` está definido, se muestra junto al logo.
- Si `page.title` está definido, aparece junto al brand con separador `/`.
- Slot derecho: hook `pw_bui/header_right` + botón de tema.

### render_page() — opciones

```php
$bui->render_page([
    'title'       => 'Page title',
    'description' => 'Short description',
    'tabs'        => [
        [ 'slug' => 'general', 'label' => 'General', 'active' => true ],
        [ 'slug' => 'advanced','label' => 'Advanced', 'count' => 3 ],
    ],
    'content' => function( $bui ) { /* ... */ },
    'sidebar' => [
        'title'   => 'Sidebar heading',
        'content' => function( $bui ) { /* ... */ },
    ],
    'footer' => [
        'left'  => function( $bui ) { /* ... */ },
        'right' => function( $bui ) { /* ... */ },
    ],
]);
```

---

## Hooks de WordPress

### Hooks internos (registrados por el package)

| Hook | Tipo | Descripción |
|------|------|-------------|
| `admin_enqueue_scripts` | action / 10 | Carga CSS y JS del design system |

### Hooks expuestos (para el plugin consumidor)

| Hook | Tipo | Parámetros | Descripción |
|------|------|------------|-------------|
| `pw_bui/page_config` | filter | `array $page` | Modificar config de página antes de renderizar |
| `pw_bui/enqueue_assets` | action | `$hook, $url, $version` | Encolar assets adicionales |
| `pw_bui/header_right` | action | `array $page` | Inyectar contenido al slot derecho del header |

---

## Eventos JS

| Evento | `detail` | Descripción |
|--------|----------|-------------|
| `pw-bui:ready` | — | Design system JS inicializado |
| `pw-bui:theme-changed` | `{ theme }` | Se cambió el tema |
| `pw-bui:tab-changed` | `{ slug }` | Se cambió de pestaña |
| `pw-bui:toggle-changed` | `{ name, checked, value }` | Se cambió un toggle |
| `pw-bui:segmented-changed` | `{ name, value }` | Se cambió un segmented control |

---

## Playground

```php
// Solo en desarrollo
if ( defined('WP_DEBUG') && WP_DEBUG ) {
    BackendUI::playground();
}
```

Registra la página admin `pw-bui-playground` con todos los componentes en una interfaz interactiva. Assets se cargan automáticamente. Tabs: Buttons & Badges, Forms, Feedback, Navigation, Typography.

---

## Restricciones

- El package **NO** persiste datos — solo renderiza UI.
- El package **NO** registra páginas de admin del plugin.
- Sin Tailwind CDN — los estilos son CSS custom properties en `backend-ui.css`.
- `screens` vacío = assets NO se cargan (opt-in explícito).
- El header **siempre es negro** en ambos temas — es la identidad PW.
- Layout y header sin `border-radius`.
- PHP 8.0+ / WordPress 6.0+. Sin jQuery.

---

## Ejemplo de uso completo

```php
use PW\BackendUI\BackendUI;

add_action( 'plugins_loaded', function() {
    BackendUI::init([
        'assets_url' => plugin_dir_url(__FILE__) . 'vendor/pw/backend-ui/assets/',
        'version'    => '2.0.0',
        'screens'    => [ 'toplevel_page_mi-plugin' ],
        'theme'      => 'dark',
        'brand'      => [ 'name' => 'Mi Plugin Pro' ],
    ]);
});

add_action( 'admin_menu', function() {
    add_menu_page( 'Mi Plugin', 'Mi Plugin', 'manage_options', 'mi-plugin',
        'mi_plugin_render_page', 'dashicons-admin-generic', 80 );
});

function mi_plugin_render_page() {
    $bui = BackendUI::init();
    $ui  = $bui->ui();

    $bui->render_page([
        'title' => 'Settings',
        'tabs'  => [
            [ 'slug' => 'general',  'label' => 'General',  'active' => true ],
            [ 'slug' => 'advanced', 'label' => 'Advanced' ],
        ],
        'content' => function( $bui ) use ( $ui ) {

            $ui->tab_panel([
                'slug'   => 'general',
                'active' => true,
                'content' => function() use ( $ui ) {
                    $ui->card([
                        'title'   => 'Basic settings',
                        'content' => function() use ( $ui ) {
                            $ui->input([
                                'name'  => 'site_name',
                                'label' => 'Site name',
                                'value' => get_option( 'mi_plugin_site_name', '' ),
                            ]);
                            $ui->toggle([
                                'name'    => 'enabled',
                                'label'   => 'Enable plugin',
                                'checked' => (bool) get_option( 'mi_plugin_enabled' ),
                            ]);
                        },
                        'footer' => function() use ( $ui ) {
                            $ui->button([ 'label' => 'Save', 'type' => 'submit', 'variant' => 'primary' ]);
                        },
                    ]);
                },
            ]);

            $ui->tab_panel([
                'slug'    => 'advanced',
                'content' => function() use ( $ui ) {
                    $ui->banner([ 'type' => 'warning', 'message' => 'Advanced settings — proceed with care.' ]);
                    $ui->card([
                        'title'   => 'Cache settings',
                        'content' => function() use ( $ui ) {
                            $ui->select([
                                'name'    => 'cache_ttl',
                                'label'   => 'Cache TTL',
                                'value'   => get_option( 'mi_plugin_cache_ttl', '3600' ),
                                'options' => [ '0' => 'Off', '3600' => '1 hour', '86400' => '24 hours' ],
                            ]);
                        },
                    ]);
                },
            ]);
        },
    ]);
}
```
