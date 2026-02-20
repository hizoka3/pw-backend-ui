# Package: pw/backend-ui

**Versión:** 1.0.0
**Namespace:** `PW\BackendUI`
**Propósito:** Sistema de diseño compartido para el backend (admin) de plugins WordPress del ecosistema PW — layout, tipografía, botones, inputs, cards, tabs, notices y más. Basado en Tailwind CSS 4.

---

## Instalación

```json
"require": {
    "pw/backend-ui": "^1.0"
}
```

> Requiere que el plugin llame `BackendUI::init($config)` en el hook `plugins_loaded` o posterior.
> Package público en Packagist. No necesita repositorio VCS manual.

---

## Lo que el package expone

### Clase principal / Entry point

```php
use PW\BackendUI\BackendUI;

$bui = BackendUI::init( array $config );
```

Es un singleton. Llamadas posteriores a `init()` retornan la misma instancia.

### Métodos públicos disponibles

| Método | Parámetros | Retorna | Descripción |
|--------|------------|---------|-------------|
| `init()` | `array $config` | `self` | Inicializa el design system (singleton) |
| `playground()` | `array $options` | `void` | Registra una página de admin con todos los componentes renderizados. Solo para desarrollo. |
| `ui()` | — | `ComponentRenderer` | Accede al renderer de componentes individuales |
| `config()` | `?string $key` | `mixed` | Obtiene toda la config o un valor específico |
| `render_page()` | `array $page` | `void` | Renderiza una página completa con layout, header, tabs, sidebar y footer |
| `reset()` | — | `void` | Resetea el singleton (para testing) |

### Componentes disponibles via `ui()`

| Método | Descripción |
|--------|-------------|
| `button()` | Botón con variantes: primary, secondary, outline, ghost, danger |
| `input()` | Input de texto con label, help text, estado de error |
| `textarea()` | Textarea con label y validación |
| `select()` | Dropdown select con opciones normalizadas |
| `checkbox()` | Checkbox con label y help text |
| `toggle()` | Switch on/off interactivo |
| `card()` | Contenedor card con título, body y footer |
| `notice()` | Alerta/notificación: info, success, warning, danger |
| `badge()` | Badge/tag con variantes de color |
| `heading()` | Títulos h1-h6 con estilos consistentes |
| `paragraph()` | Párrafos con variantes: default, muted, small |
| `link()` | Enlaces con variantes: default, muted, danger |
| `separator()` | Línea divisoria horizontal |
| `tabs()` | Navegación por pestañas |
| `tab_panel()` | Panel de contenido asociado a un tab |

### Config esperada en `init()`

```php
[
    'assets_url' => plugin_dir_url(__FILE__) . 'vendor/pw/backend-ui/assets/', // requerido
    'version'    => '1.0.0',                // opcional, default: '1.0.0'
    'screens'    => ['toplevel_page_mi-plugin'], // requerido — screen IDs de WP donde cargar assets
    'slug'       => 'pw-backend-ui',         // opcional — prefijo para handles de assets
    'brand'      => [                        // opcional
        'name'     => 'Mi Plugin',
        'logo_url' => 'https://...',
    ],
]
```

### Hooks de WordPress que registra internamente

| Hook | Tipo | Prioridad | Descripción |
|------|------|-----------|-------------|
| `admin_enqueue_scripts` | action | 10 | Carga Tailwind CDN, CSS y JS del design system |
| `admin_menu` | action | 10 | Registra la página de admin del playground (solo si se llama `playground()`) |

### Hooks que expone para que el plugin extienda

| Hook | Tipo | Parámetros | Descripción |
|------|------|------------|-------------|
| `pw_bui/page_config` | filter | `array $page` | Modificar la config de página antes de renderizar |
| `pw_bui/tailwind_config` | filter | `array $config` | Personalizar la configuración de Tailwind (colores, prefix, etc.) |
| `pw_bui/enqueue_assets` | action | `string $hook, string $url, string $version` | Encolar assets adicionales junto al design system |
| `pw_bui/header_right` | action | `array $page` | Inyectar contenido a la derecha del header |

### Eventos JS disponibles

| Evento | `detail` | Descripción |
|--------|----------|-------------|
| `pw-bui:ready` | — | El design system JS se ha inicializado |
| `pw-bui:tab-changed` | `{ slug }` | Se cambió de pestaña |
| `pw-bui:toggle-changed` | `{ name, checked, value }` | Se cambió un toggle switch |

---

## Lo que el package necesita del plugin

### Interfaces que el plugin debe implementar

Ninguna obligatoria. Existe `PageConfigInterface` como contrato opcional para estructurar la config de página.

### Lo mínimo que el plugin debe hacer

```php
// 1. Inicializar en plugins_loaded
add_action( 'plugins_loaded', function() {
    BackendUI::init([
        'assets_url' => plugin_dir_url(__FILE__) . 'vendor/pw/backend-ui/assets/',
        'screens'    => [ 'toplevel_page_mi-plugin-settings' ],
    ]);
});

// 2. Usar render_page() o componentes individuales via ui()
```

---

## Playground

El playground es una página de admin incluida en el package que renderiza todos los componentes disponibles con sus variantes y estados. Sirve como referencia visual y para verificar que los assets cargan correctamente en un entorno nuevo.

### Activar el playground

Llamar `BackendUI::playground()` después de `init()`. El método registra su propia página de admin y agrega automáticamente su screen a la lista de screens que cargan assets — no hace falta modificar la config de `init()`.

```php
add_action( 'plugins_loaded', function() {
    BackendUI::init([
        'assets_url' => plugin_dir_url(__FILE__) . 'vendor/pw/backend-ui/assets/',
        'screens'    => [ 'toplevel_page_mi-plugin' ],
    ]);

    if ( defined('WP_DEBUG') && WP_DEBUG ) {
        BackendUI::playground();
    }
});
```

Aparece en el menú de WP Admin como **"PW Playground"** con el ícono de paleta de colores.

### Opciones de `playground()`

```php
BackendUI::playground([
    'capability' => 'manage_options', // capability mínima para ver la página. Default: 'manage_options'
    'menu_order' => 99,               // posición en el menú de admin. Default: 99
]);
```

### Qué muestra el playground

Está organizado en 4 tabs:

| Tab | Contenido |
|-----|-----------|
| **Buttons & Badges** | Todas las variantes de `button()` (primary, secondary, outline, ghost, danger), tamaños (sm, md, lg), estado disabled, con ícono. Todas las variantes de `badge()` en tamaños sm y md. |
| **Forms** | `input()` con estados normal, requerido, error y disabled. `textarea()` normal y con error. `select()` normal y con error. `checkbox()` y `toggle()` en estados sin marcar, marcado y disabled. |
| **Cards & Notices** | Los 4 tipos de `notice()` (info, success, warning, danger) y la variante dismissible. `card()` con descripción y footer. `card()` sin padding. |
| **Typography & Nav** | `heading()` niveles h1–h6. `paragraph()` en variantes default, muted y small. `link()` en variantes default, muted y danger. `separator()`. |

La sidebar muestra el listado de componentes disponibles y un snippet del comando de activación.

### Detalles de implementación

- **Idempotente** — llamar `playground()` múltiples veces no registra la página dos veces.
- **Screen auto-registrada** — `AssetsManager` recibe `$config` por referencia, por lo que agregar la screen del playground después del `boot()` es transparente, sin necesidad de re-registrar hooks.
- **Slug fijo** — la página siempre usa el slug `pw-bui-playground` (constante `BackendUI::PLAYGROUND_SLUG`). La URL de admin queda en `/wp-admin/admin.php?page=pw-bui-playground`.
- **`reset()` limpia el flag** — al llamar `BackendUI::reset()` en tests, el flag `$playground` también se resetea.

### Advertencia

No activar en producción. El playground expone información interna del package (versión, componentes, estructura) y agrega una entrada visible en el menú de admin. Protegerlo siempre con `WP_DEBUG` u otra condición de entorno.

---

## Restricciones y advertencias

- El package **NO** persiste datos — solo renderiza UI. El plugin es responsable de guardar/recuperar settings.
- El package **NO** registra páginas de admin — el plugin crea las páginas via `add_menu_page` / `add_submenu_page` y usa el design system para renderizar el contenido. (Excepción: la página del playground, que el package registra internamente.)
- Tailwind CSS se carga via CDN (`cdn.tailwindcss.com`). Esto es adecuado para admin backend pero **NO** para frontend.
- Todas las clases Tailwind llevan el prefijo `pw-` para evitar conflictos con los estilos del admin de WordPress.
- `screens` vacío = assets NO se cargan en ninguna pantalla (opt-in explícito).
- No tiene dependencias de otros packages del ecosistema `pw`.
- Versión mínima de PHP: `8.0`
- Versión mínima de WordPress: `6.0`
- Sin dependencia de jQuery.

---

## Ejemplo de uso completo

```php
use PW\BackendUI\BackendUI;

// 1. Inicializar en plugins_loaded
add_action( 'plugins_loaded', function() {
    BackendUI::init([
        'assets_url' => plugin_dir_url(__FILE__) . 'vendor/pw/backend-ui/assets/',
        'version'    => '1.0.0',
        'screens'    => [ 'toplevel_page_mi-plugin' ],
        'brand'      => [
            'name'     => 'Mi Plugin Pro',
            'logo_url' => plugin_dir_url(__FILE__) . 'assets/logo.svg',
        ],
    ]);

    if ( defined('WP_DEBUG') && WP_DEBUG ) {
        BackendUI::playground();
    }
});

// 2. Registrar la página de admin
add_action( 'admin_menu', function() {
    add_menu_page(
        'Mi Plugin',
        'Mi Plugin',
        'manage_options',
        'mi-plugin',
        'mi_plugin_render_page',
        'dashicons-admin-generic',
        80
    );
});

// 3. Renderizar la página usando el design system
function mi_plugin_render_page() {
    $bui = BackendUI::init();

    $bui->render_page([
        'title'       => 'Configuración',
        'description' => 'Ajustes generales del plugin.',
        'tabs'        => [
            [ 'slug' => 'general',  'label' => 'General',  'active' => true ],
            [ 'slug' => 'advanced', 'label' => 'Avanzado' ],
        ],
        'content' => function( $bui ) {
            $ui = $bui->ui();

            // Tab: General
            $ui->tab_panel([
                'slug'   => 'general',
                'active' => true,
                'content' => function() use ( $ui ) {
                    $ui->card([
                        'title'   => 'Ajustes básicos',
                        'content' => function() use ( $ui ) {
                            $ui->input([
                                'name'  => 'site_name',
                                'label' => 'Nombre del sitio',
                                'value' => get_option( 'mi_plugin_site_name', '' ),
                                'help'  => 'Se mostrará en el header.',
                            ]);
                            $ui->toggle([
                                'name'    => 'enabled',
                                'label'   => 'Activar funcionalidad',
                                'checked' => (bool) get_option( 'mi_plugin_enabled', false ),
                                'help'    => 'Habilita o deshabilita el plugin globalmente.',
                            ]);
                        },
                        'footer' => function() use ( $ui ) {
                            $ui->button([
                                'label'   => 'Guardar cambios',
                                'type'    => 'submit',
                                'variant' => 'primary',
                            ]);
                        },
                    ]);
                },
            ]);

            // Tab: Advanced
            $ui->tab_panel([
                'slug'   => 'advanced',
                'content' => function() use ( $ui ) {
                    $ui->notice([
                        'type'    => 'warning',
                        'message' => 'Estos ajustes son para usuarios avanzados.',
                    ]);
                    $ui->card([
                        'title'   => 'Configuración avanzada',
                        'content' => function() use ( $ui ) {
                            $ui->select([
                                'name'    => 'cache_ttl',
                                'label'   => 'Tiempo de caché',
                                'value'   => get_option( 'mi_plugin_cache_ttl', '3600' ),
                                'options' => [
                                    '0'     => 'Sin caché',
                                    '3600'  => '1 hora',
                                    '86400' => '24 horas',
                                ],
                            ]);
                        },
                    ]);
                },
            ]);
        },
        'sidebar' => [
            'title'   => 'Información',
            'content' => function( $bui ) {
                $ui = $bui->ui();
                $ui->card([
                    'content' => function() use ( $ui ) {
                        $ui->paragraph([ 'text' => 'Mi Plugin Pro v1.0.0' ]);
                        $ui->link([
                            'label'  => 'Documentación',
                            'href'   => 'https://docs.miplugin.com',
                            'target' => '_blank',
                        ]);
                    },
                ]);
            },
        ],
    ]);
}
```
