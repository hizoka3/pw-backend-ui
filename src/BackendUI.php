<?php
// src/BackendUI.php

namespace PW\BackendUI;

use PW\BackendUI\Admin\AssetsManager;
use PW\BackendUI\Components\ComponentRenderer;

/**
 * Entry point for the pw/backend-ui design system.
 *
 * **Multi-plugin:** call `BackendUI::init([...])` from each plugin with its screens
 * and brand. Configurations are merged automatically (union of screens, one shared
 * asset bundle on stable handles). Header brand resolves per current screen via
 * `effective_brand()`.
 *
 * @see AssetsManager::CORE_STYLE_HANDLE Depend on this handle for plugin CSS that must load after Backend UI.
 */
class BackendUI
{
	public const CORE_STYLE_HANDLE = AssetsManager::CORE_STYLE_HANDLE;

	public const CORE_SCRIPT_HANDLE = AssetsManager::CORE_SCRIPT_HANDLE;

	public const CORE_BRIDGE_STYLE_HANDLE = AssetsManager::CORE_BRIDGE_STYLE_HANDLE;

	private static ?self $instance = null;

	/** @var list<array<string, mixed>> */
	private static array $fragments = [];

	private static bool $hooks_attached = false;

	private AssetsManager $assets;

	private ComponentRenderer $ui;

	private array $config;

	private function __construct(array $config)
	{
		$this->config = wp_parse_args($config, self::config_defaults());
		$this->assets = new AssetsManager($this->config);
		$this->ui = new ComponentRenderer($this->config);
	}

	/**
	 * Default config keys (used when merging and as baselines).
	 *
	 * @return array<string, mixed>
	 */
	private static function config_defaults(): array
	{
		return [
			'assets_url' => '',
			'version' => '1.0.0',
			'screens' => [],
			'slug' => 'pw-bui-core',
			'admin_bridge' => false,
			'bridge_screens' => null,
			'brand' => [
				'name' => '',
				'plugin_name' => '',
				'version' => '',
				'logo_url' => '',
			],
			'brand_by_screen' => [],
		];
	}

	/**
	 * Initialize or update the design system singleton.
	 *
	 * Each call with a non-empty `$config` registers another **fragment** (typically
	 * one per plugin). Fragments are merged; subsequent calls reconfigure the same
	 * instance so load order among plugins does not require manual priorities.
	 *
	 * @param array $config {
	 *     @type string   $assets_url  Full URL to the package assets/ dir (required for enqueue).
	 *     @type string   $version     Cache-busting version (highest among fragments wins).
	 *     @type string[] $screens     WP admin screen IDs where assets load and brand applies.
	 *     @type string   $slug        Deprecated — handles are fixed (pw-bui-core-*). Ignored for assets.
	 *     @type bool     $admin_bridge
	 *     @type string[]|null $bridge_screens
	 *     @type array    $brand       Merged into header; if `screens` non-empty, also mapped per screen ID.
	 * }
	 */
	public static function init(array $config = []): self
	{
		if ($config !== []) {
			self::$fragments[] = $config;
		}

		$merged = self::merge_fragments(self::$fragments);
		$merged = apply_filters('pw_bui/merged_config', $merged, self::$fragments);

		if (self::$instance === null) {
			self::$instance = new self($merged);
			self::attach_instance_hooks(self::$instance);
		} else {
			self::$instance->reconfigure($merged);
		}

		return self::$instance;
	}

	/**
	 * Brand for the current admin screen (header in page-wrapper).
	 * Falls back to merged `brand` from fragments that registered without specific screens.
	 *
	 * @return array<string, string>
	 */
	public function effective_brand(): array
	{
		$base = isset($this->config['brand']) && is_array($this->config['brand'])
			? $this->config['brand']
			: [];
		$screen = function_exists('get_current_screen') ? get_current_screen() : null;
		$id = ($screen && isset($screen->id)) ? (string) $screen->id : '';
		$map = isset($this->config['brand_by_screen']) && is_array($this->config['brand_by_screen'])
			? $this->config['brand_by_screen']
			: [];
		if ($id !== '' && isset($map[$id]) && is_array($map[$id]) && $map[$id] !== []) {
			return array_merge($base, $map[$id]);
		}

		return $base;
	}

	private function reconfigure(array $config): void
	{
		$this->config = wp_parse_args($config, self::config_defaults());
		$this->assets->update_config($this->config);
		$this->ui->update_config($this->config);
	}

	private static function attach_instance_hooks(self $instance): void
	{
		if (self::$hooks_attached) {
			return;
		}
		self::$hooks_attached = true;
		add_action('admin_enqueue_scripts', [$instance->assets, 'enqueue']);
		add_filter('admin_body_class', [$instance, 'filter_admin_body_class']);
	}

	/**
	 * @param list<array<string, mixed>> $fragments
	 * @return array<string, mixed>
	 */
	private static function merge_fragments(array $fragments): array
	{
		if ($fragments === []) {
			return self::config_defaults();
		}

		$screens = [];
		$bridge_screens = [];
		$assets_url = '';
		$version_best = '0.0.0';
		$base_brand = [];
		$brand_by_screen = [];
		$admin_bridge = false;

		foreach ($fragments as $f) {
			if (!is_array($f) || $f === []) {
				continue;
			}

			if (!empty($f['screens']) && is_array($f['screens'])) {
				foreach ($f['screens'] as $id) {
					if (is_string($id) && $id !== '') {
						$screens[] = $id;
					}
				}
			}

			if (!empty($f['bridge_screens']) && is_array($f['bridge_screens'])) {
				foreach ($f['bridge_screens'] as $id) {
					if (is_string($id) && $id !== '') {
						$bridge_screens[] = $id;
					}
				}
			}

			if (!empty($f['assets_url']) && is_string($f['assets_url'])) {
				if ($assets_url === '') {
					$assets_url = $f['assets_url'];
				}
			}

			if (!empty($f['version']) && is_string($f['version'])) {
				if (version_compare($f['version'], $version_best, '>')) {
					$version_best = $f['version'];
				}
			}

			$b = (!empty($f['brand']) && is_array($f['brand'])) ? $f['brand'] : [];
			$frag_screens = (!empty($f['screens']) && is_array($f['screens'])) ? $f['screens'] : [];

			if ($frag_screens === []) {
				$base_brand = array_merge($base_brand, $b);
			} else {
				foreach ($frag_screens as $sid) {
					if (!is_string($sid) || $sid === '') {
						continue;
					}
					if (!isset($brand_by_screen[$sid])) {
						$brand_by_screen[$sid] = [];
					}
					$brand_by_screen[$sid] = array_merge($brand_by_screen[$sid], $b);
				}
			}

			if (!empty($f['admin_bridge'])) {
				$admin_bridge = true;
			}
		}

		$screens = array_values(array_unique($screens));
		$bridge_screens = array_values(array_unique($bridge_screens));

		$fragment_count = 0;
		foreach ($fragments as $f) {
			if (is_array($f) && $f !== []) {
				++$fragment_count;
			}
		}
		if ($fragment_count > 1 && $assets_url !== '' && defined('WP_DEBUG') && WP_DEBUG) {
			$urls = [];
			foreach ($fragments as $f) {
				if (!empty($f['assets_url']) && is_string($f['assets_url'])) {
					$urls[$f['assets_url']] = true;
				}
			}
			if (count($urls) > 1) {
				trigger_error(
					'pw/backend-ui: Multiple assets_url values in merged config; using the first. Align package paths across plugins.',
					E_USER_NOTICE,
				);
			}
		}

		return [
			'assets_url' => $assets_url,
			'version' => $version_best === '0.0.0' ? '1.0.0' : $version_best,
			'slug' => 'pw-bui-core',
			'screens' => $screens,
			'brand' => $base_brand,
			'brand_by_screen' => $brand_by_screen,
			'admin_bridge' => $admin_bridge,
			'bridge_screens' => $bridge_screens !== [] ? $bridge_screens : null,
		];
	}

	public function filter_admin_body_class(string $classes): string
	{
		if (empty($this->config['admin_bridge'])) {
			return $classes;
		}

		$screens = $this->config['bridge_screens'] ?? $this->config['screens'] ?? [];
		if (empty($screens)) {
			return $classes;
		}

		$screen = get_current_screen();
		if (!$screen || !in_array($screen->id, $screens, true)) {
			return $classes;
		}

		return $classes . ' pw-bui-admin';
	}

	public function ui(): ComponentRenderer
	{
		return $this->ui;
	}

	public function config(?string $key = null): mixed
	{
		if ($key === null) {
			return $this->config;
		}

		return $this->config[$key] ?? null;
	}

	public function render_page(array $page): void
	{
		$page = wp_parse_args($page, [
			'title' => '',
			'description' => '',
			'breadcrumbs' => [],
			'tabs' => [],
			'content' => null,
			'sidenav' => null,
			'sidebar' => null,
			'footer' => null,
		]);

		$page = apply_filters('pw_bui/page_config', $page);

		$bui = $this;
		include __DIR__ . '/../views/layout/page-wrapper.php';
	}

	public static function playground(array $opts = []): void
	{
		static $registered = false;
		if ($registered) {
			return;
		}
		$registered = true;

		$opts = wp_parse_args($opts, [
			'capability' => 'manage_options',
			'menu_order' => 99,
		]);

		add_action('admin_menu', function () use ($opts) {
			add_menu_page(
				'PW UI Playground',
				'PW Playground',
				$opts['capability'],
				'pw-bui-playground',
				[self::class, '_render_playground'],
				'dashicons-art',
				(int) $opts['menu_order'],
			);

			self::_register_playground_screen();
		});
	}

	public static function _register_playground_screen(): void
	{
		$instance = self::$instance;
		if (!$instance) {
			return;
		}

		$pg_screen = 'toplevel_page_pw-bui-playground';
		if (!in_array($pg_screen, $instance->config['screens'], true)) {
			$instance->config['screens'][] = $pg_screen;
			$instance->assets->update_config($instance->config);
			$instance->ui->update_config($instance->config);
		}
	}

	public static function _render_playground(): void
	{
		$bui = self::$instance;
		$page = [
			'title' => 'PW UI Playground',
			'description' => 'Todos los componentes del design system.',
			'tabs' => [
				[
					'slug' => 'buttons',
					'label' => 'Botones & Badges',
					'active' => true,
				],
				['slug' => 'forms', 'label' => 'Formularios'],
				['slug' => 'feedback', 'label' => 'Feedback'],
				['slug' => 'navigation', 'label' => 'Navegación'],
				['slug' => 'layout', 'label' => 'Tipo & Layout'],
				['slug' => 'containers', 'label' => 'Contenedores'],
			],
			'content' => function (BackendUI $bui) {
				include __DIR__ . '/../views/playground/playground.php';
			},
			'sidebar' => [
				'title' => 'Componentes',
				'content' => function (BackendUI $bui) {
					$ui = $bui->ui();
					$ui->card([
						'content' => function () use ($ui) {
							$components = [
								'button',
								'badge',
								'input',
								'textarea',
								'select',
								'checkbox',
								'toggle',
								'radio',
								'radio_group',
								'date_input',
								'segmented_control',
								'card',
								'notice',
								'spinner',
								'progress_bar',
								'breadcrumbs',
								'pagination',
								'tooltip',
								'skeleton',
								'heading',
								'section_label',
								'stats_bar',
								'data_table',
								'paragraph',
								'link',
								'separator',
								'tabs',
								'tab_panel',
								'side_nav',
								'stepper',
								'switch',
							];
							echo '<div style="display:flex;flex-direction:column;gap:4px;">';
							foreach ($components as $c) {
								echo '<code style="font-size:11px;color:var(--pw-color-fg-muted);">' .
									esc_html($c) .
									'()</code>';
							}
							echo '</div>';
						},
					]);
					$ui->separator();
					$ui->paragraph([
						'text' => 'pw/backend-ui v1.2.0',
						'variant' => 'muted',
					]);
				},
			],
		];

		$page = apply_filters('pw_bui/page_config', $page);
		include __DIR__ . '/../views/layout/page-wrapper.php';
	}

	public static function reset(): void
	{
		if (self::$instance !== null) {
			remove_action('admin_enqueue_scripts', [self::$instance->assets, 'enqueue']);
			remove_filter('admin_body_class', [self::$instance, 'filter_admin_body_class']);
		}
		self::$instance = null;
		self::$fragments = [];
		self::$hooks_attached = false;
	}
}
