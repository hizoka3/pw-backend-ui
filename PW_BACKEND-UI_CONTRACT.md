# Package: pw/backend-ui

**Versión:** 1.3.0
**Namespace:** `PW\BackendUI`
**Propósito:** Sistema de diseño compartido para el backend (admin) de plugins WordPress del ecosistema PW. Inspirado en Primer (GitHub). Tema dark por defecto, con soporte light switcheable desde el header. Paleta de colores PW. Sin Tailwind CDN — CSS puro con custom properties.

---

## Instalación

```json
"require": {
    "pw/backend-ui": "^1.3"
}
```

> Requiere que el plugin llame `BackendUI::init($config)` en el hook `plugins_loaded` o posterior.

---

## Cambios en v1.3.0

- **`tabs()` soporta `mode: 'url'`**: nuevo parámetro `mode` en el componente tabs. `'js'` (default) = `<button>` con toggle JS. `'url'` = `<a href>` para navegación server-side. Activar pasando `'active' => true` en el tab correspondiente server-side.
- **`render_page()` acepta `tabs_mode`**: nueva key `tabs_mode` en el array de `render_page()` que se pasa directo al componente `tabs()`. Default `'js'`. Usar `'url'` para tabs de navegación por URL.
- **`button()` soporta `href`**: cuando se pasa `href`, el componente renderiza `<a href>` en lugar de `<button>`. Soporta también `target`. Sin `href` el comportamiento es idéntico al anterior.
- **Anti-flash de tema**: `page-wrapper.php` incluye un script inline bloqueante inmediatamente después del `<div id="pw-backend-ui-app">` que lee `localStorage` y aplica el tema guardado antes del primer paint, eliminando el flash dark→light en recarga.
- **CSS fix — hover color en `<a>.pw-bui-btn`**: el CSS de WP admin pisaba el `color` de los `<a>` en `:hover`. Se agregaron reglas con mayor especificidad en `backend-ui.css` para todos los variantes de botón.
- **CSS fix — `WP_List_Table` search_box**: `WP_List_Table::search_box()` genera `<p class="search-box">` que es `display:block` por defecto. Se agrega `display:inline-flex` al `<p>` y `overflow:hidden` al `.tablenav.top` para que input y botón queden en la misma línea.

## Cambios en v1.2.0

- **Layout offset WP corregido**: `margin-left:-20px` + `width:calc(100%+20px)` para cancelar el `padding-left:20px` de `#wpbody-content`.
- **Header siempre negro**: `.pw-bui-header` y `.pw-bui-tabs-nav` usan colores fijos (`#000000`) independientemente del tema activo.
- **Logo PW**: cuadrado rojo 40×40px sin contenido interior. El `brand.name` se muestra a la derecha en blanco.
- **Nuevo componente `side_nav()`**: barra de navegación vertical tipo WP Settings. Soporta items, group labels y separators.
- **Nuevo layout `sidenav`**: activar con `'sidenav'` en `render_page()` para obtener columna nav 200px + contenido.

## Cambios en v1.1.0

- **Sin Tailwind CDN**: todos los estilos son CSS puro con custom properties (`--pw-color-*`).
- **Sistema de temas**: dark (default) / light, switcheables via botón en el header.
- **Paleta PW**: negro `#000`, gris caja `#0a0a0a`, rojo `#ff0000`, gris botón `#333`, blanco2 `#fafafa`, texto gris `#6d6d6d`, líneas `#161616`.
- **Border-radius 2px** en componentes. **0px** en elementos de layout.
- **Header PW**: logo cuadrado rojo + slot derecho + theme toggle integrado.
- **Layout pegado al menú WP**: sin `margin-left` ni `padding-top` extra.
- **Nuevos componentes**: `radio()`, `radio_group()`, `date_input()`, `segmented_control()`, `spinner()`, `progress_bar()`, `breadcrumbs()`, `pagination()`, `tooltip()`, `skeleton()`.
- **Componentes mejorados**: `notice()` soporta `title`, `badge()` tiene variante `info`, `tabs()` soporta `count`, `button()` tiene variante `invisible`.

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
| `render_page()` | `array $page` | `void` | Renderiza página completa con layout. Keys: `title`, `description`, `tabs`, `tabs_mode`, `content`, `sidenav`, `sidebar`, `footer` |
| `playground()` | `array $opts` | `void` | Registra página de dev con todos los componentes |
| `reset()` | — | `void` | Resetea el singleton (para testing) |

### Componentes disponibles via `ui()`

#### Acciones / Botones
| Método | Descripción |
|--------|-------------|
| `button()` | Botón: primary, secondary, outline, ghost, danger, invisible. Acepta `href` → renderiza `<a>`. |

#### Formularios
| Método | Descripción |
|--------|-------------|
| `input()` | Input: text, email, password, url, number, date, search |
| `date_input()` | Alias de input() con type='date' |
| `textarea()` | Textarea con label y validación |
| `select()` | Select dropdown |
| `checkbox()` | Checkbox individual |
| `toggle()` | Switch on/off |
| `radio()` | Radio button individual |
| `radio_group()` | Grupo de radio buttons con legend |
| `segmented_control()` | Selector de opciones mutuamente excluyentes |

#### Contenido / Estructura
| Método | Descripción |
|--------|-------------|
| `card()` | Contenedor con header, body y footer |
| `notice()` | Alerta/banner: info, success, warning, danger |
| `badge()` | Badge/tag: default, primary, success, warning, danger, info |
| `separator()` | Línea divisoria |

#### Feedback / Estado
| Método | Descripción |
|--------|-------------|
| `spinner()` | Indicador de carga indeterminado |
| `progress_bar()` | Barra de progreso con variantes de color |
| `skeleton()` | Placeholder de carga: text, title, box, avatar |
| `tooltip()` | Tooltip sobre hover/focus |

#### Tipografía
| Método | Descripción |
|--------|-------------|
| `heading()` | Títulos h1-h6 |
| `paragraph()` | Párrafos: default, muted, small |
| `link()` | Enlace: default, muted, danger |

#### Navegación
| Método | Descripción |
|--------|-------------|
| `tabs()` | Navegación UnderlineNav (estilo Primer). Soporta `count` y `mode` (`'js'` default \| `'url'`) |
| `tab_panel()` | Panel de contenido asociado a un tab |
| `breadcrumbs()` | Migas de pan |
| `pagination()` | Control de paginación con gaps |
| `side_nav()` | Navegación vertical tipo WP Settings (grupos, separators, active) |

---

### Config esperada en `init()`

```php
[
    'assets_url' => plugin_dir_url(__FILE__) . 'vendor/pw/backend-ui/assets/', // requerido
    'version'    => '1.3.0',
    'screens'    => ['toplevel_page_mi-plugin'],  // requerido — screen IDs de WP
    'slug'       => 'pw-backend-ui',              // prefijo para handles de assets
    'brand'      => [
        'name'     => 'Mi Plugin',                // nombre mostrado junto al logo PW
        'logo_url' => '',                         // no usado (logo es el cuadrado rojo PW)
    ],
]
```

### Hooks de WordPress que registra internamente

| Hook | Tipo | Descripción |
|------|------|-------------|
| `admin_enqueue_scripts` | action | Carga CSS y JS del design system |

### Hooks que expone para que el plugin extienda

| Hook | Tipo | Parámetros | Descripción |
|------|------|------------|-------------|
| `pw_bui/page_config` | filter | `array $page` | Modificar config de página antes de renderizar |
| `pw_bui/enqueue_assets` | action | `string $hook, string $url, string $version` | Encolar assets adicionales |
| `pw_bui/header_right` | action | `array $page` | Inyectar contenido a la derecha del header (antes del theme toggle) |

### Eventos JS

| Evento | `detail` | Descripción |
|--------|----------|-------------|
| `pw-bui:ready` | — | El JS se ha inicializado |
| `pw-bui:theme-changed` | `{ theme }` | Se cambió el tema ('dark' \| 'light') |
| `pw-bui:tab-changed` | `{ slug }` | Se cambió de pestaña (solo mode `'js'`) |
| `pw-bui:toggle-changed` | `{ name, checked, value }` | Se cambió un toggle switch |
| `pw-bui:segment-changed` | `{ name, value }` | Se cambió una opción en segmented control |

---

## Sistema de temas

El tema se controla mediante el atributo `data-pw-theme` en el wrapper `#pw-backend-ui-app`.

- **Dark** (default): `data-pw-theme="dark"`
- **Light**: `data-pw-theme="light"`

El botón de toggle en el header cambia el tema y persiste la preferencia en `localStorage` bajo la clave `pw-bui-theme`.

Un script inline bloqueante en `page-wrapper.php` aplica el tema guardado **antes del primer paint** para evitar el flash dark→light en recarga. No requiere configuración adicional.

Para escuchar cambios de tema desde un plugin:

```js
document.addEventListener('pw-bui:theme-changed', function(e) {
    console.log('Nuevo tema:', e.detail.theme); // 'dark' | 'light'
});
```

---

## Tabs — modos de navegación

### Modo JS (default)
Tabs client-side. El JS del package muestra/oculta `tab_panel()` al hacer click.

```php
$bui->render_page([
    'tabs' => [
        [ 'slug' => 'general',  'label' => 'General',  'active' => true ],
        [ 'slug' => 'advanced', 'label' => 'Avanzado' ],
    ],
    // tabs_mode no requerido — default 'js'
    'content' => function( $bui ) {
        $bui->ui()->tab_panel([ 'slug' => 'general',  'active' => true, 'content' => fn() => '...' ]);
        $bui->ui()->tab_panel([ 'slug' => 'advanced', 'content' => fn() => '...' ]);
    },
]);
```

### Modo URL
Tabs server-side. Cada tab es un `<a href>`. El tab activo se marca con `'active' => true` desde PHP según el parámetro de URL. No usa `tab_panel()`.

```php
$tab = sanitize_key( $_GET['tab'] ?? 'datos' );

$bui->render_page([
    'tabs'      => [
        [ 'slug' => 'datos',     'label' => 'Datos',     'href' => add_query_arg('tab', 'datos',     $base_url), 'active' => $tab === 'datos' ],
        [ 'slug' => 'clases',    'label' => 'Clases',    'href' => add_query_arg('tab', 'clases',    $base_url), 'active' => $tab === 'clases' ],
        [ 'slug' => 'preguntas', 'label' => 'Preguntas', 'href' => add_query_arg('tab', 'preguntas', $base_url), 'active' => $tab === 'preguntas' ],
    ],
    'tabs_mode' => 'url',
    'content'   => function( $bui ) use ( $tab ) {
        if ( $tab === 'datos' )     { /* render datos */ }
        if ( $tab === 'clases' )    { /* render clases */ }
        if ( $tab === 'preguntas' ) { /* render preguntas */ }
    },
]);
```

---

## `button()` — soporte href

Cuando se pasa `href`, el componente renderiza `<a>` en lugar de `<button>`. Útil para CTAs de navegación dentro del design system sin romper los estilos.

```php
// Renderiza <a href="...">
$ui->button([
    'label'   => 'Agregar empresa',
    'href'    => admin_url('admin.php?page=imec-empresas&action=new'),
    'variant' => 'primary',
]);

// Renderiza <button type="submit">
$ui->button([
    'label'   => 'Guardar',
    'type'    => 'submit',
    'variant' => 'primary',
]);
```

| Key | Aplica a | Descripción |
|-----|----------|-------------|
| `href` | `<a>` | URL de destino. Si está presente, renderiza `<a>`. |
| `target` | `<a>` | Atributo target (`_blank`, etc.) |
| `type` | `<button>` | `button` (default), `submit`, `reset` |
| `variant` | ambos | `primary`, `secondary`, `outline`, `ghost`, `danger`, `invisible` |
| `label` | ambos | Texto del botón |
| `icon` | ambos | HTML/SVG antes del label |
| `disabled` | `<button>` | Solo aplica en `<button>` |
| `style` | ambos | Estilos inline adicionales |
| `class` | ambos | Clases CSS adicionales |
| `attrs` | ambos | Array de atributos HTML adicionales |

---

## Tokens de color (CSS custom properties)

Todos los tokens cambian automáticamente según el tema. Se recomienda usar siempre los tokens semánticos en lugar de colores directos.

| Token | Dark | Light | Uso |
|-------|------|-------|-----|
| `--pw-color-bg-default` | `#000000` | `#ffffff` | Fondo principal |
| `--pw-color-bg-subtle` | `#0a0a0a` | `#f6f8fa` | Cards, surfaces |
| `--pw-color-bg-inset` | `#111111` | `#f0f2f5` | Inputs |
| `--pw-color-bg-emphasis` | `#333333` | `#e6e9ed` | Botones secundarios |
| `--pw-color-fg-default` | `#fafafa` | `#1c2128` | Texto principal |
| `--pw-color-fg-muted` | `#6d6d6d` | `#57606a` | Texto secundario |
| `--pw-color-border-default` | `#161616` | `#d0d7de` | Líneas divisoras |
| `--pw-color-accent-fg` | `#ff0000` | `#ff0000` | Rojo PW (brand) |

---

## Compatibilidad con WP_List_Table

El package incluye CSS específico para que `WP_List_Table` funcione correctamente dentro del layout de `#pw-backend-ui-app`.

**Search box:** `WP_List_Table::search_box()` genera `<p class="search-box">` con `float:right`. El package lo convierte a `inline-flex` para que input y botón queden en la misma línea.

**Uso estándar:**
```php
echo '<form method="get" style="overflow:hidden;">';
echo '<input type="hidden" name="page" value="mi-pagina">';
$table->search_box( 'Buscar', 'mi-tabla' );
$table->display();
echo '</form>';
```

> El `overflow:hidden` en el form es necesario como clearfix para contener el float del search-box.

---

## Playground

El playground es una página de admin que muestra todos los componentes en acción.

```php
// Recomendado: solo en entornos de desarrollo
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    BackendUI::playground();
}

// Con opciones:
BackendUI::playground([
    'capability' => 'manage_options',
    'menu_order' => 99,
]);
```

**Importante:** `playground()` debe llamarse después de `init()`. Es idempotente (seguro llamarlo múltiples veces).

**Contenido del playground:**
- Tab "Botones & Badges": variantes, tamaños, con iconos, disabled, badges, botones con href
- Tab "Formularios": inputs, textarea, select, date, checkbox, toggle, radio group, segmented control
- Tab "Feedback": notices, spinner, progress bar, skeleton, tooltip
- Tab "Navegación": breadcrumbs, side_nav, tabs JS, tabs URL, paginación
- Tab "Tipo & Layout": headings, paragraphs, links, cards, separator

---

## Layout con Side Nav

Para plugins con muchas secciones. Activa una columna izquierda de navegación de 200px.

```php
$bui->render_page([
    'brand'   => ['name' => 'Mi Plugin'],
    'tabs'    => [ ['slug' => 'config', 'label' => 'Configuración', 'active' => true] ],
    'sidenav' => [
        'items' => [
            [ 'label' => 'Conexión',          'href' => '#', 'active' => true ],
            [ 'label' => 'Enlazar Proyectos', 'href' => '#' ],
            [ 'separator' => true ],
            [ 'group' => 'Avanzado' ],
            [ 'label' => 'Logs',              'href' => '#' ],
        ],
    ],
    'content' => function( $bui ) { /* ... */ },
]);
```

También acepta callable en lugar de array: `'sidenav' => function($bui) { $bui->ui()->side_nav([...]); }`.

### `side_nav()` — estructura de items

| Key | Tipo | Descripción |
|-----|------|-------------|
| `label` | string | Texto del item |
| `href` | string | URL (renderiza `<a>`). Sin href → `<button>` |
| `active` | bool | Estado activo (borde rojo izquierdo) |
| `icon` | string | HTML/SVG opcional antes del label |
| `data` | string | Valor del atributo `data-pw-sidenav` |
| `group` | string | Si existe, renderiza como encabezado de grupo |
| `separator` | true | Renderiza línea divisoria horizontal |

---

## Lo que el package necesita del plugin

### Lo mínimo que el plugin debe hacer

```php
// 1. Inicializar — puede ser directo en el archivo principal o en plugins_loaded
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

- El package **NO** persiste datos — solo renderiza UI. El plugin guarda/recupera settings.
- El package **NO** registra páginas de admin — el plugin crea las páginas con `add_menu_page`.
- **Sin Tailwind CDN**. Todos los estilos están en `backend-ui.css`.
- El layout **no tiene border-radius** ni márgenes extra vs. el menú de WP.
- `screens` vacío = assets NO se cargan en ninguna pantalla (opt-in explícito).
- No tiene dependencias de jQuery.
- PHP mínimo: 8.0. WordPress mínimo: 6.0.
- Los tabs en `mode: 'url'` **no usan `tab_panel()`** — el contenido lo controla PHP según el parámetro GET.
- El componente `button()` con `href` no soporta `disabled` (comportamiento nativo de `<a>`).

---

## Ejemplo de uso completo (v1.3)

```php
use PW\BackendUI\BackendUI;

// Inicializar (dentro de is_admin() o directo)
BackendUI::init([
    'assets_url' => IMEC_CAPACITA_URL . 'vendor/pw/backend-ui/assets/',
    'version'    => '1.3.0',
    'screens'    => [
        'toplevel_page_mi-plugin',
        'mi-plugin_page_mi-subpagina',
    ],
    'brand' => [ 'name' => 'Mi Plugin Pro' ],
]);

// Página con tabs URL (server-side)
function mi_plugin_page_editor() {
    $tab      = sanitize_key( $_GET['tab'] ?? 'datos' );
    $item_id  = absint( $_GET['item_id'] ?? 0 );
    $base_url = add_query_arg( [ 'page' => 'mi-plugin', 'action' => 'edit', 'item_id' => $item_id ], admin_url( 'admin.php' ) );

    BackendUI::init()->render_page([
        'title'      => 'Editar item',
        'tabs'       => [
            [ 'slug' => 'datos',    'label' => 'Datos',    'href' => add_query_arg( 'tab', 'datos',    $base_url ), 'active' => $tab === 'datos' ],
            [ 'slug' => 'relacion', 'label' => 'Relación', 'href' => add_query_arg( 'tab', 'relacion', $base_url ), 'active' => $tab === 'relacion' ],
        ],
        'tabs_mode'  => 'url',
        'content'    => function( $bui ) use ( $tab ) {
            $ui = $bui->ui();

            $ui->breadcrumbs([
                'items' => [
                    [ 'label' => 'Items', 'href' => admin_url( 'admin.php?page=mi-plugin' ) ],
                    [ 'label' => 'Editar' ],
                ],
            ]);

            if ( $tab === 'datos' ) {
                $ui->card([
                    'title'   => 'Datos principales',
                    'content' => function() use ( $ui ) {
                        $ui->input([ 'name' => 'nombre', 'label' => 'Nombre', 'required' => true ]);
                        $ui->textarea([ 'name' => 'descripcion', 'label' => 'Descripción' ]);
                    },
                    'footer' => function() use ( $ui ) {
                        $ui->button([ 'label' => 'Guardar', 'type' => 'submit', 'variant' => 'primary' ]);
                        $ui->button([ 'label' => 'Cancelar', 'href' => admin_url( 'admin.php?page=mi-plugin' ), 'variant' => 'secondary' ]);
                    },
                ]);
            }

            if ( $tab === 'relacion' ) {
                // contenido tab relación
            }
        },
    ]);
}
```
