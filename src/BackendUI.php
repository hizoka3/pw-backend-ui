<?php
// src/BackendUI.php

namespace PW\BackendUI;

use PW\BackendUI\Admin\AssetsManager;
use PW\BackendUI\Components\ComponentRenderer;

/**
 * Entry point for the pw/backend-ui design system.
 *
 * Singleton. Call BackendUI::init($config) once in plugins_loaded,
 * then use BackendUI::init()->render_page() to wrap your settings page
 * and BackendUI::init()->ui() to access individual component methods.
 */
class BackendUI
{
	private static ?self $instance = null;
	private static bool $playground = false;

	private AssetsManager $assets;
	private ComponentRenderer $ui;
	private array $config;

	/** Slug used to register the playground admin page. */
	const PLAYGROUND_SLUG = "pw-bui-playground";

	private function __construct(array $config)
	{
		$this->config = wp_parse_args($config, [
			"assets_url" => "",
			"version" => "1.0.0",
			"screens" => [],
			"slug" => "pw-backend-ui",
			"brand" => [
				"name" => "",
				"logo_url" => "",
			],
		]);

		$this->assets = new AssetsManager($this->config); // passed by reference — see AssetsManager::__construct
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
	 * Register a playground admin page with all components rendered.
	 *
	 * Call once after init(), ideally inside a WP_DEBUG check so it never
	 * appears in production. Assets load automatically for the playground screen.
	 *
	 * Usage:
	 *
	 *   if ( defined('WP_DEBUG') && WP_DEBUG ) {
	 *       BackendUI::playground();
	 *   }
	 *
	 * @param array $options {
	 *     @type string $capability  Minimum WP capability to access the page.
	 *                               Default: 'manage_options'.
	 *     @type int    $menu_order  Admin menu position. Default: 99.
	 * }
	 */
	public static function playground(array $options = []): void
	{
		if (self::$playground) {
			return; // idempotent — safe to call multiple times
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

			// Auto-register the playground screen so assets load on it
			self::init()->_register_playground_screen();
		});
	}

	/**
	 * Add the playground screen ID to the list of screens that load assets.
	 * Works because AssetsManager holds $config by reference — no hook re-registration needed.
	 * @internal
	 */
	public function _register_playground_screen(): void
	{
		$screen_id = "toplevel_page_" . self::PLAYGROUND_SLUG;

		if (!in_array($screen_id, $this->config["screens"], true)) {
			$this->config["screens"][] = $screen_id;
			// AssetsManager receives $this->config by reference, so it sees this
			// change automatically on the next admin_enqueue_scripts call.
		}
	}

	/**
	 * Render callback for the playground page.
	 * @internal
	 */
	public static function _render_playground(): void
	{
		$bui = self::init(); // returns existing singleton
		// The view uses $this (BackendUI instance) — bind it via a closure
		$render = \Closure::bind(
			static function () {
				include __DIR__ . "/../views/playground/playground.php";
			},
			$bui,
			BackendUI::class,
		);
		$render();
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
	 * Get the current config.
	 */
	public function config(?string $key = null): mixed
	{
		if ($key === null) {
			return $this->config;
		}
		return $this->config[$key] ?? null;
	}

	/**
	 * Render a full settings page wrapped in the design system layout.
	 *
	 * @param array $page {
	 *     @type string   $title       Page title shown in the header.
	 *     @type string   $description Short description under the title.
	 *     @type array    $tabs        [ [ 'slug' => 'general', 'label' => 'General', 'active' => true ], ... ]
	 *     @type callable $content     Function that outputs the page body.
	 *     @type array    $sidebar     Optional sidebar config: [ 'title' => '', 'content' => callable ].
	 *     @type array    $footer      Optional footer config: [ 'left' => callable, 'right' => callable ].
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

		include __DIR__ . "/../views/layout/page-wrapper.php";
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
