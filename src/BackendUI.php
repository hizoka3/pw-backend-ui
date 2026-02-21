<?php
// src/BackendUI.php

namespace PW\BackendUI;

use PW\BackendUI\Admin\AssetsManager;
use PW\BackendUI\Components\ComponentRenderer;

/**
 * Entry point for the pw/backend-ui design system.
 *
 * Singleton. Call BackendUI::init($config) once in plugins_loaded,
 * then use BackendUI::init()->render_page() or BackendUI::init()->ui().
 */
class BackendUI
{
	private static ?self $instance = null;
	private static bool $playground = false;

	private AssetsManager $assets;
	private ComponentRenderer $ui;
	private array $config;

	const PLAYGROUND_SLUG = "pw-bui-playground";

	private function __construct(array $config)
	{
		$this->config = wp_parse_args($config, [
			"assets_url" => "",
			"version" => "1.0.0",
			"screens" => [],
			"slug" => "pw-backend-ui",
			"theme" => "dark", // 'dark' | 'light' — default dark
			"brand" => [
				"name" => "",
				"logo_url" => "",
			],
		]);

		$this->assets = new AssetsManager($this->config);
		$this->ui = new ComponentRenderer($this->config);
	}

	/**
	 * Initialize the design system (singleton).
	 *
	 * @param array $config {
	 *     @type string   $assets_url  Full URL to the package assets/ dir (required).
	 *     @type string   $version     Package version for cache busting.
	 *     @type string[] $screens     WP admin screen IDs where assets load.
	 *     @type string   $slug        Unique slug used for CSS/JS handles.
	 *     @type string   $theme       Default theme: 'dark' (default) | 'light'.
	 *                                 User can override at runtime via the header toggle button.
	 *     @type array    $brand       { name: string, logo_url: string }
	 * }
	 */
	public static function init(array $config = []): self
	{
		if (self::$instance === null) {
			self::$instance = new self($config);
			self::$instance->boot();
		}
		return self::$instance;
	}

	/**
	 * Register a playground admin page showing all components.
	 *
	 * Idempotent — safe to call multiple times.
	 * Assets load automatically on the playground screen.
	 *
	 * Usage:
	 *
	 *   if ( defined('WP_DEBUG') && WP_DEBUG ) {
	 *       BackendUI::playground();
	 *   }
	 *
	 * @param array $options {
	 *     @type string  $capability   WP capability required. Default: 'manage_options'.
	 *     @type int     $menu_order   Admin menu position. Default: 99.
	 * }
	 */
	public static function playground(array $options = []): void
	{
		if (self::$playground) {
			return;
		}
		self::$playground = true;

		$options = wp_parse_args($options, [
			"capability" => "manage_options",
			"menu_order" => 99,
		]);

		add_action("admin_menu", function () use ($options) {
			add_menu_page(
				"PW UI Playground",
				"PW Playground",
				$options["capability"],
				self::PLAYGROUND_SLUG,
				[self::class, "_render_playground"],
				"dashicons-color-picker",
				$options["menu_order"],
			);
			self::init()->_register_playground_screen();
		});
	}

	/** @internal */
	public function _register_playground_screen(): void
	{
		$screen_id = "toplevel_page_" . self::PLAYGROUND_SLUG;
		if (!in_array($screen_id, $this->config["screens"], true)) {
			$this->config["screens"][] = $screen_id;
		}
	}

	/** @internal */
	public static function _render_playground(): void
	{
		$bui = self::init();
		include dirname(__DIR__) . "/views/playground/playground.php";
	}

	private function boot(): void
	{
		add_action("admin_enqueue_scripts", [$this->assets, "enqueue"]);
	}

	/**
	 * Access the component renderer for individual UI elements.
	 */
	public function ui(): ComponentRenderer
	{
		return $this->ui;
	}

	/**
	 * Get the current config or a single value.
	 */
	public function config(?string $key = null): mixed
	{
		return $key === null ? $this->config : $this->config[$key] ?? null;
	}

	/**
	 * Render a full settings page wrapped in the design system layout.
	 *
	 * @param array $page {
	 *     @type string    $title        Page title shown in the header.
	 *     @type string    $description  Short description under the title.
	 *     @type array     $tabs         [ ['slug','label','active','count'], ... ]
	 *     @type callable  $content      Function that outputs the page body.
	 *     @type array     $sidebar      [ 'title' => '', 'content' => callable ]
	 *     @type array     $footer       [ 'left' => callable, 'right' => callable ]
	 * }
	 */
	public function render_page(array $page): void
	{
		$page = wp_parse_args($page, [
			"title" => "",
			"description" => "",
			"tabs" => [],
			"content" => null,
			"sidebar" => null,
			"footer" => null,
		]);

		$page = apply_filters("pw_bui/page_config", $page);

		include dirname(__DIR__) . "/views/layout/page-wrapper.php";
	}

	/**
	 * Reset singleton — useful for testing.
	 * @internal
	 */
	public static function reset(): void
	{
		self::$instance = null;
		self::$playground = false;
	}
}
