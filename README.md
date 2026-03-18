# pw/backend-ui

Sistema de diseño compartido para el admin de WordPress. Proporciona un layout completo (header, tabs, body, sidebar, footer) y componentes reutilizables listos para usar en plugins del ecosistema PW.

**Versión:** 1.4.0 (dev-main)
**Requiere:** PHP 8.0+ · WordPress 6.0+
**Repositorio:** https://github.com/pez-web/backend-ui

---

## Instalación

```json
"require": { "pw/backend-ui": "dev-main" }
```

```bash
composer install
```

---

## Inicio rápido

```php
use PW\BackendUI\BackendUI;

// 1. Inicializar en plugins_loaded
BackendUI::init([
    'assets_url' => plugin_dir_url(__FILE__) . 'vendor/pw/backend-ui/assets/',
    'screens'    => ['toplevel_page_mi-plugin'],  // screen IDs de WP Admin
    'version'    => '1.4.0',
    'slug'       => 'mi-plugin',
    'brand'      => ['name' => 'Mi Plugin', 'logo_url' => ''],
]);

// 2. Registrar la página de admin
add_action('admin_menu', function() {
    add_menu_page('Mi Plugin', 'Mi Plugin', 'manage_options', 'mi-plugin', 'mi_plugin_render');
});

// 3. Renderizar
function mi_plugin_render() {
    BackendUI::init()->render_page([
        'title'   => 'Mi Plugin',
        'content' => function($bui) {
            $bui->ui()->card([
                'title'   => 'Configuración',
                'content' => function() use ($bui) {
                    $bui->ui()->input(['name' => 'campo', 'label' => 'Campo']);
                },
            ]);
        },
    ]);
}
```

> `screens` vacío = assets **no** se cargan en ninguna pantalla (opt-in explícito).

---

## API pública

### `BackendUI` (singleton)

| Método | Descripción |
|--------|-------------|
| `init(array $config)` | Inicializa el design system. Llamadas posteriores retornan la misma instancia. |
| `ui()` | Retorna el `ComponentRenderer` |
| `config(?string $key)` | Retorna toda la config o un valor específico |
| `render_page(array $page)` | Renderiza página completa con layout |
| `playground(array $opts)` | Registra página de dev con todos los componentes |
| `reset()` | Resetea el singleton (para testing) |

### `render_page()` — keys disponibles

| Key | Tipo | Descripción |
|-----|------|-------------|
| `title` | string | Título de la página |
| `description` | string | Descripción breve bajo el título |
| `tabs` | array | Definición de tabs |
| `tabs_mode` | string | `'js'` (default) \| `'url'` |
| `content` | callable | `function($bui) {}` — cuerpo de la página |
| `sidenav` | array\|callable | Activa layout con navegación lateral |
| `sidebar` | array | Columna derecha con `title` y `content` callable |
| `footer` | array | Footer con `left` y `right` callables |

---

## Componentes

Acceso: `BackendUI::init()->ui()->{componente}([...])`.

### Formularios

| Método | Descripción |
|--------|-------------|
| `input()` | Input: text, email, password, url, number, date, search |
| `date_input()` | Alias de `input()` con `type='date'` |
| `textarea()` | Textarea con label y validación |
| `select()` | Select dropdown. Acepta `wrapper_class`. |
| `checkbox()` | Checkbox individual |
| `toggle()` | Switch on/off |
| `radio()` | Radio button individual |
| `radio_group()` | Grupo de radio buttons con legend |
| `segmented_control()` | Selector de opciones mutuamente excluyentes |

### Acciones / Botones

| Método | Descripción |
|--------|-------------|
| `button()` | Variantes: `primary`, `secondary`, `outline`, `ghost`, `danger`, `invisible`. Con `href` → renderiza `<a>`. |

**`button()` — atributos completos:**

| Key | Descripción |
|-----|-------------|
| `label` | Texto visible |
| `href` | URL → renderiza `<a>` |
| `target` | Atributo target (`_blank`, etc.) |
| `type` | `button` (default), `submit`, `reset` |
| `variant` | `primary`, `secondary`, `outline`, `ghost`, `danger`, `invisible` |
| `icon` | HTML/SVG antes del label |
| `disabled` | Solo en `<button>` |
| `class` | Clases CSS adicionales |
| `attrs` | Array de atributos HTML: `['data-pw-wizard-next' => '']` |

### Contenido / Estructura

| Método | Descripción |
|--------|-------------|
| `card()` | Contenedor con header, body y footer |
| `notice()` | Alerta/banner: `info`, `success`, `warning`, `danger` |
| `badge()` | Badge/tag: `default`, `primary`, `success`, `warning`, `danger`, `info` |
| `separator()` | Línea divisoria |

### Tipografía

| Método | Descripción |
|--------|-------------|
| `heading()` | Títulos h1–h6 |
| `paragraph()` | Párrafos: `default`, `muted`, `small` |
| `link()` | Enlace: `default`, `muted`, `danger` |

### Feedback / Estado

| Método | Descripción |
|--------|-------------|
| `spinner()` | Indicador de carga indeterminado |
| `progress_bar()` | Barra de progreso con variantes de color |
| `skeleton()` | Placeholder de carga: `text`, `title`, `box`, `avatar` |
| `tooltip()` | Tooltip sobre hover/focus |

### Navegación

| Método | Descripción |
|--------|-------------|
| `tabs()` | Navegación UnderlineNav. Soporta `count` y `mode` (`'js'` \| `'url'`) |
| `tab_panel()` | Panel de contenido asociado a un tab (solo mode `'js'`) |
| `breadcrumbs()` | Migas de pan |
| `pagination()` | Control de paginación con gaps |
| `side_nav()` | Navegación vertical tipo WP Settings (grupos, separators, active) |
| `stepper()` | Indicador visual de progreso para formularios multi-paso |

---

## Tabs

### Modo JS (default)

```php
$bui->render_page([
    'tabs' => [
        ['slug' => 'general',  'label' => 'General',  'active' => true],
        ['slug' => 'advanced', 'label' => 'Avanzado'],
    ],
    'content' => function($bui) {
        $bui->ui()->tab_panel(['slug' => 'general',  'active' => true, 'content' => fn() => '...']);
        $bui->ui()->tab_panel(['slug' => 'advanced', 'content' => fn() => '...']);
    },
]);
```

### Modo URL

```php
$tab = sanitize_key($_GET['tab'] ?? 'datos');

$bui->render_page([
    'tabs' => [
        ['slug' => 'datos',   'label' => 'Datos',   'href' => add_query_arg('tab', 'datos',   $url), 'active' => $tab === 'datos'],
        ['slug' => 'alumnos', 'label' => 'Alumnos', 'href' => add_query_arg('tab', 'alumnos', $url), 'active' => $tab === 'alumnos'],
    ],
    'tabs_mode' => 'url',
    'content'   => function($bui) use ($tab) {
        if ($tab === 'datos')   { /* ... */ }
        if ($tab === 'alumnos') { /* ... */ }
    },
]);
```

> Tabs en `mode: 'url'` **no usan `tab_panel()`**.

---

## Layout con Side Nav

```php
$bui->render_page([
    'sidenav' => [
        'items' => [
            ['label' => 'Conexión',  'href' => '#', 'active' => true],
            ['label' => 'Proyectos', 'href' => '#'],
            ['separator' => true],
            ['group' => 'Avanzado'],
            ['label' => 'Logs',      'href' => '#'],
        ],
    ],
    'content' => function($bui) { /* ... */ },
]);
```

### `side_nav()` — estructura de items

| Key | Tipo | Descripción |
|-----|------|-------------|
| `label` | string | Texto del item |
| `href` | string | URL (renderiza `<a>`). Sin href → `<button>` |
| `active` | bool | Estado activo (borde rojo izquierdo) |
| `icon` | string | HTML/SVG opcional antes del label |
| `group` | string | Renderiza como encabezado de grupo |
| `separator` | true | Renderiza línea divisoria horizontal |

---

## Wizard y Stepper

Formularios multi-paso. El **stepper debe estar fuera del `<form>`**.

```
[data-pw-stepper]                  ← stepper(), FUERA del form
  [data-pw-step="slug"]

<form data-pw-wizard>
  [data-pw-wizard-step="slug"]     ← panel de cada paso
    [required]                     ← validados antes de avanzar
    [data-pw-wizard-next]          ← botón avanzar
    [data-pw-wizard-prev]          ← botón retroceder
    [data-pw-wizard-submit]        ← submit (solo último paso)
```

```php
$ui->stepper([
    'steps' => [
        ['slug' => 'paso-1', 'label' => 'Datos',    'state' => 'active'],
        ['slug' => 'paso-2', 'label' => 'Empresa',  'state' => 'pending'],
        ['slug' => 'paso-3', 'label' => 'Confirmar','state' => 'pending'],
    ],
]);
```

```php
$ui->button(['label' => 'Siguiente →', 'variant' => 'primary', 'attrs' => ['data-pw-wizard-next'   => '']]);
$ui->button(['label' => '← Anterior',  'variant' => 'ghost',   'attrs' => ['data-pw-wizard-prev'   => '']]);
$ui->button(['label' => 'Guardar', 'type' => 'submit',          'attrs' => ['data-pw-wizard-submit' => '']]);
```

**Validación de checkboxes en wizard:**

```html
<div data-pw-wizard-require-check="Debes seleccionar al menos uno.">
    <input type="checkbox" name="ids[]" value="1">
</div>
```

---

## Sistema de temas

Tema dark por defecto, switcheable desde el header. La preferencia se persiste en `localStorage` bajo la clave `pw-bui-theme`. Un script inline bloqueante aplica el tema antes del primer paint para evitar flash.

```js
document.addEventListener('pw-bui:theme-changed', function(e) {
    console.log('Nuevo tema:', e.detail.theme); // 'dark' | 'light'
});
```

---

## Tailwind CSS

El package carga Tailwind CDN automáticamente en las screens configuradas. Disponible para el package y para los plugins consumidores.

- Usar clases estándar (`flex`, `gap-4`, `mt-2`, etc.)
- `@apply` **no disponible** — requiere build process, no aplica con CDN
- No se carga en el frontend público

---

## WP_List_Table

El package normaliza `WP_List_Table` para respetar el tema activo (colores, bulk actions, search box, paginación, botones `.button`).

```php
echo '<div style="margin-top:16px;">';
echo '<form method="get" style="overflow:hidden;">';
echo '<input type="hidden" name="page" value="mi-pagina">';
$table->search_box('Buscar', 'mi-tabla');
$table->display();
echo '</form>';
echo '</div>';
```

---

## Hooks

### Registrados internamente

| Hook | Descripción |
|------|-------------|
| `admin_enqueue_scripts` | Carga Tailwind CDN + CSS + JS |

### Expuestos para extensión

| Hook | Tipo | Parámetros | Descripción |
|------|------|------------|-------------|
| `pw_bui/page_config` | filter | `array $page` | Modificar config de página antes de renderizar |
| `pw_bui/enqueue_assets` | action | `string $hook, $url, $version` | Encolar assets adicionales |
| `pw_bui/header_right` | action | `array $page` | Inyectar contenido a la derecha del header |

---

## Eventos JS

| Evento | `detail` | Descripción |
|--------|----------|-------------|
| `pw-bui:ready` | — | JS inicializado |
| `pw-bui:theme-changed` | `{ theme }` | Cambio de tema (`'dark'` \| `'light'`) |
| `pw-bui:tab-changed` | `{ slug }` | Cambio de tab (mode `'js'`) |
| `pw-bui:toggle-changed` | `{ name, checked, value }` | Cambio de toggle |
| `pw-bui:segment-changed` | `{ name, value }` | Cambio en segmented control |
| `pw-bui:wizard-step-changed` | `{ from, to, index }` | Paso de wizard avanzado/retrocedido |

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

## Versionado

| Tipo | Cuándo |
|------|--------|
| Patch `1.0.x` | Bug fixes, cambios internos en views o CSS |
| Minor `1.x.0` | Nuevos componentes, cambios no destructivos |
| Major `x.0.0` | Cambios que rompen la API de `ComponentRenderer` o `BackendUI` |

```bash
git tag v1.4.0 && git push origin v1.4.0
```

---

## Playground (dev)

```php
if (defined('WP_DEBUG') && WP_DEBUG) {
    BackendUI::playground();
}
```

Muestra todos los componentes en acción. Debe llamarse después de `init()`.

---

## Restricciones

- El package **NO** persiste datos — solo renderiza UI.
- El package **NO** registra páginas de admin.
- `screens` vacío = assets **no** se cargan (opt-in explícito).
- Sin dependencias de jQuery — JS vanilla.
- `button()` con `href` no soporta `disabled`.
- El **stepper debe estar fuera del `<form>`**.
- Los slugs de `stepper()` y `data-pw-wizard-step` deben coincidir exactamente.

---

## Pendiente

- Componente `modal/dialog`
- Componente `table` (listados con sort/paginación propios)
- Componente `file upload`
- Documentar override de vistas desde el plugin consumidor
