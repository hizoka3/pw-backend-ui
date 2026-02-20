<?php
// src/Admin/AssetsManager.php

namespace PW\BackendUI\Admin;

/**
 * Enqueues design system assets (Tailwind CSS 4, custom CSS, JS)
 * only on the configured admin screens.
 */
class AssetsManager {

    private array $config;

    public function __construct( array $config ) {
        $this->config = $config;
    }

    /**
     * Hooked to admin_enqueue_scripts.
     * Only loads assets on screens listed in config['screens'].
     */
    public function enqueue( string $hook_suffix ): void {
        if ( ! $this->should_load( $hook_suffix ) ) {
            return;
        }

        $url     = trailingslashit( $this->config['assets_url'] );
        $version = $this->config['version'];
        $slug    = $this->config['slug'];

        // Tailwind CSS 4 via CDN
        wp_enqueue_script(
            $slug . '-tailwind',
            'https://cdn.tailwindcss.com',
            [],
            '4.2',
            false
        );

        // Inline Tailwind config to scope styles and avoid conflicts with WP admin
        wp_add_inline_script(
            $slug . '-tailwind',
            $this->get_tailwind_config(),
            'after'
        );

        // Package stylesheet (custom components, overrides)
        wp_enqueue_style(
            $slug . '-styles',
            $url . 'css/backend-ui.css',
            [],
            $version
        );

        // Package JS (tabs, interactive components)
        wp_enqueue_script(
            $slug . '-scripts',
            $url . 'js/backend-ui.js',
            [],
            $version,
            true
        );

        do_action( 'pw_bui/enqueue_assets', $hook_suffix, $url, $version );
    }

    /**
     * Determines if assets should load on the current screen.
     */
    private function should_load( string $hook_suffix ): bool {
        $screens = $this->config['screens'] ?? [];

        if ( empty( $screens ) ) {
            return false;
        }

        $current_screen = get_current_screen();
        $screen_id      = $current_screen ? $current_screen->id : $hook_suffix;

        return in_array( $screen_id, $screens, true )
            || in_array( $hook_suffix, $screens, true );
    }

    /**
     * Returns inline Tailwind configuration for WP admin context.
     *
     * Uses a prefix pw- to avoid collisions with WP admin classes.
     * Defines the design system color palette and typography.
     */
    private function get_tailwind_config(): string {
        $config = apply_filters( 'pw_bui/tailwind_config', [
            'prefix'   => 'pw-',
            'darkMode' => 'class',
            'theme'    => [
                'extend' => [
                    'colors' => [
                        'brand' => [
                            '50'  => '#eef2ff',
                            '100' => '#e0e7ff',
                            '200' => '#c7d2fe',
                            '300' => '#a5b4fc',
                            '400' => '#818cf8',
                            '500' => '#6366f1',
                            '600' => '#4f46e5',
                            '700' => '#4338ca',
                            '800' => '#3730a3',
                            '900' => '#312e81',
                            '950' => '#1e1b4b',
                        ],
                        'surface' => [
                            '50'  => '#f8fafc',
                            '100' => '#f1f5f9',
                            '200' => '#e2e8f0',
                            '300' => '#cbd5e1',
                            '400' => '#94a3b8',
                            '500' => '#64748b',
                            '600' => '#475569',
                            '700' => '#334155',
                            '800' => '#1e293b',
                            '900' => '#0f172a',
                        ],
                        'success' => [
                            '50'  => '#f0fdf4',
                            '500' => '#22c55e',
                            '700' => '#15803d',
                        ],
                        'warning' => [
                            '50'  => '#fffbeb',
                            '500' => '#f59e0b',
                            '700' => '#b45309',
                        ],
                        'danger' => [
                            '50'  => '#fef2f2',
                            '500' => '#ef4444',
                            '700' => '#b91c1c',
                        ],
                        'info' => [
                            '50'  => '#eff6ff',
                            '500' => '#3b82f6',
                            '700' => '#1d4ed8',
                        ],
                    ],
                ],
            ],
        ]);

        return 'tailwind.config = ' . wp_json_encode( $config ) . ';';
    }
}
