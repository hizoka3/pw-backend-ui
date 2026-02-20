<?php
// src/Components/ComponentRenderer.php

namespace PW\BackendUI\Components;

/**
 * Renders individual UI components with Tailwind CSS classes.
 *
 * Each method outputs (echoes) the component HTML directly.
 * All methods accept an $atts array for customization.
 * Use the return variants (get_*) when you need the HTML as a string.
 */
class ComponentRenderer {

    private array $config;

    public function __construct( array $config ) {
        $this->config = $config;
    }

    // =========================================================================
    // BUTTONS
    // =========================================================================

    /**
     * Render a button.
     *
     * @param array $atts {
     *     @type string $label    Button text.
     *     @type string $type     'button' | 'submit' | 'reset'.
     *     @type string $variant  'primary' | 'secondary' | 'outline' | 'ghost' | 'danger'.
     *     @type string $size     'sm' | 'md' | 'lg'.
     *     @type string $icon     Optional icon SVG or HTML (prepended).
     *     @type bool   $disabled Whether button is disabled.
     *     @type string $class    Additional CSS classes.
     *     @type array  $attrs    Extra HTML attributes ['data-action' => 'save'].
     * }
     */
    public function button( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'label'    => 'Button',
            'type'     => 'button',
            'variant'  => 'primary',
            'size'     => 'md',
            'icon'     => '',
            'disabled' => false,
            'class'    => '',
            'attrs'    => [],
        ]);

        include __DIR__ . '/../../views/components/button.php';
    }

    // =========================================================================
    // FORM INPUTS
    // =========================================================================

    /**
     * Render a text input with label.
     *
     * @param array $atts {
     *     @type string $name        Input name attribute.
     *     @type string $label       Label text.
     *     @type string $value       Current value.
     *     @type string $placeholder Placeholder text.
     *     @type string $type        'text' | 'email' | 'password' | 'url' | 'number'.
     *     @type string $help        Help text shown below input.
     *     @type string $error       Error message (shows error state).
     *     @type bool   $required    Whether field is required.
     *     @type bool   $disabled    Whether field is disabled.
     *     @type string $class       Additional CSS classes.
     * }
     */
    public function input( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'name'        => '',
            'label'       => '',
            'value'       => '',
            'placeholder' => '',
            'type'        => 'text',
            'help'        => '',
            'error'       => '',
            'required'    => false,
            'disabled'    => false,
            'class'       => '',
        ]);

        include __DIR__ . '/../../views/components/input.php';
    }

    /**
     * Render a textarea with label.
     *
     * @param array $atts {
     *     @type string $name        Input name attribute.
     *     @type string $label       Label text.
     *     @type string $value       Current value.
     *     @type string $placeholder Placeholder text.
     *     @type int    $rows        Number of rows.
     *     @type string $help        Help text shown below textarea.
     *     @type string $error       Error message (shows error state).
     *     @type bool   $required    Whether field is required.
     *     @type bool   $disabled    Whether field is disabled.
     *     @type string $class       Additional CSS classes.
     * }
     */
    public function textarea( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'name'        => '',
            'label'       => '',
            'value'       => '',
            'placeholder' => '',
            'rows'        => 4,
            'help'        => '',
            'error'       => '',
            'required'    => false,
            'disabled'    => false,
            'class'       => '',
        ]);

        include __DIR__ . '/../../views/components/textarea.php';
    }

    /**
     * Render a select dropdown with label.
     *
     * @param array $atts {
     *     @type string $name        Input name attribute.
     *     @type string $label       Label text.
     *     @type string $value       Current selected value.
     *     @type array  $options     [ 'value' => 'Label', ... ] or [ [ 'value' => '', 'label' => '' ], ... ]
     *     @type string $placeholder Placeholder option text.
     *     @type string $help        Help text shown below select.
     *     @type string $error       Error message.
     *     @type bool   $required    Whether field is required.
     *     @type bool   $disabled    Whether field is disabled.
     *     @type string $class       Additional CSS classes.
     * }
     */
    public function select( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'name'        => '',
            'label'       => '',
            'value'       => '',
            'options'     => [],
            'placeholder' => '— Select —',
            'help'        => '',
            'error'       => '',
            'required'    => false,
            'disabled'    => false,
            'class'       => '',
        ]);

        include __DIR__ . '/../../views/components/select.php';
    }

    /**
     * Render a checkbox.
     *
     * @param array $atts {
     *     @type string $name     Input name attribute.
     *     @type string $label    Label text next to checkbox.
     *     @type bool   $checked  Whether checked.
     *     @type string $value    Input value.
     *     @type string $help     Help text.
     *     @type bool   $disabled Whether disabled.
     *     @type string $class    Additional CSS classes.
     * }
     */
    public function checkbox( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'name'     => '',
            'label'    => '',
            'checked'  => false,
            'value'    => '1',
            'help'     => '',
            'disabled' => false,
            'class'    => '',
        ]);

        include __DIR__ . '/../../views/components/checkbox.php';
    }

    /**
     * Render a toggle switch.
     *
     * @param array $atts {
     *     @type string $name     Input name attribute.
     *     @type string $label    Label text.
     *     @type bool   $checked  Whether toggled on.
     *     @type string $value    Input value.
     *     @type string $help     Help text.
     *     @type bool   $disabled Whether disabled.
     *     @type string $class    Additional CSS classes.
     * }
     */
    public function toggle( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'name'     => '',
            'label'    => '',
            'checked'  => false,
            'value'    => '1',
            'help'     => '',
            'disabled' => false,
            'class'    => '',
        ]);

        include __DIR__ . '/../../views/components/toggle.php';
    }

    // =========================================================================
    // LAYOUT & STRUCTURE
    // =========================================================================

    /**
     * Render a card container.
     *
     * @param array $atts {
     *     @type string   $title   Card title (optional).
     *     @type string   $description Card description (optional).
     *     @type callable $content Function that outputs the card body.
     *     @type callable $footer  Function that outputs the card footer.
     *     @type bool     $padded  Whether to add padding to the body.
     *     @type string   $class   Additional CSS classes.
     * }
     */
    public function card( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'title'       => '',
            'description' => '',
            'content'     => null,
            'footer'      => null,
            'padded'      => true,
            'class'       => '',
        ]);

        include __DIR__ . '/../../views/components/card.php';
    }

    /**
     * Render a notice/alert.
     *
     * @param array $atts {
     *     @type string $message     Notice text.
     *     @type string $type        'info' | 'success' | 'warning' | 'danger'.
     *     @type bool   $dismissible Whether notice can be dismissed.
     *     @type string $class       Additional CSS classes.
     * }
     */
    public function notice( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'message'     => '',
            'type'        => 'info',
            'dismissible' => false,
            'class'       => '',
        ]);

        include __DIR__ . '/../../views/components/notice.php';
    }

    /**
     * Render a badge/tag.
     *
     * @param array $atts {
     *     @type string $label   Badge text.
     *     @type string $variant 'default' | 'primary' | 'success' | 'warning' | 'danger'.
     *     @type string $size    'sm' | 'md'.
     *     @type string $class   Additional CSS classes.
     * }
     */
    public function badge( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'label'   => '',
            'variant' => 'default',
            'size'    => 'md',
            'class'   => '',
        ]);

        include __DIR__ . '/../../views/components/badge.php';
    }

    /**
     * Render a heading.
     *
     * @param array $atts {
     *     @type string $text  Heading text.
     *     @type int    $level 1-6 for h1-h6.
     *     @type string $class Additional CSS classes.
     * }
     */
    public function heading( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'text'  => '',
            'level' => 2,
            'class' => '',
        ]);

        include __DIR__ . '/../../views/components/heading.php';
    }

    /**
     * Render a paragraph.
     *
     * @param array $atts {
     *     @type string $text    Paragraph text.
     *     @type string $variant 'default' | 'muted' | 'small'.
     *     @type string $class   Additional CSS classes.
     * }
     */
    public function paragraph( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'text'    => '',
            'variant' => 'default',
            'class'   => '',
        ]);

        include __DIR__ . '/../../views/components/paragraph.php';
    }

    /**
     * Render a link.
     *
     * @param array $atts {
     *     @type string $label   Link text.
     *     @type string $href    URL.
     *     @type string $target  '_self' | '_blank'.
     *     @type string $variant 'default' | 'muted' | 'danger'.
     *     @type string $class   Additional CSS classes.
     * }
     */
    public function link( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'label'   => '',
            'href'    => '#',
            'target'  => '_self',
            'variant' => 'default',
            'class'   => '',
        ]);

        include __DIR__ . '/../../views/components/link.php';
    }

    /**
     * Render a separator/divider.
     *
     * @param array $atts {
     *     @type string $class Additional CSS classes.
     * }
     */
    public function separator( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'class' => '',
        ]);

        include __DIR__ . '/../../views/components/separator.php';
    }

    /**
     * Render a tabs navigation (content handled via JS).
     *
     * @param array $atts {
     *     @type array  $tabs  [ [ 'slug' => '', 'label' => '', 'active' => false ], ... ]
     *     @type string $class Additional CSS classes.
     * }
     */
    public function tabs( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'tabs'  => [],
            'class' => '',
        ]);

        include __DIR__ . '/../../views/components/tabs.php';
    }

    /**
     * Render a tab panel content wrapper.
     *
     * @param array $atts {
     *     @type string   $slug    Tab slug matching tabs() slug.
     *     @type bool     $active  Whether this panel is visible initially.
     *     @type callable $content Function that outputs the panel content.
     *     @type string   $class   Additional CSS classes.
     * }
     */
    public function tab_panel( array $atts = [] ): void {
        $atts = wp_parse_args( $atts, [
            'slug'    => '',
            'active'  => false,
            'content' => null,
            'class'   => '',
        ]);

        include __DIR__ . '/../../views/components/tab-panel.php';
    }
}
