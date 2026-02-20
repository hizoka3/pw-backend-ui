<?php
// views/playground/playground.php

/**
 * Playground view — renders all available components for visual testing.
 * Loaded internally by BackendUI::playground().
 *
 * @var \PW\BackendUI\BackendUI $this
 */

defined("ABSPATH") || exit();

$icon_check =
	'<svg xmlns="http://www.w3.org/2000/svg" class="pw-h-4 pw-w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
$icon_plus =
	'<svg xmlns="http://www.w3.org/2000/svg" class="pw-h-4 pw-w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>';

$bui->render_page([
	"title" => "PW Backend UI — Playground",
	"description" =>
		"Vista de referencia de todos los componentes del design system.",
	"tabs" => [
		[
			"slug" => "pg-buttons",
			"label" => "Buttons & Badges",
			"active" => true,
		],
		["slug" => "pg-forms", "label" => "Forms"],
		["slug" => "pg-layout", "label" => "Cards & Notices"],
		["slug" => "pg-typography", "label" => "Typography & Nav"],
	],
	"content" => function ($bui) use ($icon_check, $icon_plus) {
		$ui = $bui->ui();

		// ── TAB: BUTTONS & BADGES ─────────────────────────────────────────────
		$ui->tab_panel([
			"slug" => "pg-buttons",
			"active" => true,
			"content" => function () use ($ui, $icon_check, $icon_plus) {
				$ui->card([
					"title" => "Button — variantes",
					"content" => function () use ($ui) {
						echo '<div class="pw-flex pw-flex-wrap pw-gap-3 pw-items-center">';
						foreach (
							[
								"primary",
								"secondary",
								"outline",
								"ghost",
								"danger",
							]
							as $v
						) {
							$ui->button([
								"label" => ucfirst($v),
								"variant" => $v,
							]);
						}
						echo "</div>";
					},
				]);

				$ui->card([
					"title" => "Button — tamaños",
					"content" => function () use ($ui) {
						echo '<div class="pw-flex pw-flex-wrap pw-gap-3 pw-items-center">';
						foreach (
							["sm" => "Small", "md" => "Medium", "lg" => "Large"]
							as $s => $label
						) {
							$ui->button(["label" => $label, "size" => $s]);
						}
						$ui->button([
							"label" => "Disabled",
							"disabled" => true,
						]);
						echo "</div>";
					},
				]);

				$ui->card([
					"title" => "Button — con ícono",
					"content" => function () use (
						$ui,
						$icon_check,
						$icon_plus,
					) {
						echo '<div class="pw-flex pw-flex-wrap pw-gap-3 pw-items-center">';
						$ui->button([
							"label" => "Guardar",
							"icon" => $icon_check,
						]);
						$ui->button([
							"label" => "Agregar",
							"icon" => $icon_plus,
							"variant" => "outline",
						]);
						$ui->button([
							"label" => "Peligro",
							"icon" => $icon_check,
							"variant" => "danger",
							"size" => "sm",
						]);
						$ui->button([
							"label" => "Sutil",
							"icon" => $icon_plus,
							"variant" => "ghost",
							"size" => "sm",
						]);
						echo "</div>";
					},
				]);

				$ui->card([
					"title" => "Badge — variantes y tamaños",
					"content" => function () use ($ui) {
						echo '<div class="pw-flex pw-flex-wrap pw-gap-3 pw-items-center">';
						foreach (
							[
								"default",
								"primary",
								"success",
								"warning",
								"danger",
							]
							as $v
						) {
							$ui->badge([
								"label" => ucfirst($v),
								"variant" => $v,
							]);
							$ui->badge([
								"label" => ucfirst($v) . " sm",
								"variant" => $v,
								"size" => "sm",
							]);
						}
						echo "</div>";
					},
				]);
			},
		]);

		// ── TAB: FORMS ────────────────────────────────────────────────────────
		$ui->tab_panel([
			"slug" => "pg-forms",
			"content" => function () use ($ui) {
				$ui->card([
					"title" => "Input",
					"content" => function () use ($ui) {
						$ui->input([
							"name" => "pg_text",
							"label" => "Texto normal",
							"placeholder" => "Escribe algo...",
							"help" => "Help text descriptivo del campo.",
						]);
						$ui->input([
							"name" => "pg_email",
							"label" => "Email (requerido)",
							"type" => "email",
							"required" => true,
							"value" => "usuario@ejemplo.com",
						]);
						$ui->input([
							"name" => "pg_error",
							"label" => "Con estado de error",
							"value" => "valor inválido",
							"error" =>
								"Este campo contiene un valor no permitido.",
						]);
						$ui->input([
							"name" => "pg_disabled",
							"label" => "Disabled",
							"value" => "No editable",
							"disabled" => true,
							"help" => "Este campo está deshabilitado.",
						]);
					},
				]);

				$ui->card([
					"title" => "Textarea",
					"content" => function () use ($ui) {
						$ui->textarea([
							"name" => "pg_textarea",
							"label" => "Descripción",
							"placeholder" => "Escribe aquí...",
							"help" => "Máximo 500 caracteres.",
							"rows" => 3,
						]);
						$ui->textarea([
							"name" => "pg_textarea_error",
							"label" => "Con error",
							"value" => "contenido no válido",
							"error" => "El contenido ingresado no es válido.",
							"rows" => 2,
						]);
					},
				]);

				$ui->card([
					"title" => "Select",
					"content" => function () use ($ui) {
						$ui->select([
							"name" => "pg_select",
							"label" => "Elige una opción",
							"value" => "2",
							"help" => "Selecciona la opción que corresponda.",
							"options" => [
								"1" => "Opción uno",
								"2" => "Opción dos",
								"3" => "Opción tres",
							],
						]);
						$ui->select([
							"name" => "pg_select_error",
							"label" => "Select con error",
							"options" => ["1" => "Opción A", "2" => "Opción B"],
							"error" => "Debes seleccionar una opción válida.",
						]);
					},
				]);

				$ui->card([
					"title" => "Checkbox",
					"content" => function () use ($ui) {
						$ui->checkbox([
							"name" => "pg_check_1",
							"label" => "Sin marcar",
							"help" => "Help text del checkbox.",
						]);
						$ui->checkbox([
							"name" => "pg_check_2",
							"label" => "Marcado",
							"checked" => true,
						]);
						$ui->checkbox([
							"name" => "pg_check_3",
							"label" => "Disabled marcado",
							"checked" => true,
							"disabled" => true,
						]);
					},
				]);

				$ui->card([
					"title" => "Toggle",
					"content" => function () use ($ui) {
						$ui->toggle([
							"name" => "pg_toggle_1",
							"label" => "Apagado",
							"help" => "Help text del toggle.",
						]);
						$ui->toggle([
							"name" => "pg_toggle_2",
							"label" => "Encendido",
							"checked" => true,
						]);
						$ui->toggle([
							"name" => "pg_toggle_3",
							"label" => "Disabled",
							"checked" => true,
							"disabled" => true,
						]);
					},
					"footer" => function () use ($ui) {
						echo '<div class="pw-flex pw-gap-3">';
						$ui->button([
							"label" => "Guardar cambios",
							"type" => "submit",
						]);
						$ui->button([
							"label" => "Cancelar",
							"variant" => "ghost",
						]);
						echo "</div>";
					},
				]);
			},
		]);

		// ── TAB: CARDS & NOTICES ──────────────────────────────────────────────
		$ui->tab_panel([
			"slug" => "pg-layout",
			"content" => function () use ($ui) {
				$ui->card([
					"title" => "Notices — todos los tipos",
					"content" => function () use ($ui) {
						foreach (
							["info", "success", "warning", "danger"]
							as $type
						) {
							$ui->notice([
								"type" => $type,
								"message" =>
									"Este es un notice de tipo <strong>" .
									$type .
									"</strong>. Úsalo para comunicar estados al usuario.",
							]);
						}
					},
				]);

				$ui->card([
					"title" => "Notice dismissible",
					"content" => function () use ($ui) {
						$ui->notice([
							"type" => "success",
							"message" =>
								"Este notice se puede cerrar. Haz clic en la X.",
							"dismissible" => true,
						]);
						$ui->notice([
							"type" => "warning",
							"message" => "Este también es dismissible.",
							"dismissible" => true,
						]);
					},
				]);

				$ui->card([
					"title" => "Card con descripción y footer",
					"description" =>
						"Esta es la descripción de la card, visible bajo el título.",
					"content" => function () use ($ui) {
						$ui->paragraph([
							"text" =>
								"Contenido principal de la card. Puede contener cualquier componente o HTML.",
						]);
					},
					"footer" => function () use ($ui) {
						$ui->link([
							"label" => "Ver documentación",
							"href" => "#",
							"target" => "_blank",
						]);
					},
				]);

				$ui->card([
					"title" => "Card sin padding",
					"padded" => false,
					"content" => function () {
						echo '<div class="pw-px-4 pw-py-2 pw-bg-surface-50 pw-border-b pw-border-surface-100 pw-text-xs pw-text-surface-500">Fila 1 — sin padding en el wrapper</div>';
						echo '<div class="pw-px-4 pw-py-2 pw-bg-white pw-border-b pw-border-surface-100 pw-text-xs pw-text-surface-500">Fila 2</div>';
						echo '<div class="pw-px-4 pw-py-2 pw-bg-surface-50 pw-text-xs pw-text-surface-500">Fila 3</div>';
					},
				]);
			},
		]);

		// ── TAB: TYPOGRAPHY & NAV ─────────────────────────────────────────────
		$ui->tab_panel([
			"slug" => "pg-typography",
			"content" => function () use ($ui) {
				$ui->card([
					"title" => "Headings — h1 a h6",
					"content" => function () use ($ui) {
						foreach (range(1, 6) as $level) {
							$ui->heading([
								"text" =>
									"Heading nivel " .
									$level .
									" (h" .
									$level .
									")",
								"level" => $level,
							]);
							echo '<div class="pw-mb-3"></div>';
						}
					},
				]);

				$ui->card([
					"title" => "Paragraph — variantes",
					"content" => function () use ($ui) {
						$ui->paragraph([
							"text" =>
								"Default — Texto de párrafo estándar usado para contenido principal.",
						]);
						$ui->paragraph([
							"text" =>
								"Muted — Texto secundario, menos prominente, para información de apoyo.",
							"variant" => "muted",
						]);
						$ui->paragraph([
							"text" =>
								"Small — Texto pequeño para notas, metadatos o ayuda contextual.",
							"variant" => "small",
						]);
					},
				]);

				$ui->card([
					"title" => "Links — variantes",
					"content" => function () use ($ui) {
						echo '<div class="pw-flex pw-flex-wrap pw-gap-4 pw-items-center">';
						$ui->link(["label" => "Default link", "href" => "#"]);
						$ui->link([
							"label" => "Muted link",
							"href" => "#",
							"variant" => "muted",
						]);
						$ui->link([
							"label" => "Danger link",
							"href" => "#",
							"variant" => "danger",
						]);
						$ui->link([
							"label" => "External ↗",
							"href" => "#",
							"target" => "_blank",
						]);
						echo "</div>";
					},
				]);

				$ui->card([
					"title" => "Separator",
					"content" => function () use ($ui) {
						$ui->paragraph([
							"text" => "Contenido antes del separator.",
						]);
						$ui->separator();
						$ui->paragraph([
							"text" => "Contenido después del separator.",
						]);
					},
				]);

				$ui->card([
					"title" => "Tabs anidados",
					"content" => function () use ($ui) {
						$ui->notice([
							"type" => "info",
							"message" =>
								"Los tabs de esta página son el ejemplo real de navegación. El componente tab_panel se usa junto a tabs() para mostrar/ocultar contenido.",
						]);
					},
				]);
			},
		]);
	},

	"sidebar" => [
		"title" => "Info del package",
		"content" => function ($bui) {
			$ui = $bui->ui();

			$ui->card([
				"content" => function () use ($ui) {
					$ui->heading(["text" => "pw/backend-ui", "level" => 4]);
					echo '<div class="pw-mt-2 pw-space-y-1">';
					$ui->paragraph([
						"text" => "Versión 1.0.0",
						"variant" => "muted",
					]);
					$ui->paragraph([
						"text" => "Tailwind CSS 4 · Vanilla JS · PHP 8.0+",
						"variant" => "small",
					]);
					echo "</div>";

					$ui->separator();

					$ui->paragraph([
						"text" => "Componentes disponibles",
						"variant" => "small",
					]);
					$components = [
						"button",
						"input",
						"textarea",
						"select",
						"checkbox",
						"toggle",
						"card",
						"notice",
						"badge",
						"heading",
						"paragraph",
						"link",
						"separator",
						"tabs",
						"tab_panel",
					];
					echo '<div class="pw-flex pw-flex-wrap pw-gap-1 pw-mt-1">';
					foreach ($components as $c) {
						$ui->badge([
							"label" => $c,
							"variant" => "default",
							"size" => "sm",
						]);
					}
					echo "</div>";
				},
			]);

			$ui->card([
				"content" => function () use ($ui) {
					$ui->heading(["text" => "Uso rápido", "level" => 5]);
					echo '<div class="pw-mt-2">';
					$ui->paragraph([
						"text" =>
							"Llama playground() para activar esta página:",
						"variant" => "small",
					]);
					echo "</div>";
					// code block simple
					echo '<pre class="pw-mt-2 pw-p-3 pw-bg-surface-900 pw-text-surface-100 pw-rounded-lg pw-text-xs pw-overflow-auto pw-leading-relaxed pw-m-0">BackendUI::playground();</pre>';
					echo '<div class="pw-mt-2">';
					$ui->paragraph([
						"text" =>
							"Llama solo en entornos de desarrollo. No exponer en producción.",
						"variant" => "muted",
					]);
					echo "</div>";
				},
			]);
		},
	],

	"footer" => [
		"left" => function ($bui) {
			$bui->ui()->paragraph([
				"text" => "pw/backend-ui Playground — solo para desarrollo",
				"variant" => "muted",
			]);
		},
	],
]);
