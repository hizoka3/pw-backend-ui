<?php
// views/playground/playground.php
// PW UI Playground — showcase de todos los componentes.
// @var \PW\BackendUI\BackendUI $bui

defined("ABSPATH") || exit();
$ui = $bui->ui();

if (!function_exists("pw_pg_section")):
	function pw_pg_section(string $title, string $desc = ""): void
	{
		echo '<div class="pw-bui-pg-section">';
		echo '<h3 class="pw-bui-pg-section__title">' . esc_html($title) . "</h3>";
		if ($desc) {
			echo '<p class="pw-bui-pg-section__desc">' . esc_html($desc) . "</p>";
		}
	}
	function pw_pg_section_end(): void
	{
		echo "</div>";
	}
	function pw_pg_row(string $lbl = ""): void
	{
		if ($lbl) {
			echo '<p class="pw-bui-section-label">' . esc_html($lbl) . "</p>";
		}
		echo '<div class="pw-bui-pg-row">';
	}
	function pw_pg_row_end(): void
	{
		echo "</div>";
	}
endif;

// ── TAB 1: BOTONES & BADGES ──────────────────────────────────────────────────
$ui->tab_panel([
	"slug" => "buttons",
	"active" => true,
	"content" => function () use ($ui) {
		pw_pg_section("Botones — Variantes");
		pw_pg_row();
		foreach (
			["primary", "secondary", "outline", "ghost", "danger", "invisible"]
			as $v
		) {
			$ui->button(["label" => ucfirst($v), "variant" => $v]);
		}
		pw_pg_row_end();
		pw_pg_section_end();

		pw_pg_section("Botones — Tamaños");
		pw_pg_row();
		foreach (
			["sm" => "Small", "md" => "Medium", "lg" => "Large"]
			as $s => $l
		) {
			$ui->button(["label" => $l, "size" => $s]);
		}
		pw_pg_row_end();
		pw_pg_section_end();

		pw_pg_section("Con icono & disabled");
		$chk =
			'<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"/></svg>';
		$plus =
			'<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M7.75 2a.75.75 0 0 1 .75.75V7h4.25a.75.75 0 0 1 0 1.5H8.5v4.25a.75.75 0 0 1-1.5 0V8.5H2.75a.75.75 0 0 1 0-1.5H7V2.75A.75.75 0 0 1 7.75 2Z"/></svg>';
		pw_pg_row();
		$ui->button([
			"label" => "Guardar",
			"variant" => "primary",
			"icon" => $chk,
		]);
		$ui->button([
			"label" => "Agregar",
			"variant" => "outline",
			"icon" => $plus,
		]);
		$ui->button(["label" => "Disabled primary", "disabled" => true]);
		$ui->button([
			"label" => "Disabled danger",
			"variant" => "danger",
			"disabled" => true,
		]);
		pw_pg_row_end();
		pw_pg_section_end();

		pw_pg_section("Badges / Labels");
		pw_pg_row("Tamaño md");
		foreach (
			["default", "primary", "success", "warning", "danger", "info"]
			as $v
		) {
			$ui->badge(["label" => ucfirst($v), "variant" => $v]);
		}
		pw_pg_row_end();
		pw_pg_row("Tamaño sm");
		foreach (["default", "success", "danger", "info"] as $v) {
			$ui->badge([
				"label" => ucfirst($v),
				"variant" => $v,
				"size" => "sm",
			]);
		}
		pw_pg_row_end();
		pw_pg_section_end();
	},
]);

// ── TAB 2: FORMULARIOS ───────────────────────────────────────────────────────
$ui->tab_panel([
	"slug" => "forms",
	"content" => function () use ($ui) {
		echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">';
		echo "<div>";
		pw_pg_section("Inputs");
		$ui->input([
			"name" => "t1",
			"label" => "Normal",
			"placeholder" => "Escribe algo...",
		]);
		$ui->input([
			"name" => "t2",
			"label" => "Requerido",
			"required" => true,
		]);
		$ui->input([
			"name" => "t3",
			"label" => "Con error",
			"value" => "invalid",
			"error" => "Campo obligatorio.",
		]);
		$ui->input([
			"name" => "t4",
			"label" => "Con ayuda",
			"help" => "Se mostrará en el header.",
		]);
		$ui->input([
			"name" => "t5",
			"label" => "Disabled",
			"value" => "no editable",
			"disabled" => true,
		]);
		pw_pg_section_end();
		pw_pg_section("Tipos especiales");
		$ui->input([
			"name" => "em",
			"label" => "Email",
			"type" => "email",
			"placeholder" => "usuario@ejemplo.com",
		]);
		$ui->input([
			"name" => "nm",
			"label" => "Número",
			"type" => "number",
			"min" => "0",
			"max" => "100",
		]);
		$ui->input([
			"name" => "ur",
			"label" => "URL",
			"type" => "url",
			"placeholder" => "https://",
		]);
		$ui->date_input([
			"name" => "dt",
			"label" => "Fecha",
			"help" => "Formato AAAA-MM-DD",
		]);
		$ui->input([
			"name" => "fl1",
			"label" => "Archivo",
			"type" => "file",
			"help" => "Estilo Work OS (botón + nombre de archivo).",
		]);
		$ui->input([
			"name" => "rg1",
			"label" => "Rango",
			"type" => "range",
			"min" => "0",
			"max" => "100",
			"value" => "40",
		]);
		$ui->input([
			"name" => "cl1",
			"label" => "Color",
			"type" => "color",
			"value" => "#dd0000",
		]);
		pw_pg_section_end();
		echo "</div><div>";
		pw_pg_section("Textarea & Select");
		$ui->textarea([
			"name" => "ta1",
			"label" => "Descripción",
			"placeholder" => "Escribe...",
			"rows" => 3,
		]);
		$ui->textarea([
			"name" => "ta2",
			"label" => "Con error",
			"error" => "No puede estar vacío.",
		]);
		$ui->select([
			"name" => "sl1",
			"label" => "País",
			"options" => ["cl" => "Chile", "ar" => "Argentina", "pe" => "Perú"],
			"help" => "Tu país de origen.",
		]);
		$ui->select([
			"name" => "sl2",
			"label" => "Select con error",
			"options" => ["1h" => "1 hora", "24h" => "24 horas"],
			"error" => "Selecciona una opción.",
		]);
		pw_pg_section_end();
		pw_pg_section("Checkbox & Toggle");
		$ui->checkbox([
			"name" => "c1",
			"label" => "Acepto los términos y condiciones",
		]);
		$ui->checkbox([
			"name" => "c2",
			"label" => "Notificaciones por email",
			"checked" => true,
		]);
		$ui->checkbox([
			"name" => "c3",
			"label" => "Deshabilitado",
			"disabled" => true,
		]);
		$ui->toggle([
			"name" => "tg1",
			"label" => "Modo mantenimiento",
			"help" => "Oculta el sitio al público.",
		]);
		$ui->toggle([
			"name" => "tg2",
			"label" => "Caché activado",
			"checked" => true,
		]);
		$ui->toggle([
			"name" => "tg3",
			"label" => "Deshabilitado",
			"disabled" => true,
		]);
		pw_pg_section_end();
		echo "</div></div>";
		echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:8px;">';
		echo "<div>";
		pw_pg_section("Radio Group");
		$ui->radio_group([
			"name" => "plan",
			"label" => "Plan de suscripción",
			"value" => "pro",
			"options" => [
				[
					"value" => "free",
					"label" => "Gratis",
					"help" => "Hasta 3 proyectos.",
				],
				[
					"value" => "pro",
					"label" => "Pro",
					"help" => "Proyectos ilimitados.",
				],
				[
					"value" => "ent",
					"label" => "Enterprise",
					"help" => "SLA + soporte.",
					"disabled" => true,
				],
			],
		]);
		pw_pg_section_end();
		echo "</div><div>";
		pw_pg_section("Segmented Control");
		$ui->segmented_control([
			"name" => "vm",
			"label" => "Modo de vista",
			"value" => "grid",
			"options" => [
				["value" => "list", "label" => "Lista"],
				["value" => "grid", "label" => "Cuadrícula"],
				["value" => "map", "label" => "Mapa", "disabled" => true],
			],
		]);
		$ui->segmented_control([
			"name" => "per",
			"label" => "Período",
			"value" => "30d",
			"options" => [
				["value" => "7d", "label" => "7 días"],
				["value" => "30d", "label" => "30 días"],
				["value" => "90d", "label" => "90 días"],
				["value" => "1y", "label" => "1 año", "disabled" => true],
			],
		]);
		pw_pg_section_end();
		echo "</div></div>";
	},
]);

// ── TAB 3: FEEDBACK ──────────────────────────────────────────────────────────
$ui->tab_panel([
	"slug" => "feedback",
	"content" => function () use ($ui) {
		pw_pg_section("Notices / Banners");
		$ui->notice([
			"type" => "info",
			"message" => "Notificación informativa con más contexto.",
		]);
		$ui->notice([
			"type" => "success",
			"message" => "Cambios guardados correctamente.",
		]);
		$ui->notice([
			"type" => "warning",
			"message" => "Algunos campos no se pudieron validar.",
		]);
		$ui->notice([
			"type" => "danger",
			"message" => "Error crítico. Revisa la configuración del servidor.",
		]);
		pw_pg_section_end();
		pw_pg_section("Notices con título & dismissible");
		$ui->notice([
			"type" => "info",
			"title" => "Actualización disponible",
			"message" => "Nueva versión disponible.",
			"dismissible" => true,
		]);
		$ui->notice([
			"type" => "success",
			"title" => "¡Listo!",
			"message" => "El proceso se completó.",
			"dismissible" => true,
		]);
		$ui->notice([
			"type" => "danger",
			"title" => "Permiso denegado",
			"message" => "No tienes permisos.",
			"dismissible" => true,
		]);
		pw_pg_section_end();
		echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">';
		echo "<div>";
		pw_pg_section("Spinner");
		pw_pg_row();
		$ui->spinner(["size" => "sm"]);
		$ui->spinner(["size" => "md"]);
		$ui->spinner(["size" => "lg"]);
		pw_pg_row_end();
		pw_pg_section_end();
		echo "</div><div>";
		pw_pg_section("Progress Bar");
		$ui->progress_bar([
			"value" => 25,
			"label" => "Cargando archivos",
			"show_value" => true,
		]);
		$ui->progress_bar([
			"value" => 60,
			"variant" => "success",
			"label" => "Tareas completadas",
			"show_value" => true,
		]);
		$ui->progress_bar([
			"value" => 80,
			"variant" => "warning",
			"size" => "md",
			"label" => "Espacio en disco",
			"show_value" => true,
		]);
		$ui->progress_bar([
			"value" => 95,
			"variant" => "danger",
			"size" => "lg",
			"label" => "Uso de memoria",
			"show_value" => true,
		]);
		pw_pg_section_end();
		echo "</div></div>";
		pw_pg_section("Skeleton (loading placeholders)");
		$ui->card([
			"title" => "Cargando...",
			"content" => function () use ($ui) {
				$ui->skeleton(["type" => "title", "width" => "40%"]);
				$ui->skeleton(["type" => "text", "lines" => 3]);
				echo '<div style="display:flex;gap:12px;margin-top:12px;">';
				$ui->skeleton(["type" => "avatar", "width" => "40px"]);
				echo '<div style="flex:1;">';
				$ui->skeleton(["type" => "text", "width" => "60%"]);
				$ui->skeleton(["type" => "text", "width" => "40%"]);
				echo "</div></div>";
			},
		]);
		pw_pg_section_end();
		pw_pg_section("Tooltip");
		pw_pg_row();
		$ui->tooltip([
			"text" => "Guardar todos los cambios",
			"trigger_html" =>
				'<button class="pw-bui-btn pw-bui-btn--primary pw-bui-btn--md">Hover → tooltip arriba</button>',
		]);
		$ui->tooltip([
			"text" => "Eliminar permanentemente",
			"position" => "bottom",
			"trigger_html" =>
				'<button class="pw-bui-btn pw-bui-btn--danger pw-bui-btn--md">Hover → tooltip abajo</button>',
		]);
		pw_pg_row_end();
		pw_pg_section_end();
	},
]);

// ── TAB 4: NAVEGACIÓN ────────────────────────────────────────────────────────
$ui->tab_panel([
	"slug" => "navigation",
	"content" => function () use ($ui) {
		pw_pg_section("Accordion — básico");
		$ui->accordion([
			"items" => [
				[
					"title"   => "Instalación",
					"content" =>
						"Descarga el plugin y cópialo en wp-content/plugins. Actívalo desde el panel de Plugins de WordPress.",
					"open"    => true,
				],
				[
					"title"   => "Configuración inicial",
					"content" =>
						"Ve a Ajustes → PW Config y completa los campos requeridos antes de comenzar a usar la integración.",
				],
				[
					"title"   => "Soporte y documentación",
					"content" =>
						"Consulta la documentación en docs.pezweb.com o abre un ticket de soporte si necesitas ayuda.",
				],
				[
					"title"    => "Item deshabilitado",
					"content"  => "Este panel no puede abrirse.",
					"disabled" => true,
				],
			],
		]);
		pw_pg_section_end();
		pw_pg_section("Accordion — múltiple abierto simultáneo");
		$ui->accordion([
			"allow_multiple" => true,
			"items" => [
				[
					"title"   => "Panel A",
					"content" =>
						"Contenido del panel A. Puede estar abierto a la vez que B.",
					"open"    => true,
				],
				[
					"title"   => "Panel B",
					"content" => "Contenido del panel B.",
					"open"    => true,
				],
				[
					"title"   => "Panel C",
					"content" => "Contenido del panel C. Cerrado por defecto.",
				],
			],
		]);
		pw_pg_section_end();

		pw_pg_section("Breadcrumbs");
		$ui->breadcrumbs([
			"items" => [
				["label" => "Inicio", "href" => "#"],
				["label" => "Configuración", "href" => "#"],
				["label" => "PW Playground"],
			],
		]);
		pw_pg_section_end();

		pw_pg_section("Side Nav (navegación lateral tipo WP Settings)");
		echo '<div style="display:grid;grid-template-columns:200px 1fr;border:1px solid var(--pw-color-border-default);align-items:stretch;overflow:hidden;">';
		echo '<nav class="pw-bui-sidenav" style="min-height:0;position:static;">';
		$ui->side_nav([
			"items" => [
				["label" => "Conexión", "href" => "#", "active" => true],
				["label" => "Enlazar Proyectos", "href" => "#"],
				["separator" => true],
				["group" => "Avanzado"],
				["label" => "Logs", "href" => "#"],
				["label" => "Webhooks", "href" => "#"],
			],
		]);
		echo "</nav>";
		echo '<div class="pw-bui-sidenav-content">';
		$ui->heading(["text" => "Panel de contenido", "level" => 3]);
		$ui->paragraph([
			"text" =>
				'El side_nav funciona como nav lateral. Se activa automáticamente al usar la clave "sidenav" en render_page().',
			"variant" => "muted",
		]);
		echo "</div>";
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section("Tabs anidados");
		$ui->card([
			"title" => "Contenido tabulado",
			"content" => function () use ($ui) {
				$ui->tabs([
					"tabs" => [
						[
							"slug" => "sa",
							"label" => "Resumen",
							"active" => true,
						],
						["slug" => "sb", "label" => "Detalles", "count" => 3],
						["slug" => "sc", "label" => "Historial"],
					],
				]);
				echo '<div style="padding-top:16px;">';
				$ui->tab_panel([
					"slug" => "sa",
					"active" => true,
					"content" => function () use ($ui) {
						$ui->paragraph([
							"text" =>
								"Panel Resumen. Los tabs soportan badge de contador.",
						]);
					},
				]);
				$ui->tab_panel([
					"slug" => "sb",
					"content" => function () use ($ui) {
						$ui->paragraph(["text" => "Panel Detalles (3 items)."]);
					},
				]);
				$ui->tab_panel([
					"slug" => "sc",
					"content" => function () use ($ui) {
						$ui->paragraph(["text" => "Panel Historial."]);
					},
				]);
				echo "</div>";
			},
		]);
		pw_pg_section_end();
		pw_pg_section("Paginación");
		$ui->pagination(["current" => 3, "total" => 12, "base_url" => "#"]);
		echo "<br>";
		$ui->pagination(["current" => 1, "total" => 5, "base_url" => "#"]);
		echo "<br>";
		$ui->pagination(["current" => 100, "total" => 100, "base_url" => "#"]);
		pw_pg_section_end();

		pw_pg_section("List table (markup WP_List_Table)");
		echo '<p style="font-size:12px;color:var(--pw-color-fg-muted);margin:0 0 12px;">' .
			esc_html(
				"Tabla y tablenav con las clases que genera WordPress; los tokens del tema se aplican dentro de #pw-backend-ui-app.",
			) .
			"</p>";
		echo '<div class="tablenav top">';
		echo '<div class="alignleft actions bulkactions">';
		echo '<label for="pg-bulk-action" class="screen-reader-text">' .
			esc_html("Acción en lote") .
			"</label>";
		echo '<select name="action" id="pg-bulk-action">';
		echo '<option value="-1">' . esc_html("Acciones en lote") . "</option>";
		echo '<option value="trash">' . esc_html("Mover a la papelera") . "</option>";
		echo "</select>";
		echo '<input type="submit" class="button action" value="' .
			esc_attr("Aplicar") .
			'" disabled />';
		echo "</div>";
		echo '<p class="search-box">';
		echo '<label for="pg-list-search"><span class="screen-reader-text">' .
			esc_html("Buscar") .
			"</span></label>";
		echo '<input type="search" id="pg-list-search" name="s" value="" placeholder="' .
			esc_attr("Buscar ítems…") .
			'" />';
		echo '<input type="submit" id="pg-search-submit" class="button" value="' .
			esc_attr("Buscar ítems") .
			'" />';
		echo "</p>";
		echo '<br class="clear" />';
		echo "</div>";
		echo '<table class="wp-list-table widefat fixed striped">';
		echo "<thead><tr>";
		echo '<td id="cb" class="manage-column column-cb check-column"><input type="checkbox" disabled /></td>';
		echo '<th scope="col" class="manage-column column-title column-primary sortable desc">';
		echo '<a href="#"><span>' .
			esc_html("Título") .
			"</span><span class=\"sorting-indicators\"><span class=\"sorting-indicator asc\" aria-hidden=\"true\"></span><span class=\"sorting-indicator desc\" aria-hidden=\"true\"></span></span></a>";
		echo "</th>";
		echo '<th scope="col" class="manage-column">' .
			esc_html("Autor") .
			"</th>";
		echo '<th scope="col" class="manage-column sorted asc">';
		echo '<a href="#"><span>' .
			esc_html("Fecha") .
			"</span><span class=\"sorting-indicators\"><span class=\"sorting-indicator asc\" aria-hidden=\"true\"></span><span class=\"sorting-indicator desc\" aria-hidden=\"true\"></span></span></a>";
		echo "</th>";
		echo "</tr></thead><tbody>";
		$pg_rows = [
			[
				"title" => "Entrada de ejemplo",
				"author" => "María",
				"date" => "2026-04-01",
			],
			[
				"title" => "Otro ítem con acciones de fila",
				"author" => "Carlos",
				"date" => "2026-03-28",
			],
			[
				"title" => "Borrador pendiente",
				"author" => "María",
				"date" => "—",
			],
		];
		foreach ($pg_rows as $i => $row) {
			echo "<tr>";
			echo '<th scope="row" class="check-column"><input type="checkbox" disabled /></th>';
			echo '<td class="title column-title has-row-actions column-primary">';
			echo "<strong><a href=\"#\">" . esc_html($row["title"]) . "</a></strong>";
			echo '<div class="row-actions"><span class="edit"><a href="#">' .
				esc_html("Editar") .
				'</a> | </span><span class="trash"><a href="#" class="submitdelete">' .
				esc_html("Papelera") .
				"</a></span></div>";
			echo "</td>";
			echo "<td>" . esc_html($row["author"]) . "</td>";
			echo "<td>" . esc_html($row["date"]) . "</td>";
			echo "</tr>";
		}
		echo "</tbody><tfoot><tr>";
		echo '<td class="manage-column column-cb check-column"><input type="checkbox" disabled /></td>';
		echo "<th class=\"manage-column column-primary\">" .
			esc_html("Título") .
			"</th>";
		echo "<th class=\"manage-column\">" . esc_html("Autor") . "</th>";
		echo "<th class=\"manage-column\">" . esc_html("Fecha") . "</th>";
		echo "</tr></tfoot></table>";
		echo '<div class="tablenav bottom">';
		echo '<div class="tablenav-pages">';
		echo '<span class="displaying-num">' .
			esc_html(sprintf("%d ítems", count($pg_rows))) .
			"</span>";
		echo '<span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>';
		echo '<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>';
		echo '<span class="paging-input"><label for="pg-current-page" class="screen-reader-text">' .
			esc_html("Página actual") .
			'</label><input class="current-page" id="pg-current-page" type="text" name="paged" value="1" size="1" aria-describedby="table-paging" disabled /><span class="tablenav-paging-text"> ' .
			esc_html("de") .
			' <span class="total-pages">1</span></span></span>';
		echo '<span class="tablenav-pages-navspan" aria-hidden="true">›</span>';
		echo '<span class="tablenav-pages-navspan" aria-hidden="true">»</span></span>';
		echo "</div></div>";
		pw_pg_section_end();
	},
]);

// ── TAB 5: TIPOGRAFÍA & LAYOUT ───────────────────────────────────────────────
$ui->tab_panel([
	"slug" => "layout",
	"content" => function () use ($ui) {
		echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">';
		echo "<div>";
		pw_pg_section("Headings");
		for ($l = 1; $l <= 6; $l++) {
			$ui->heading(["text" => "Heading $l — h$l", "level" => $l]);
		}
		$ui->heading([
			"text" => "Eyebrow — sección (Work OS)",
			"variant" => "eyebrow",
		]);
		$ui->section_label(["text" => "Section label (section_label)"]);
		pw_pg_section_end();
		pw_pg_section("Stats bar & data table");
		$ui->stats_bar([
			"items" => [
				[
					"label" => "Neto",
					"value" => "$120.000",
					"breakdown" =>
						"<span>Subtotal <strong>$100.000</strong></span><span>IVA <strong>$20.000</strong></span>",
				],
				["label" => "Facturas", "value" => "12"],
			],
		]);
		$ui->data_table([
			"headers" => ["Campo", "Valor"],
			"rows" => [
				["Cliente", "Acme SA"],
				["Estado", "Activo"],
			],
		]);
		pw_pg_section_end();
		pw_pg_section("Paragraphs");
		$ui->paragraph([
			"text" => "Default — texto principal con buena legibilidad.",
		]);
		$ui->paragraph([
			"text" => "Muted — texto secundario para descripciones.",
			"variant" => "muted",
		]);
		$ui->paragraph([
			"text" => "Small — etiquetas, hints, notas al pie.",
			"variant" => "small",
		]);
		pw_pg_section_end();
		pw_pg_section("Links");
		pw_pg_row();
		$ui->link(["label" => "Default", "href" => "#"]);
		$ui->link(["label" => "Muted", "href" => "#", "variant" => "muted"]);
		$ui->link(["label" => "Danger", "href" => "#", "variant" => "danger"]);
		$ui->link([
			"label" => "External",
			"href" => "#",
			"target" => "_blank",
		]);
		pw_pg_row_end();
		pw_pg_section_end();
		echo "</div><div>";
		pw_pg_section("Cards");
		$ui->card([
			"title" => "Con header y footer",
			"description" => "Subtítulo descriptivo.",
			"content" => function () use ($ui) {
				$ui->paragraph(["text" => "Contenido con padding estándar."]);
			},
			"footer" => function () use ($ui) {
				$ui->button(["label" => "Acción", "size" => "sm"]);
				$ui->button([
					"label" => "Cancelar",
					"variant" => "ghost",
					"size" => "sm",
				]);
			},
		]);
		echo '<div style="margin-top:12px;">';
		$ui->card([
			"title" => "Card flush (sin padding)",
			"padded" => false,
			"content" => function () {
				foreach (["Ítem uno", "Ítem dos", "Ítem tres"] as $i => $item) {
					$b =
						$i > 0
							? "border-top:1px solid var(--pw-color-border-default);"
							: "";
					echo '<div style="padding:10px 16px;font-size:13px;color:var(--pw-color-fg-default);' .
						$b .
						'">' .
						esc_html($item) .
						"</div>";
				}
			},
		]);
		echo "</div>";
		pw_pg_section_end();
		pw_pg_section("Separator");
		$ui->paragraph(["text" => "Contenido arriba del separador."]);
		$ui->separator();
		$ui->paragraph(["text" => "Contenido debajo del separador."]);
		pw_pg_section_end();
		echo "</div></div>";
	},
]);

// ── TAB 6: CONTENEDORES & ESPACIADO ─────────────────────────────────────────

// ── Inline icon library (directional arrows) ─────────────────────────────────
if (!function_exists("pw_pg_arrow")):
	function pw_pg_arrow(string $dir, int $size = 10): string
	{
		static $paths = [
			"right"        => "M1 5H9 M6 2L9 5L6 8",
			"left"         => "M9 5H1 M4 2L1 5L4 8",
			"up"           => "M5 9V1 M2 4L5 1L8 4",
			"down"         => "M5 1V9 M2 6L5 9L8 6",
			"top-right"    => "M2 8L8 2 M4 2L8 2L8 6",
			"top-left"     => "M8 8L2 2 M6 2L2 2L2 6",
			"bottom-right" => "M2 2L8 8 M4 8L8 8L8 4",
			"bottom-left"  => "M8 2L2 8 M6 8L2 8L2 4",
		];
		$d = $paths[$dir] ?? $paths["right"];
		return sprintf(
			'<svg xmlns="http://www.w3.org/2000/svg" width="%1$d" height="%1$d" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;" aria-hidden="true"><path d="%2$s"/></svg>',
			$size,
			esc_attr($d)
		);
	}
endif;

$ui->tab_panel([
	"slug"    => "containers",
	"content" => function () use ($ui) {
		pw_pg_section("Librería de iconos — flechas");
		$arrow_dirs = [
			"right"        => "Derecha",
			"left"         => "Izquierda",
			"up"           => "Arriba",
			"down"         => "Abajo",
			"top-right"    => "Superior derecha",
			"top-left"     => "Superior izquierda",
			"bottom-right" => "Inferior derecha",
			"bottom-left"  => "Inferior izquierda",
		];
		pw_pg_row();
		foreach ($arrow_dirs as $dir => $label) {
			echo '<span style="display:inline-flex;flex-direction:column;align-items:center;gap:4px;padding:8px;border:1px solid var(--pw-color-border-default);min-width:60px;">';
			echo '<span style="color:var(--pw-color-fg-default);">' . pw_pg_arrow($dir, 14) . "</span>";
			echo '<span style="font-size:8px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">' .
				esc_html($label) .
				"</span>";
			echo "</span>";
		}
		pw_pg_row_end();
		echo '<p style="font-size:11px;color:var(--pw-color-fg-subtle);margin-top:8px;">Uso: <code style="font-size:10px;">pw_pg_arrow(\'right\', 12)</code> — hereda <code style="font-size:10px;">color:currentColor</code>.</p>';
		pw_pg_section_end();

		pw_pg_section(
			"Tokens de espaciado",
			"Escala de 4px. Usar siempre estos tokens para gaps y margins.",
		);
		echo '<table class="wp-list-table widefat fixed striped" style="width:auto;max-width:480px;">';
		echo "<thead><tr><th>Token</th><th>Valor</th><th>Uso típico</th></tr></thead><tbody>";
		$spacing = [
			["--pw-space-1", "4px", "Gap interno, separación entre íconos"],
			["--pw-space-2", "8px", "Gap entre controles, row-actions"],
			["--pw-space-3", "12px", "Padding lateral de ítems nav"],
			["--pw-space-4", "16px", "Card padding, form-gap interno"],
			["--pw-space-5", "20px", "Margin entre bloques dentro de un card"],
			["--pw-space-6", "24px", "Content padding, layout gap"],
			["--pw-space-8", "32px", "Separación entre secciones de página"],
			["--pw-content-padding", "24px", "Padding del área de contenido principal"],
			["--pw-layout-gap", "24px", "Gap entre columnas del layout grid"],
			["--pw-card-padding", "16px", "Padding interior de cards"],
			["--pw-form-gap", "16px", "Gap vertical entre campos de formulario"],
		];
		foreach ($spacing as [$token, $val, $uso]) {
			echo "<tr>";
			echo '<td><code style="font-size:11px;color:var(--pw-color-fg-default);">' .
				esc_html($token) .
				"</code></td>";
			echo "<td>";
			echo '<span style="display:inline-block;width:' .
				esc_attr($val) .
				';height:10px;background:var(--pw-color-accent-fg);vertical-align:middle;margin-right:6px;"></span>';
			echo '<span style="font-size:11px;color:var(--pw-color-fg-muted);">' .
				esc_html($val) .
				"</span>";
			echo "</td>";
			echo '<td style="font-size:11px;color:var(--pw-color-fg-subtle);">' .
				esc_html($uso) .
				"</td>";
			echo "</tr>";
		}
		echo "</tbody></table>";
		pw_pg_section_end();

		pw_pg_section("Reglas de espaciado entre elementos");
		echo '<table class="wp-list-table widefat fixed striped" style="width:auto;max-width:580px;">';
		echo "<thead><tr><th>Contexto</th><th>Token recomendado</th><th>Valor</th></tr></thead><tbody>";
		$rules = [
			["Heading " . pw_pg_arrow("down", 9) . " Párrafo", "--pw-space-2", "8px"],
			["Párrafo " . pw_pg_arrow("down", 9) . " Párrafo", "--pw-space-2", "8px"],
			["Imagen " . pw_pg_arrow("down", 9) . " Caption", "6px (manual)", "6px"],
			["Caption " . pw_pg_arrow("down", 9) . " Párrafo siguiente", "--pw-card-padding", "16px"],
			["Card " . pw_pg_arrow("right", 9) . " Card (gap horizontal)", "--pw-layout-gap", "24px"],
			["Sección " . pw_pg_arrow("down", 9) . " Sección (bloques de página)", "--pw-space-8", "32px"],
			["Label " . pw_pg_arrow("down", 9) . " Control de formulario", "--pw-space-2", "8px"],
			["Campo " . pw_pg_arrow("down", 9) . " Campo", "--pw-form-gap", "16px"],
		];
		foreach ($rules as [$ctx, $token, $val]) {
			echo "<tr>";
			echo '<td style="font-size:11px;">' . $ctx . "</td>";
			echo '<td><code style="font-size:10px;color:var(--pw-color-fg-default);">' .
				esc_html($token) .
				"</code></td>";
			echo '<td style="font-size:11px;color:var(--pw-color-fg-subtle);">' .
				esc_html($val) .
				"</td>";
			echo "</tr>";
		}
		echo "</tbody></table>";
		pw_pg_section_end();

		pw_pg_section(
			"Contenedor básico y profundidad anidada",
			"Cada nivel de anidamiento usa un fondo más oscuro y un borde más sutil.",
		);
		echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);">';
		$ui->paragraph(["text" => "Nivel 0 — contenedor raíz. bg-subtle, border-default."]);
		echo '<div style="margin-top:var(--pw-card-padding);border:1px solid var(--pw-color-border-muted);padding:var(--pw-card-padding);background:var(--pw-color-bg-inset);">';
		$ui->paragraph(["text" => "Nivel 1 — anidado. bg-inset, border-muted.", "variant" => "muted"]);
		echo '<div style="margin-top:var(--pw-card-padding);border:1px solid var(--pw-color-border-muted);padding:var(--pw-card-padding);background:var(--pw-color-bg-emphasis);">';
		$ui->paragraph(["text" => "Nivel 2 — más profundo. bg-emphasis, border-muted.", "variant" => "muted"]);
		echo '<div style="margin-top:var(--pw-card-padding);border:1px solid var(--pw-color-border-emphasis);padding:var(--pw-card-padding);background:var(--pw-color-bg-overlay);">';
		$ui->paragraph(["text" => "Nivel 3 — hoja. bg-overlay, border-emphasis.", "variant" => "muted"]);
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section("Grid 2 columnas (1fr 1fr)", "Gap uniforme: var(--pw-layout-gap) = 24px.");
		echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--pw-layout-gap);">';
		foreach (["Columna A", "Columna B"] as $col) {
			echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);">';
			$ui->heading(["text" => $col, "level" => 4]);
			echo '<div style="margin-top:8px;">';
			$ui->paragraph([
				"text" => "$col — peso igual. Útil para formularios en dos columnas.",
				"variant" => "muted",
			]);
			echo "</div></div>";
		}
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Grid 3 columnas — métricas (repeat(3, 1fr))",
			"Indicador decorativo gris en esquina superior derecha.",
		);
		$metrics = [
			["Neto", "$120.000", "12 facturas"],
			["Activos", "47", "3 pendientes"],
			["Cobertura", "94%", "Último mes"],
		];
		echo '<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:var(--pw-layout-gap);">';
		foreach ($metrics as [$lbl, $val, $sub]) {
			echo '<div style="position:relative;border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);overflow:hidden;">';
			echo '<div style="position:absolute;top:0;right:0;width:20px;height:20px;background:var(--pw-color-bg-inset);"></div>';
			echo '<div style="font-size:22px;font-weight:300;color:var(--pw-color-fg-muted);line-height:1;">' .
				esc_html($val) .
				"</div>";
			echo '<div style="font-size:9px;text-transform:uppercase;letter-spacing:0.08em;color:var(--pw-color-fg-subtle);margin-top:4px;">' .
				esc_html($lbl) .
				"</div>";
			echo '<div style="font-size:10px;color:var(--pw-color-fg-subtle);margin-top:6px;">' .
				esc_html($sub) .
				"</div>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Grid 4 columnas (repeat(4, 1fr))",
			"Gap uniforme: var(--pw-layout-gap) = 24px. Catálogos, iconografía, grids de opciones.",
		);
		echo '<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:var(--pw-layout-gap);">';
		foreach (range(1, 8) as $n) {
			echo '<div style="position:relative;border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);display:flex;align-items:center;justify-content:center;overflow:hidden;">';
			echo '<div style="position:absolute;top:0;right:0;width:16px;height:16px;background:var(--pw-color-bg-inset);"></div>';
			echo '<span style="font-size:10px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">Ítem ' .
				(int) $n .
				"</span>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Grid asimétrico (2fr 1fr)",
			"Contenido principal ancho " . pw_pg_arrow("right", 10) . " sidebar angosto. Gap uniforme: var(--pw-layout-gap).",
		);
		echo '<div style="display:grid;grid-template-columns:2fr 1fr;gap:var(--pw-layout-gap);">';
		echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);">';
		$ui->heading(["text" => "Área principal (2fr)", "level" => 4]);
		echo '<div style="margin-top:8px;">';
		$ui->paragraph([
			"text" => "Ocupa dos tercios. Contenido principal, formularios, tablas.",
			"variant" => "muted",
		]);
		echo "</div></div>";
		echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-inset);">';
		$ui->heading(["text" => "Sidebar (1fr)", "level" => 4]);
		echo '<div style="margin-top:8px;">';
		$ui->paragraph(["text" => "Filtros, meta, acciones secundarias.", "variant" => "muted"]);
		echo "</div></div>";
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Grid irregular (1fr 2fr 1fr)",
			"Columna central dominante — editorial, dashboards con foco en el centro.",
		);
		echo '<div style="display:grid;grid-template-columns:1fr 2fr 1fr;gap:var(--pw-layout-gap);">';
		foreach (["Nav / Meta (1fr)", "Contenido central (2fr)", "Acciones (1fr)"] as $col) {
			$bg = strpos($col, "central") !== false ? "var(--pw-color-bg-subtle)" : "var(--pw-color-bg-inset)";
			echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:' .
				esc_attr($bg) .
				';">';
			$ui->paragraph(["text" => $col]);
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Geometría irregular A — hero + side + meta/body",
			"grid-template-areas. El hero span 2 cols; el side span 2 rows.",
		);
		echo '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;grid-template-rows:120px 80px;gap:var(--pw-layout-gap);grid-template-areas:\'hero hero side\' \'meta body side\';">';
		foreach (
			["hero" => "Hero (2 cols)", "side" => "Side (2 rows)", "meta" => "Meta", "body" => "Body"]
			as $area => $label
		) {
			echo '<div style="grid-area:' .
				esc_attr($area) .
				';border:1px solid var(--pw-color-border-default);background:var(--pw-color-bg-inset);display:flex;align-items:center;justify-content:center;padding:var(--pw-space-3);">';
			echo '<span style="font-size:10px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">' .
				esc_html($label) .
				"</span>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Geometría irregular B — 5 celdas asimétricas",
			"Banner full-width + 2 zonas de distinto peso + 2 módulos angostos.",
		);
		echo '<div style="display:grid;grid-template-columns:3fr 1fr;grid-template-rows:60px 100px 100px;gap:var(--pw-layout-gap);grid-template-areas:\'banner banner\' \'main aux1\' \'main aux2\';">';
		foreach (
			[
				"banner" => "Banner (full width)",
				"main" => "Main (span 2 rows)",
				"aux1" => "Aux 1",
				"aux2" => "Aux 2",
			]
			as $area => $label
		) {
			echo '<div style="grid-area:' .
				esc_attr($area) .
				';border:1px solid var(--pw-color-border-default);background:var(--pw-color-bg-inset);display:flex;align-items:center;justify-content:center;padding:var(--pw-space-3);">';
			echo '<span style="font-size:10px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">' .
				esc_html($label) .
				"</span>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section("Geometría irregular C — mosaico editorial 4 zonas");
		echo '<div style="display:grid;grid-template-columns:1fr 1fr 2fr;grid-template-rows:80px 120px 80px;gap:var(--pw-layout-gap);grid-template-areas:\'a b feature\' \'c b feature\' \'d d feature\';">';
		foreach (
			[
				"a" => "A",
				"b" => "B (2 rows)",
				"feature" => "Feature (3 rows)",
				"c" => "C",
				"d" => "D (ancho abajo)",
			]
			as $area => $label
		) {
			echo '<div style="grid-area:' .
				esc_attr($area) .
				';border:1px solid var(--pw-color-border-default);background:var(--pw-color-bg-inset);display:flex;align-items:center;justify-content:center;padding:var(--pw-space-3);">';
			echo '<span style="font-size:9px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">' .
				esc_html($label) .
				"</span>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Grid irregular para tablas",
			"Tabla de datos usando grid en vez de table. Las celdas pueden hacer span de columnas.",
		);
		$cols = "2fr 1fr 1fr 80px";
		echo '<div style="display:grid;grid-template-columns:' .
			esc_attr($cols) .
			';gap:1px;background:var(--pw-color-border-default);">';
		foreach (["Nombre", "Estado", "Fecha", "Acción"] as $h) {
			echo '<div style="background:var(--pw-color-bg-inset);padding:8px 12px;font-size:9px;text-transform:uppercase;letter-spacing:0.08em;color:var(--pw-color-fg-subtle);">' .
				esc_html($h) .
				"</div>";
		}
		$rows_data = [
			["Entrada de ejemplo", "Publicado", "2026-04-01", "Ver"],
			["Otro ítem más largo aquí", "Borrador", "2026-03-28", "Editar"],
			["Tercera entrada", "Papelera", "—", "—"],
		];
		foreach ($rows_data as $row) {
			foreach ($row as $cell) {
				echo '<div style="background:var(--pw-color-bg-subtle);padding:8px 12px;font-size:11px;color:var(--pw-color-fg-muted);">' .
					esc_html($cell) .
					"</div>";
			}
		}
		echo '<div style="grid-column:span 3;background:var(--pw-color-bg-emphasis);padding:8px 12px;font-size:10px;color:var(--pw-color-fg-subtle);font-style:italic;">Celda span 3 columnas — notas o totales de sección</div>';
		echo '<div style="background:var(--pw-color-bg-emphasis);padding:8px 12px;font-size:11px;color:var(--pw-color-fg-default);"></div>';
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Masonry — CSS columns",
			"column-count + column-gap. Los ítems fluyen verticalmente con alturas heterogéneas naturales.",
		);
		echo '<div style="column-count:3;column-gap:var(--pw-layout-gap);">';
		$items_h = [100, 60, 140, 80, 120, 50, 90, 110, 70];
		foreach ($items_h as $h) {
			echo '<div style="break-inside:avoid;margin-bottom:var(--pw-layout-gap);border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);height:' .
				(int) $h .
				'px;display:flex;align-items:center;">';
			echo '<span style="font-size:10px;color:var(--pw-color-fg-subtle);">h=' . (int) $h . "px</span>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();
	},
]);
