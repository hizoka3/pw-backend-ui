<?php
// src/Admin/AssetsManager.php

namespace PW\BackendUI\Admin;

/**
 * Enqueues design system assets on configured admin screens.
 * Uses stable WordPress handles (pw-bui-core-*) so multiple plugins never load
 * duplicate copies of the same CSS/JS under different slugs.
 */
class AssetsManager
{
	public const CORE_STYLE_HANDLE = 'pw-bui-core-styles';

	public const CORE_SCRIPT_HANDLE = 'pw-bui-core-scripts';

	public const CORE_BRIDGE_STYLE_HANDLE = 'pw-bui-core-admin-bridge';

	private array $config;

	/** @var string assets_url|version fingerprint last registered */
	private string $registered_fingerprint = '';

	private bool $inline_boot_script_added = false;

	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function update_config(array $config): void
	{
		$this->config = $config;
		$fp = $this->fingerprint();
		if ($fp !== $this->registered_fingerprint) {
			$this->deregister_handles();
			$this->registered_fingerprint = '';
			$this->inline_boot_script_added = false;
		}
	}

	private function fingerprint(): string
	{
		return (string) ($this->config['assets_url'] ?? '') . '|' . (string) ($this->config['version'] ?? '');
	}

	private function deregister_handles(): void
	{
		wp_deregister_style(self::CORE_STYLE_HANDLE);
		wp_deregister_style(self::CORE_BRIDGE_STYLE_HANDLE);
		wp_deregister_script(self::CORE_SCRIPT_HANDLE);
	}

	/**
	 * Register core style/script once per URL+version pair.
	 */
	private function ensure_registered(): void
	{
		$fp = $this->fingerprint();
		if ($fp === $this->registered_fingerprint) {
			return;
		}

		$this->deregister_handles();

		$url = trailingslashit((string) ($this->config['assets_url'] ?? ''));
		$version = (string) ($this->config['version'] ?? '1.0.0');

		wp_register_style(
			self::CORE_STYLE_HANDLE,
			$url . 'css/backend-ui.css',
			[],
			$version,
		);
		wp_register_script(
			self::CORE_SCRIPT_HANDLE,
			$url . 'js/backend-ui.js',
			[],
			$version,
			true,
		);

		$this->registered_fingerprint = $fp;
	}

	/**
	 * Hooked to admin_enqueue_scripts.
	 */
	public function enqueue(string $hook_suffix): void
	{
		if (!$this->should_load($hook_suffix)) {
			return;
		}

		$this->ensure_registered();

		wp_enqueue_style(self::CORE_STYLE_HANDLE);
		wp_enqueue_script(self::CORE_SCRIPT_HANDLE);

		if (!$this->inline_boot_script_added) {
			wp_add_inline_script(
				self::CORE_SCRIPT_HANDLE,
				"try{var __pwt=localStorage.getItem('pw-bui-theme');if(__pwt==='light'||__pwt==='dark'){var __pwa=document.getElementById('pw-backend-ui-app');if(__pwa){__pwa.setAttribute('data-pw-theme',__pwt);}}}catch(e){}",
				'before',
			);
			$this->inline_boot_script_added = true;
		}

		if ($this->should_apply_admin_bridge($hook_suffix)) {
			$url = trailingslashit((string) ($this->config['assets_url'] ?? ''));
			$version = (string) ($this->config['version'] ?? '1.0.0');
			wp_register_style(
				self::CORE_BRIDGE_STYLE_HANDLE,
				$url . 'css/backend-ui-admin-bridge.css',
				[self::CORE_STYLE_HANDLE],
				$version,
			);
			wp_enqueue_style(self::CORE_BRIDGE_STYLE_HANDLE);
		}

		$url = trailingslashit((string) ($this->config['assets_url'] ?? ''));
		do_action('pw_bui/enqueue_assets', $hook_suffix, $url, $this->config['version'] ?? '1.0.0');
	}

	private function should_load(string $hook_suffix): bool
	{
		$screens = $this->config['screens'] ?? [];

		if (empty($screens)) {
			return false;
		}

		$current_screen = get_current_screen();
		$screen_id = $current_screen ? $current_screen->id : $hook_suffix;

		return in_array($screen_id, $screens, true) ||
			in_array($hook_suffix, $screens, true);
	}

	private function should_apply_admin_bridge(string $hook_suffix): bool
	{
		if (empty($this->config['admin_bridge'])) {
			return false;
		}

		$screens = $this->config['bridge_screens'] ?? $this->config['screens'] ?? [];
		if (empty($screens)) {
			return false;
		}

		$current_screen = get_current_screen();
		$screen_id = $current_screen ? $current_screen->id : $hook_suffix;

		return in_array($screen_id, $screens, true) ||
			in_array($hook_suffix, $screens, true);
	}
}
