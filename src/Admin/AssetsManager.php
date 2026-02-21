<?php
// src/Admin/AssetsManager.php

namespace PW\BackendUI\Admin;

/**
 * Enqueues design system assets (CSS, JS) only on configured admin screens.
 *
 * v2: Token-based design system — no Tailwind CDN dependency.
 * Styles live entirely in backend-ui.css (CSS variables + component styles).
 */
class AssetsManager
{
	private array $config;

	public function __construct(array &$config)
	{
		$this->config = &$config; // reference — playground can add screens after boot
	}

	/**
	 * Hooked to admin_enqueue_scripts.
	 */
	public function enqueue(string $hook_suffix): void
	{
		if (!$this->should_load($hook_suffix)) {
			return;
		}

		$url = trailingslashit($this->config["assets_url"]);
		$version = $this->config["version"];
		$slug = $this->config["slug"];

		// Package stylesheet
		wp_enqueue_style(
			$slug . "-styles",
			$url . "css/backend-ui.css",
			[],
			$version,
		);

		// Package JS
		wp_enqueue_script(
			$slug . "-scripts",
			$url . "js/backend-ui.js",
			[],
			$version,
			true,
		);

		do_action("pw_bui/enqueue_assets", $hook_suffix, $url, $version);
	}

	/**
	 * Determines if assets should load on the current screen.
	 */
	private function should_load(string $hook_suffix): bool
	{
		$screens = $this->config["screens"] ?? [];

		if (empty($screens)) {
			return false;
		}

		$current_screen = get_current_screen();
		$screen_id = $current_screen ? $current_screen->id : $hook_suffix;

		return in_array($screen_id, $screens, true) ||
			in_array($hook_suffix, $screens, true);
	}
}
