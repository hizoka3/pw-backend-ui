<?php
// views/playground/playground.php

/**
 * PW Backend UI — Component Playground
 * Showcases every component in the design system with all variants.
 *
 * @var \PW\BackendUI\BackendUI $bui
 */

defined("ABSPATH") || exit();

$ui = $bui->ui();

$bui->render_page([
	"title" => "Component Playground",
	"tabs" => [
		["slug" => "buttons", "label" => "Buttons & Badges", "active" => true],
		["slug" => "forms", "label" => "Forms"],
		["slug" => "feedback", "label" => "Feedback"],
		["slug" => "navigation", "label" => "Navigation"],
		["slug" => "typography", "label" => "Typography"],
	],
	"content" => function ($bui) use ($ui) {
		// =====================================================================
		// TAB: BUTTONS & BADGES
		// =====================================================================
		$ui->tab_panel([
			"slug" => "buttons",
			"active" => true,
			"content" => function () use ($ui) {
				// — Buttons —
				$ui->card([
					"title" => "Button variants",
					"content" => function () use ($ui) {
						echo '<div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">';
						$ui->button([
							"label" => "Primary",
							"variant" => "primary",
						]);
						$ui->button([
							"label" => "Default",
							"variant" => "default",
						]);
						$ui->button(["label" => "Ghost", "variant" => "ghost"]);
						$ui->button([
							"label" => "Danger",
							"variant" => "danger",
						]);
						$ui->button([
							"label" => "Invisible",
							"variant" => "invisible",
						]);
						$ui->button([
							"label" => "Disabled",
							"variant" => "primary",
							"disabled" => true,
						]);
						echo "</div>";
					},
				]);

				// — Button sizes —
				$ui->card([
					"title" => "Button sizes",
					"content" => function () use ($ui) {
						echo '<div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">';
						$ui->button(["label" => "Small", "size" => "sm"]);
						$ui->button(["label" => "Medium", "size" => "md"]);
						$ui->button(["label" => "Large", "size" => "lg"]);
						echo "</div>";
					},
				]);

				// — Buttons with icons —
				$save_icon =
					'<svg viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14.354 2.353a.5.5 0 00-.707 0L6 10l-3.646-3.646a.5.5 0 00-.707.707l4 4a.5.5 0 00.707 0l8-8a.5.5 0 000-.708z"/></svg>';
				$plus_icon =
					'<svg viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.75 2a.75.75 0 01.75.75V7h4.25a.75.75 0 010 1.5H8.5v4.25a.75.75 0 01-1.5 0V8.5H2.75a.75.75 0 010-1.5H7V2.75A.75.75 0 017.75 2z"/></svg>';
				$trash_icon =
					'<svg viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6.5 1.75a.25.25 0 01.25-.25h2.5a.25.25 0 01.25.25V3h-3V1.75zm4.5 0V3h2.25a.75.75 0 010 1.5H2.75a.75.75 0 010-1.5H5V1.75C5 .784 5.784 0 6.75 0h2.5C10.216 0 11 .784 11 1.75zM4.496 6.675a.75.75 0 10-1.492.15l.66 6.6A1.75 1.75 0 005.405 15h5.19c.9 0 1.652-.681 1.741-1.576l.66-6.6a.75.75 0 10-1.492-.149l-.66 6.6a.25.25 0 01-.249.225h-5.19a.25.25 0 01-.249-.225l-.66-6.6z"/></svg>';

				$ui->card([
					"title" => "Buttons with icons",
					"content" => function () use (
						$ui,
						$save_icon,
						$plus_icon,
						$trash_icon,
					) {
						echo '<div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">';
						$ui->button([
							"label" => "Save",
							"icon" => $save_icon,
							"variant" => "primary",
						]);
						$ui->button([
							"label" => "New item",
							"icon" => $plus_icon,
							"variant" => "default",
						]);
						$ui->button([
							"label" => "Delete",
							"icon" => $trash_icon,
							"variant" => "danger",
						]);
						$ui->button([
							"icon" => $plus_icon,
							"variant" => "default",
							"attrs" => ["title" => "Add"],
						]);
						echo "</div>";
					},
				]);

				// — Badges —
				$ui->card([
					"title" => "Badge variants",
					"content" => function () use ($ui) {
						echo '<div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">';
						$ui->badge(["label" => "Default"]);
						$ui->badge([
							"label" => "Primary",
							"variant" => "primary",
						]);
						$ui->badge([
							"label" => "Success",
							"variant" => "success",
						]);
						$ui->badge([
							"label" => "Warning",
							"variant" => "warning",
						]);
						$ui->badge([
							"label" => "Danger",
							"variant" => "danger",
						]);
						$ui->badge(["label" => "Info", "variant" => "info"]);
						echo "</div>";
						echo '<div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-top:8px;">';
						$ui->badge([
							"label" => "With dot",
							"variant" => "success",
							"dot" => true,
						]);
						$ui->badge([
							"label" => "Active",
							"variant" => "primary",
							"dot" => true,
						]);
						$ui->badge([
							"label" => "Offline",
							"variant" => "danger",
							"dot" => true,
						]);
						echo "</div>";
					},
				]);

				// — Tooltip —
				$ui->card([
					"title" => "Tooltip",
					"content" => function () use ($ui) {
						echo '<div style="display:flex;flex-wrap:wrap;gap:24px;align-items:center;padding:16px 0;">';
						$ui->tooltip([
							"text" => "This is a tooltip on top",
							"trigger" => function () use ($ui) {
								$ui->button(["label" => "Hover me (top)"]);
							},
						]);
						$ui->tooltip([
							"text" => "Tooltip on bottom",
							"position" => "bottom",
							"trigger" => function () use ($ui) {
								$ui->button([
									"label" => "Hover me (bottom)",
									"variant" => "ghost",
								]);
							},
						]);
						echo "</div>";
					},
				]);
			},
		]);

		// =====================================================================
		// TAB: FORMS
		// =====================================================================
		$ui->tab_panel([
			"slug" => "forms",
			"content" => function () use ($ui) {
				$ui->card([
					"title" => "Text inputs",
					"content" => function () use ($ui) {
						$ui->input([
							"name" => "f_default",
							"label" => "Default input",
							"placeholder" => "Placeholder text",
						]);
						$ui->input([
							"name" => "f_required",
							"label" => "Required field",
							"required" => true,
							"help" => "This field is required.",
						]);
						$ui->input([
							"name" => "f_error",
							"label" => "With error",
							"value" => "bad-value",
							"error" => "This value is not valid.",
						]);
						$ui->input([
							"name" => "f_disabled",
							"label" => "Disabled",
							"value" => 'Can\'t edit this',
							"disabled" => true,
						]);
						$ui->input([
							"name" => "f_email",
							"label" => "Email",
							"type" => "email",
							"placeholder" => "name@example.com",
						]);
						$ui->input([
							"name" => "f_password",
							"label" => "Password",
							"type" => "password",
						]);
					},
				]);

				$ui->card([
					"title" => "Date inputs",
					"content" => function () use ($ui) {
						$ui->date_input([
							"name" => "d_date",
							"label" => "Date",
							"type" => "date",
						]);
						$ui->date_input([
							"name" => "d_datetime",
							"label" => "Date & Time",
							"type" => "datetime-local",
							"max_width" => "280px",
						]);
						$ui->date_input([
							"name" => "d_time",
							"label" => "Time",
							"type" => "time",
							"max_width" => "160px",
						]);
					},
				]);

				$ui->card([
					"title" => "Textarea",
					"content" => function () use ($ui) {
						$ui->textarea([
							"name" => "ta_default",
							"label" => "Message",
							"placeholder" => "Write something…",
							"help" => "Max 500 characters.",
						]);
						$ui->textarea([
							"name" => "ta_error",
							"label" => "With error",
							"error" => "This field is required.",
						]);
					},
				]);

				$ui->card([
					"title" => "Select",
					"content" => function () use ($ui) {
						$ui->select([
							"name" => "s_default",
							"label" => "Choose an option",
							"placeholder" => "— Select —",
							"options" => [
								"option_a" => "Option A",
								"option_b" => "Option B",
								"option_c" => "Option C",
							],
							"help" => "Pick one from the list.",
						]);
						$ui->select([
							"name" => "s_error",
							"label" => "With error",
							"options" => ["a" => "A", "b" => "B"],
							"error" => "Please select a valid option.",
						]);
					},
				]);

				$ui->card([
					"title" => "Checkbox & CheckboxGroup",
					"content" => function () use ($ui) {
						$ui->checkbox([
							"name" => "cb_simple",
							"label" => "Single checkbox",
						]);
						$ui->checkbox([
							"name" => "cb_checked",
							"label" => "Checked by default",
							"checked" => true,
							"help" => "This is enabled.",
						]);
						$ui->checkbox([
							"name" => "cb_disabled",
							"label" => "Disabled",
							"disabled" => true,
						]);

						$ui->separator();

						$ui->checkbox_group([
							"name" => "cbg_features",
							"label" => "Select features",
							"value" => ["cache", "minify"],
							"options" => [
								[
									"value" => "cache",
									"label" => "Enable cache",
									"help" => "Speeds up page load.",
								],
								[
									"value" => "minify",
									"label" => "Minify assets",
									"help" => "Compresses CSS and JS.",
								],
								[
									"value" => "lazy",
									"label" => "Lazy load images",
								],
								[
									"value" => "cdn",
									"label" => "CDN integration",
									"disabled" => true,
								],
							],
						]);
					},
				]);

				$ui->card([
					"title" => "Radio & RadioGroup",
					"content" => function () use ($ui) {
						$ui->radio_group([
							"name" => "rg_plan",
							"label" => "Choose a plan",
							"value" => "pro",
							"options" => [
								[
									"value" => "free",
									"label" => "Free",
									"help" => "Up to 5 items.",
								],
								[
									"value" => "pro",
									"label" => "Pro",
									"help" =>
										"Unlimited items + priority support.",
								],
								[
									"value" => "enterprise",
									"label" => "Enterprise",
									"help" => "Custom SLA.",
									"disabled" => true,
								],
							],
						]);
					},
				]);

				$ui->card([
					"title" => "Toggle switch",
					"content" => function () use ($ui) {
						$ui->toggle([
							"name" => "tog_off",
							"label" => "Notifications",
							"help" => "Send email notifications.",
							"checked" => false,
						]);
						$ui->toggle([
							"name" => "tog_on",
							"label" => "Auto-publish",
							"help" => "Publish automatically on save.",
							"checked" => true,
						]);
						$ui->toggle([
							"name" => "tog_dis",
							"label" => "Disabled",
							"disabled" => true,
						]);
					},
				]);

				$ui->card([
					"title" => "Segmented control",
					"content" => function () use ($ui) {
						$ui->segmented_control([
							"name" => "sc_view",
							"label" => "View mode",
							"value" => "list",
							"options" => [
								["value" => "grid", "label" => "Grid"],
								["value" => "list", "label" => "List"],
								["value" => "compact", "label" => "Compact"],
							],
						]);
						echo "<br>";
						$ui->segmented_control([
							"name" => "sc_range",
							"label" => "Date range",
							"value" => "7d",
							"options" => [
								["value" => "24h", "label" => "24h"],
								["value" => "7d", "label" => "7 days"],
								["value" => "30d", "label" => "30 days"],
								["value" => "90d", "label" => "90 days"],
							],
						]);
					},
				]);
			},
		]);

		// =====================================================================
		// TAB: FEEDBACK
		// =====================================================================
		$ui->tab_panel([
			"slug" => "feedback",
			"content" => function () use ($ui) {
				$ui->card([
					"title" => "Banner — full-width messages",
					"content" => function () use ($ui) {
						$ui->banner([
							"type" => "info",
							"title" => "Info",
							"message" =>
								"This is an informational message for the user.",
						]);
						echo "<br>";
						$ui->banner([
							"type" => "success",
							"title" => "Success",
							"message" =>
								"Your settings have been saved successfully.",
						]);
						echo "<br>";
						$ui->banner([
							"type" => "warning",
							"title" => "Warning",
							"message" =>
								"This action cannot be undone. Please proceed with caution.",
						]);
						echo "<br>";
						$ui->banner([
							"type" => "danger",
							"title" => "Error",
							"message" =>
								"Something went wrong. Please try again.",
						]);
						echo "<br>";
						$ui->banner([
							"type" => "success",
							"title" => "Dismissible",
							"message" => "Click × to close this banner.",
							"dismissible" => true,
						]);
					},
				]);

				$ui->card([
					"title" => "Notice — inline alerts",
					"content" => function () use ($ui) {
						$ui->notice([
							"type" => "info",
							"message" => "Your API key will expire in 7 days.",
						]);
						echo "<br>";
						$ui->notice([
							"type" => "success",
							"message" => "Plugin activated successfully.",
						]);
						echo "<br>";
						$ui->notice([
							"type" => "warning",
							"message" =>
								'Cache is stale. <a href="#">Clear cache</a> to refresh.',
						]);
						echo "<br>";
						$ui->notice([
							"type" => "danger",
							"message" => "Could not connect to the remote API.",
						]);
						echo "<br>";
						$ui->notice([
							"type" => "info",
							"message" =>
								"Dismissible notice — click × to close.",
							"dismissible" => true,
						]);
					},
				]);

				$ui->card([
					"title" => "Spinner",
					"content" => function () use ($ui) {
						echo '<div style="display:flex;align-items:center;gap:20px;">';
						$ui->spinner([
							"size" => "sm",
							"label" => "Loading (sm)",
						]);
						$ui->spinner([
							"size" => "md",
							"label" => "Loading (md)",
						]);
						$ui->spinner([
							"size" => "lg",
							"label" => "Loading (lg)",
						]);
						echo "</div>";
						echo '<div style="display:flex;align-items:center;gap:8px;margin-top:16px;">';
						$ui->spinner([
							"size" => "sm",
							"label" => "Saving changes…",
							"show_label" => true,
						]);
						echo "</div>";
					},
				]);

				$ui->card([
					"title" => "Progress bar",
					"content" => function () use ($ui) {
						$ui->progress_bar([
							"value" => 25,
							"label" => "Uploading…",
							"show_value" => true,
						]);
						echo "<br>";
						$ui->progress_bar([
							"value" => 60,
							"label" => "Processing",
							"show_value" => true,
						]);
						echo "<br>";
						$ui->progress_bar([
							"value" => 90,
							"label" => "Almost done",
							"show_value" => true,
							"variant" => "success",
						]);
						echo "<br>";
						$ui->progress_bar([
							"value" => 45,
							"label" => "Warning",
							"show_value" => true,
							"variant" => "warning",
						]);
						echo "<br>";
						$ui->progress_bar([
							"value" => 15,
							"label" => "Critical",
							"show_value" => true,
							"variant" => "danger",
						]);
					},
				]);
			},
		]);

		// =====================================================================
		// TAB: NAVIGATION
		// =====================================================================
		$ui->tab_panel([
			"slug" => "navigation",
			"content" => function () use ($ui) {
				$ui->card([
					"title" => "Breadcrumbs",
					"content" => function () use ($ui) {
						$ui->breadcrumbs([
							"items" => [
								["label" => "Dashboard", "href" => "#"],
								["label" => "Settings", "href" => "#"],
								["label" => "General"],
							],
						]);
						echo "<br>";
						$ui->breadcrumbs([
							"items" => [
								["label" => "Plugins", "href" => "#"],
								["label" => "My Plugin", "href" => "#"],
								["label" => "Advanced", "href" => "#"],
								["label" => "Webhooks"],
							],
						]);
					},
				]);

				$ui->card([
					"title" => "Pagination",
					"content" => function () use ($ui) {
						$ui->pagination([
							"current" => 3,
							"total" => 12,
						]);
						echo "<br>";
						$ui->pagination([
							"current" => 1,
							"total" => 5,
						]);
						echo "<br>";
						$ui->pagination([
							"current" => 10,
							"total" => 10,
						]);
					},
				]);

				$ui->card([
					"title" => "Tabs (standalone, within content)",
					"content" => function () use ($ui) {
						$ui->tabs([
							"tabs" => [
								[
									"slug" => "inner_a",
									"label" => "Overview",
									"active" => true,
								],
								[
									"slug" => "inner_b",
									"label" => "Details",
									"count" => 4,
								],
								["slug" => "inner_c", "label" => "History"],
							],
						]);
						$ui->tab_panel([
							"slug" => "inner_a",
							"active" => true,
							"content" => function () use ($ui) {
								echo '<div style="padding: 16px 0;">';
								$ui->paragraph([
									"text" =>
										"This is the Overview tab panel content.",
								]);
								echo "</div>";
							},
						]);
						$ui->tab_panel([
							"slug" => "inner_b",
							"content" => function () use ($ui) {
								echo '<div style="padding: 16px 0;">';
								$ui->paragraph([
									"text" =>
										"Details tab content with 4 items.",
									"variant" => "muted",
								]);
								echo "</div>";
							},
						]);
						$ui->tab_panel([
							"slug" => "inner_c",
							"content" => function () use ($ui) {
								echo '<div style="padding: 16px 0;">';
								$ui->paragraph([
									"text" => "History tab content.",
									"variant" => "muted",
								]);
								echo "</div>";
							},
						]);
					},
				]);
			},
		]);

		// =====================================================================
		// TAB: TYPOGRAPHY
		// =====================================================================
		$ui->tab_panel([
			"slug" => "typography",
			"content" => function () use ($ui) {
				$ui->card([
					"title" => "Headings h1 – h6",
					"content" => function () use ($ui) {
						$ui->heading([
							"text" => "Heading 1 — Page title",
							"level" => 1,
						]);
						$ui->separator();
						$ui->heading([
							"text" => "Heading 2 — Section title",
							"level" => 2,
						]);
						$ui->separator();
						$ui->heading([
							"text" => "Heading 3 — Card title",
							"level" => 3,
						]);
						$ui->separator();
						$ui->heading([
							"text" => "Heading 4 — Subsection",
							"level" => 4,
						]);
						$ui->separator();
						$ui->heading([
							"text" => "Heading 5 — Label",
							"level" => 5,
						]);
						$ui->separator();
						$ui->heading([
							"text" => "Heading 6 — Overline",
							"level" => 6,
						]);
					},
				]);

				$ui->card([
					"title" => "Paragraph variants",
					"content" => function () use ($ui) {
						$ui->paragraph([
							"text" =>
								"Default — Use this for primary body text. Ideal for descriptions and explanatory content.",
						]);
						echo "<br>";
						$ui->paragraph([
							"text" =>
								"Muted — Use for secondary information, captions, or supporting text.",
							"variant" => "muted",
						]);
						echo "<br>";
						$ui->paragraph([
							"text" =>
								"Small — Use for fine print, metadata, or timestamps.",
							"variant" => "small",
						]);
					},
				]);

				$ui->card([
					"title" => "Links",
					"content" => function () use ($ui) {
						echo '<div style="display:flex;flex-wrap:wrap;gap:16px;align-items:center;">';
						$ui->link(["label" => "Default link", "href" => "#"]);
						$ui->link([
							"label" => "Muted link",
							"href" => "#",
							"variant" => "muted",
						]);
						$ui->link([
							"label" => "External link",
							"href" => "https://pezweb.cl",
							"target" => "_blank",
						]);
						echo "</div>";
					},
				]);

				$ui->card([
					"title" => "Separator",
					"content" => function () use ($ui) {
						$ui->paragraph([
							"text" => "Content above the separator.",
						]);
						$ui->separator();
						$ui->paragraph([
							"text" => "Content below the separator.",
							"variant" => "muted",
						]);
					},
				]);

				$ui->card([
					"title" => "Card variations",
					"content" => function () use ($ui) {
						$ui->card([
							"title" => "Card with header right slot",
							"description" =>
								"A card that has a badge or action in the top-right corner.",
							"header_right" => function () use ($ui) {
								$ui->badge([
									"label" => "Active",
									"variant" => "success",
									"dot" => true,
								]);
							},
							"content" => function () use ($ui) {
								$ui->paragraph([
									"text" => "Card body content goes here.",
								]);
							},
							"footer" => function () use ($ui) {
								$ui->button([
									"label" => "Save",
									"variant" => "primary",
									"type" => "submit",
								]);
								$ui->button([
									"label" => "Cancel",
									"variant" => "ghost",
								]);
							},
						]);
					},
				]);
			},
		]);
	},

	"sidebar" => [
		"title" => "Package info",
		"content" => function ($bui) use ($ui) {
			$ui->card([
				"content" => function () use ($ui) {
					$ui->badge(["label" => "v2.0.0", "variant" => "primary"]);
					echo '<div style="margin-top: 8px;">';
					$ui->paragraph([
						"text" => "pw/backend-ui",
						"variant" => "muted",
					]);
					$ui->paragraph([
						"text" =>
							"PW Design System for WordPress admin. Inspired by GitHub Primer.",
						"variant" => "small",
					]);
					echo "</div>";
					$ui->separator();
					$ui->link([
						"label" => "GitHub repo",
						"href" => "https://github.com/pez-web/backend-ui",
						"target" => "_blank",
					]);
				},
			]);

			$ui->card([
				"title" => "Components",
				"content" => function () use ($ui) {
					$components = [
						"button",
						"badge",
						"tooltip",
						"input",
						"date_input",
						"textarea",
						"select",
						"checkbox",
						"checkbox_group",
						"radio",
						"radio_group",
						"toggle",
						"segmented_control",
						"card",
						"banner",
						"notice",
						"spinner",
						"progress_bar",
						"breadcrumbs",
						"pagination",
						"tabs",
						"heading",
						"paragraph",
						"link",
						"separator",
					];
					echo '<div style="display:flex;flex-direction:column;gap:4px;">';
					foreach ($components as $c) {
						$ui->badge(["label" => $c, "variant" => "default"]);
					}
					echo "</div>";
				},
			]);
		},
	],
]);
