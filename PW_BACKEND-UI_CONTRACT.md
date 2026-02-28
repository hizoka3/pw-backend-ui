# Package: pw/backend-ui

**Versión:** 1.4.0  
**Namespace:** `PW\BackendUI`  
**Propósito:** Sistema de diseño compartido para el backend (admin) de plugins WordPress del ecosistema PW. Inspirado en Primer (GitHub). Tema dark por defecto, con soporte light switcheable desde el header. Paleta de colores PW (negro/rojo). CSS con custom properties + Tailwind CDN.

---

## Instalación

```json
"require": { "pw/backend-ui": "dev-main" }
```

> Requiere que el plugin llame `BackendUI::init($config)` en el hook `plugins_loaded` o posterior.

---

## Lo que el package expone

### Clase principal / Entry point

```php
use PW\BackendUI\BackendUI;

$bui = BackendUI::init( array $config );
```

Es un singleton. Llamadas posteriores a `init()` retornan la misma instancia.

### Métodos públicos

| Método | Parámetros | Retorna | Descripción |
|--------|------------|---------|-------------|
| `init()` | `array $config` | `self` | Inicializa el design system (singleton) |
| `ui()` | — | `ComponentRenderer` | Accede al renderer de componentes |
| `config()` | `?string $key` | `mixed` | Obtiene toda la config o un valor específico |
| `render_page()` | `array $page` | `void` | Renderiza página completa con layout |
| `playground()` | `array $opts` | `void` | Registra página de dev con todos los componentes |
| `reset()` | — | `void` | Resetea el singleton (para testing) |

### Config esperada en `init()`

```php
BackendUI::init([
    'assets_url' => plugin_dir_url(__FILE__) . 'vendor/pw/backend-ui/assets/', // requerido
    'version'    => '1.4.0',
    'screens'    => ['toplevel_page_mi-plugin'],  // requerido — screen IDs de WP
    'slug'       => 'pw-backend-ui',              // prefijo para handles de assets
    'brand'      => [
        'name'     => 'Mi Plugin',
        'logo_url' => '',
    ],
]);
```

### `render_page()` — keys disponibles

| Key | Tipo | Descripción |
|-----|------|-------------|
| `title` | string | Título de la página |
| `description` | string | Descripción breve bajo el título |
| `tabs` | array | Definición de tabs (ver sección Tabs) |
| `tabs_mode` | string | `'js'` (default) \| `'url'` |
| `content` | callable | `function( $bui ) {}` — cuerpo de la página |
| `sidenav` | array\|callable | Activa layout con navegación lateral |
| `sidebar` | array | Columna derecha con `title` y `content` callable |
| `footer` | array | Footer con `left` y `right` callables |

---

## Componentes disponibles via `ui()`

### Acciones / Botones
| Método | Descripción |
|--------|-------------|
| `button()` | Botón: primary, secondary, outline, ghost, danger, invisible. Acepta `href` → renderiza `<a>`. |

### Formularios
| Método | Descripción |
|--------|-------------|
| `input()` | Input: text, email, password, url, number, date, search |
| `date_input()` | Alias de input() con type='date' |
| `textarea()` | Textarea con label y validación |
| `select()` | Select dropdown. Acepta `wrapper_class` para clases en el div padre. |
| `checkbox()` | Checkbox individual |
| `toggle()` | Switch on/off |
| `radio()` | Radio button individual |
| `radio_group()` | Grupo de radio buttons con legend |
| `segmented_control()` | Selector de opciones mutuamente excluyentes |

### Contenido / Estructura
| Método | Descripción |
|--------|-------------|
| `card()` | Contenedor con header, body y footer |
| `notice()` | Alerta/banner: info, success, warning, danger |
| `badge()` | Badge/tag: default, primary, success, warning, danger, info |
| `separator()` | Línea divisoria |

### Feedback / Estado
| Método | Descripción |
|--------|-------------|
| `spinner()` | Indicador de carga indeterminado |
| `progress_bar()` | Barra de progreso con variantes de color |
| `skeleton()` | Placeholder de carga: text, title, box, avatar |
| `tooltip()` | Tooltip sobre hover/focus |

### Tipografía
| Método | Descripción |
|--------|-------------|
| `heading()` | Títulos h1-h6 |
| `paragraph()` | Párrafos: default, muted, small |
| `link()` | Enlace: default, muted, danger |

### Navegación
| Método | Descripción |
|--------|-------------|
| `tabs()` | Navegación UnderlineNav. Soporta `count` y `mode` (`'js'` \| `'url'`) |
| `tab_panel()` | Panel de contenido asociado a un tab (solo mode `'js'`) |
| `breadcrumbs()` | Migas de pan |
| `pagination()` | Control de paginación con gaps |
| `side_nav()` | Navegación vertical tipo WP Settings (grupos, separators, active) |
| `stepper()` | Indicador visual de progreso para formularios multi-paso (wizard) |

---

## Hooks de WordPress

### Hooks que registra internamente

| Hook | Tipo | Descripción |
|------|------|-------------|
| `admin_enqueue_scripts` | action | Carga Tailwind CDN + CSS + JS del design system |

### Hooks que expone para que el plugin extienda

| Hook | Tipo | Parámetros | Descripción |
|------|------|------------|-------------|
| `pw_bui/page_config` | filter | `array $page` | Modificar config de página antes de renderizar |
| `pw_bui/enqueue_assets` | action | `string $hook, string $url, string $version` | Encolar assets adicionales |
| `pw_bui/header_right` | action | `array $page` | Inyectar contenido a la derecha del header |

### Eventos JS

| Evento | `detail` | Descripción |
|--------|----------|-------------|
| `pw-bui:ready` | — | El JS se ha inicializado |
| `pw-bui:theme-changed` | `{ theme }` | Se cambió el tema ('dark' \| 'light') |
| `pw-bui:tab-changed` | `{ slug }` | Se cambió de pestaña (solo mode `'js'`) |
| `pw-bui:toggle-changed` | `{ name, checked, value }` | Se cambió un toggle switch |
| `pw-bui:segment-changed` | `{ name, value }` | Se cambió una opción en segmented control |
| `pw-bui:wizard-step-changed` | `{ from, to, index }` | Se avanzó o retrocedió un paso del wizard |

---

## Sistema de temas

El tema se controla mediante el atributo `data-pw-theme` en el wrapper `#pw-backend-ui-app`.

- **Dark** (default): `data-pw-theme="dark"`
- **Light**: `data-pw-theme="light"`

El botón de toggle en el header cambia el tema y persiste la preferencia en `localStorage` bajo la clave `pw-bui-theme`. Un script inline bloqueante en `page-wrapper.php` aplica el tema guardado antes del primer paint para evitar el flash dark→light en recarga.

```js
document.addEventListener('pw-bui:theme-changed', function(e) {
    console.log('Nuevo tema:', e.detail.theme); // 'dark' | 'light'
});
```

---

## Tailwind CSS

El package carga Tailwind CDN automáticamente en las screens configuradas. Está disponible tanto para los componentes del package como para los plugins consumidores.

- Usar clases estándar de Tailwind (sin prefijo) en los plugins consumidores
- `@apply` **no está disponible** — requiere build process, no aplica con CDN
- El CDN escanea clases en runtime, no requiere configuración adicional

---

## Tabs — modos de navegación

### Modo JS (default)

Tabs client-side. El JS muestra/oculta `tab_panel()` al hacer click.

```php
$bui->render_page([
    'tabs' => [
        [ 'slug' => 'general',  'label' => 'General',  'active' => true ],
        [ 'slug' => 'advanced', 'label' => 'Avanzado' ],
    ],
    'content' => function( $bui ) {
        $bui->ui()->tab_panel([ 'slug' => 'general',  'active' => true, 'content' => fn() => '...' ]);
        $bui->ui()->tab_panel([ 'slug' => 'advanced', 'content' => fn() => '...' ]);
    },
]);
```

### Modo URL

Tabs server-side. Cada tab es un `<a href>`. No usa `tab_panel()`.

```php
$tab = sanitize_key( $_GET['tab'] ?? 'datos' );

$bui->render_page([
    'tabs' => [
        [ 'slug' => 'datos',   'label' => 'Datos',   'href' => add_query_arg('tab', 'datos',   $base_url), 'active' => $tab === 'datos' ],
        [ 'slug' => 'alumnos', 'label' => 'Alumnos', 'href' => add_query_arg('tab', 'alumnos', $base_url), 'active' => $tab === 'alumnos' ],
    ],
    'tabs_mode' => 'url',
    'content'   => function( $bui ) use ( $tab ) {
        if ( $tab === 'datos' )   { /* render datos */ }
        if ( $tab === 'alumnos' ) { /* render alumnos */ }
    },
]);
```

---

## `button()` — referencia completa

| Key | Aplica a | Descripción |
|-----|----------|-------------|
| `label` | ambos | Texto visible del botón |
| `href` | `<a>` | URL de destino. Si está presente, renderiza `<a>` |
| `target` | `<a>` | Atributo target (`_blank`, etc.) |
| `type` | `<button>` | `button` (default), `submit`, `reset` |
| `variant` | ambos | `primary`, `secondary`, `outline`, `ghost`, `danger`, `invisible` |
| `icon` | ambos | HTML/SVG renderizado antes del label |
| `disabled` | `<button>` | Solo aplica en `<button>` |
| `class` | ambos | Clases CSS adicionales |
| `attrs` | ambos | Array de atributos HTML arbitrarios. Ej: `['data-pw-wizard-next' => '']` |

---

## `select()` — referencia completa

| Key | Descripción |
|-----|-------------|
| `name` | Nombre del campo (requerido) |
| `label` | Etiqueta visible |
| `options` | Array de opciones: `['value' => 'label']` o `[['value' => '', 'label' => '']]` |
| `value` | Valor seleccionado actualmente |
| `placeholder` | Opción vacía inicial |
| `required` | Marca como requerido |
| `disabled` | Deshabilita el select |
| `class` | Clases en el `<select>` |
| `wrapper_class` | Clases en el `<div class="pw-bui-form-group">` padre |
| `error` | Mensaje de error |
| `help` | Texto de ayuda |

---

## Compatibilidad con WP_List_Table

El package normaliza automáticamente `WP_List_Table` para respetar el tema activo:

- Colores de tabla (thead, tbody, tfoot, striping, hover)
- Links y row-actions
- Bulk actions: select + botón Apply en la misma línea
- Search box nativo (`search_box()`) con input y botón en la misma línea
- Paginación nativa: input `current-page` con ancho correcto
- Botones `.button` de WP adaptados al tema dark/light

**Uso estándar:**

```php
// Agregar margin-top al contenedor para separar del contenido anterior
echo '<div style="margin-top:16px;">';
echo '<form method="get" style="overflow:hidden;">';
echo '<input type="hidden" name="page" value="mi-pagina">';
echo '<input type="hidden" name="tab"  value="mi-tab">';
$table->search_box( 'Buscar', 'mi-tabla' );
$table->display();
echo '</form>';
echo '</div>';
```

---

## Wizard y Stepper — formularios multi-paso

Combina el componente PHP `stepper()` (indicador visual) con el JS (`backend-ui.js`).

### Estructura HTML esperada

```
[data-pw-stepper]              ← stepper(), FUERA del form
  [data-pw-step="slug"]

<form data-pw-wizard>
  [data-pw-wizard-step="slug"] ← panel de cada paso
    [required]                 ← validados antes de avanzar
    [data-pw-wizard-next]      ← botón avanzar
    [data-pw-wizard-prev]      ← botón retroceder
    [data-pw-wizard-submit]    ← botón submit (solo último paso)
```

> El stepper debe estar **fuera del `<form>`** pero dentro del `.pw-bui-page-wrapper`.  
> Los slugs en `stepper()` deben coincidir exactamente con los valores de `data-pw-wizard-step`.

### `stepper()` — uso

```php
$ui->stepper([
    'steps' => [
        [ 'slug' => 'paso-1', 'label' => 'Datos',    'state' => 'active'  ],
        [ 'slug' => 'paso-2', 'label' => 'Empresa',  'state' => 'pending' ],
        [ 'slug' => 'paso-3', 'label' => 'Confirmar','state' => 'pending' ],
    ],
]);
```

### Botones de navegación

```php
$ui->button(['label' => 'Siguiente →', 'variant' => 'primary', 'attrs' => ['data-pw-wizard-next'   => '']]);
$ui->button(['label' => '← Anterior',  'variant' => 'ghost',   'attrs' => ['data-pw-wizard-prev'   => '']]);
$ui->button(['label' => 'Guardar', 'type' => 'submit', 'variant' => 'primary', 'attrs' => ['data-pw-wizard-submit' => '']]);
```

### Validación de checkboxes

```html
<div data-pw-wizard-require-check="Debes seleccionar al menos uno.">
    <input type="checkbox" name="ids[]" value="1">
</div>
```

---

## Tokens de color (CSS custom properties)

| Token | Dark | Light | Uso |
|-------|------|-------|-----|
| `--pw-color-bg-default` | `#000000` | `#ffffff` | Fondo principal |
| `--pw-color-bg-subtle` | `#0a0a0a` | `#f6f8fa` | Cards, surfaces |
| `--pw-color-bg-inset` | `#111111` | `#f0f2f5` | Inputs, thead |
| `--pw-color-bg-overlay` | `#161616` | `#ffffff` | Hover, overlays |
| `--pw-color-bg-emphasis` | `#333333` | `#e6e9ed` | Botones secundarios |
| `--pw-color-border-default` | `#161616` | `#d0d7de` | Líneas divisoras |
| `--pw-color-border-emphasis` | `#333333` | `#adb5bd` | Bordes con presencia |
| `--pw-color-fg-default` | `#fafafa` | `#1c2128` | Texto principal |
| `--pw-color-fg-muted` | `#6d6d6d` | `#57606a` | Texto secundario |
| `--pw-color-fg-subtle` | `#444444` | `#8c959f` | Texto muy tenue |
| `--pw-color-accent-fg` | `#ff0000` | `#ff0000` | Rojo PW (brand) |
| `--pw-color-accent-emphasis` | `#cc0000` | `#cc0000` | Rojo hover |
| `--pw-color-success-fg` | `#3fb950` | `#1a7f37` | Verde éxito |
| `--pw-color-warning-fg` | `#d29922` | `#9a6700` | Amarillo advertencia |
| `--pw-color-danger-fg` | `#f85149` | `#d1242f` | Rojo peligro |
| `--pw-color-info-fg` | `#58a6ff` | `#0969da` | Azul info / links |

---

## Layout con Side Nav

```php
$bui->render_page([
    'tabs'    => [ ['slug' => 'config', 'label' => 'Configuración', 'active' => true] ],
    'sidenav' => [
        'items' => [
            [ 'label' => 'Conexión',  'href' => '#', 'active' => true ],
            [ 'label' => 'Proyectos', 'href' => '#' ],
            [ 'separator' => true ],
            [ 'group' => 'Avanzado' ],
            [ 'label' => 'Logs',      'href' => '#' ],
        ],
    ],
    'content' => function( $bui ) { /* ... */ },
]);
```

### `side_nav()` — estructura de items

| Key | Tipo | Descripción |
|-----|------|-------------|
| `label` | string | Texto del item |
| `href` | string | URL (renderiza `<a>`). Sin href → `<button>` |
| `active` | bool | Estado activo (borde rojo izquierdo) |
| `icon` | string | HTML/SVG opcional antes del label |
| `group` | string | Si existe, renderiza como encabezado de grupo |
| `separator` | true | Renderiza línea divisoria horizontal |

---

## Lo que el package necesita del plugin

```php
// 1. Inicializar
BackendUI::init([
    'assets_url' => plugin_dir_url(__FILE__) . 'vendor/pw/backend-ui/assets/',
    'screens'    => [ 'toplevel_page_mi-plugin-settings' ],
]);

// 2. Registrar la página de admin
add_action( 'admin_menu', function() {
    add_menu_page( 'Mi Plugin', 'Mi Plugin', 'manage_options', 'mi-plugin', 'mi_plugin_render_page' );
});

// 3. Renderizar
function mi_plugin_render_page() {
    BackendUI::init()->render_page([
        'title'   => 'Mi Plugin',
        'content' => function( $bui ) {
            $bui->ui()->card([
                'title'   => 'Configuración',
                'content' => function() use ( $bui ) {
                    $bui->ui()->input([ 'name' => 'campo', 'label' => 'Campo' ]);
                },
            ]);
        },
    ]);
}
```

---

## Restricciones y advertencias

- El package **NO** persiste datos — solo renderiza UI.
- El package **NO** registra páginas de admin.
- `screens` vacío = assets NO se cargan en ninguna pantalla (opt-in explícito).
- No tiene dependencias de jQuery.
- PHP mínimo: 8.0. WordPress mínimo: 6.0.
- Los tabs en `mode: 'url'` **no usan `tab_panel()`**.
- El componente `button()` con `href` no soporta `disabled`.
- El **stepper debe estar fuera del `<form>`**.
- Los slugs de `stepper()` y `data-pw-wizard-step` **deben coincidir exactamente**.

---

## Playground

```php
// Solo en entornos de desarrollo
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    BackendUI::playground();
}
```

Muestra todos los componentes en acción. Debe llamarse después de `init()`.
