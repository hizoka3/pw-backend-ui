<?php
// src/Components/ComponentRenderer.php

namespace PW\BackendUI\Components;

/**
 * Renders individual UI components.
 *
 * Each method echoes the component HTML directly.
 * All methods accept an $atts array; unrecognised keys are ignored.
 */
class ComponentRenderer
{
	private array $config;
	private string $views_dir;

	public function __construct(array $config)
	{
		$this->config = $config;
		$this->views_dir = dirname(__DIR__, 2) . "/views/components/";
	}

	/** @internal */
	private function render(string $template, array $atts): void
	{
		include $this->views_dir . $template;
	}

	// =========================================================================
	// BUTTONS
	// =========================================================================

	/**
	 * Render a button.
	 *
	 * @param array $atts {
	 *     @type string  $label    Button text.
	 *     @type string  $type     'button' | 'submit' | 'reset'.
	 *     @type string  $variant  'primary' | 'default' | 'ghost' | 'danger' | 'invisible'.
	 *     @type string  $size     'sm' | 'md' | 'lg'.
	 *     @type string  $icon     Optional SVG/HTML prepended to label.
	 *     @type bool    $disabled Whether button is disabled.
	 *     @type string  $class    Additional CSS classes.
	 *     @type array   $attrs    Extra HTML attributes.
	 * }
	 */
	public function button(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"label" => "Button",
			"type" => "button",
			"variant" => "default",
			"size" => "md",
			"icon" => "",
			"disabled" => false,
			"class" => "",
			"attrs" => [],
		]);
		$this->render("button.php", $atts);
	}

	// =========================================================================
	// FORM INPUTS
	// =========================================================================

	/**
	 * Render a text / email / password / number / URL input.
	 *
	 * @param array $atts {
	 *     @type string  $name         Input name.
	 *     @type string  $label        Label text.
	 *     @type string  $value        Current value.
	 *     @type string  $placeholder  Placeholder text.
	 *     @type string  $type         Input type. Default: 'text'.
	 *     @type string  $help         Help text.
	 *     @type string  $error        Error message (triggers error state).
	 *     @type bool    $required     Whether field is required.
	 *     @type bool    $disabled     Whether field is disabled.
	 *     @type string  $class        Additional CSS classes.
	 * }
	 */
	public function input(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"name" => "",
			"label" => "",
			"value" => "",
			"placeholder" => "",
			"type" => "text",
			"help" => "",
			"error" => "",
			"required" => false,
			"disabled" => false,
			"class" => "",
			"id" => "",
		]);
		$this->render("input.php", $atts);
	}

	/**
	 * Render a date / datetime-local / time input.
	 *
	 * @param array $atts {
	 *     @type string  $name       Input name.
	 *     @type string  $label      Label text.
	 *     @type string  $value      Current value (Y-m-d for date, etc.).
	 *     @type string  $type       'date' | 'datetime-local' | 'time'. Default: 'date'.
	 *     @type string  $min        Min date/time string.
	 *     @type string  $max        Max date/time string.
	 *     @type string  $help       Help text.
	 *     @type string  $error      Error message.
	 *     @type bool    $required   Whether required.
	 *     @type bool    $disabled   Whether disabled.
	 *     @type string  $max_width  CSS max-width for the input. Default: '240px'.
	 *     @type string  $class      Additional CSS classes.
	 * }
	 */
	public function date_input(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"name" => "",
			"label" => "",
			"value" => "",
			"type" => "date",
			"min" => "",
			"max" => "",
			"help" => "",
			"error" => "",
			"required" => false,
			"disabled" => false,
			"max_width" => "240px",
			"class" => "",
		]);
		$this->render("date-input.php", $atts);
	}

	/**
	 * Render a textarea.
	 *
	 * @param array $atts {
	 *     @type string  $name         Input name.
	 *     @type string  $label        Label text.
	 *     @type string  $value        Current value.
	 *     @type string  $placeholder  Placeholder text.
	 *     @type int     $rows         Number of rows. Default: 4.
	 *     @type string  $help         Help text.
	 *     @type string  $error        Error message.
	 *     @type bool    $required     Whether required.
	 *     @type bool    $disabled     Whether disabled.
	 *     @type string  $class        Additional CSS classes.
	 * }
	 */
	public function textarea(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"name" => "",
			"label" => "",
			"value" => "",
			"placeholder" => "",
			"rows" => 4,
			"help" => "",
			"error" => "",
			"required" => false,
			"disabled" => false,
			"class" => "",
		]);
		$this->render("textarea.php", $atts);
	}

	/**
	 * Render a select dropdown.
	 *
	 * @param array $atts {
	 *     @type string  $name         Input name.
	 *     @type string  $label        Label text.
	 *     @type string  $value        Currently selected value.
	 *     @type array   $options      ['value' => 'Label'] or [['value','label','disabled']].
	 *     @type string  $placeholder  Empty option text.
	 *     @type string  $help         Help text.
	 *     @type string  $error        Error message.
	 *     @type bool    $required     Whether required.
	 *     @type bool    $disabled     Whether disabled.
	 *     @type string  $class        Additional CSS classes.
	 * }
	 */
	public function select(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"name" => "",
			"label" => "",
			"value" => "",
			"options" => [],
			"placeholder" => "",
			"help" => "",
			"error" => "",
			"required" => false,
			"disabled" => false,
			"class" => "",
		]);
		$this->render("select.php", $atts);
	}

	/**
	 * Render a single checkbox.
	 *
	 * @param array $atts {
	 *     @type string  $name     Input name.
	 *     @type string  $label    Label text.
	 *     @type bool    $checked  Whether checked.
	 *     @type string  $value    Input value. Default: '1'.
	 *     @type string  $help     Help text.
	 *     @type bool    $disabled Whether disabled.
	 *     @type string  $class    Additional CSS classes.
	 * }
	 */
	public function checkbox(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"name" => "",
			"label" => "",
			"checked" => false,
			"value" => "1",
			"help" => "",
			"disabled" => false,
			"class" => "",
		]);
		$this->render("checkbox.php", $atts);
	}

	/**
	 * Render a group of checkboxes.
	 *
	 * @param array $atts {
	 *     @type string  $name     Input name (will submit as name[]).
	 *     @type string  $label    Group label (legend).
	 *     @type array   $value    Array of currently selected values.
	 *     @type array   $options  [['value','label','help','disabled'], ...].
	 *     @type string  $help     Group-level help text.
	 *     @type string  $error    Error message.
	 *     @type bool    $required Whether required.
	 *     @type bool    $disabled Whether all disabled.
	 *     @type string  $class    Additional CSS classes.
	 * }
	 */
	public function checkbox_group(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"name" => "",
			"label" => "",
			"value" => [],
			"options" => [],
			"help" => "",
			"error" => "",
			"required" => false,
			"disabled" => false,
			"class" => "",
		]);
		$this->render("checkbox-group.php", $atts);
	}

	/**
	 * Render a single radio button.
	 *
	 * @param array $atts {
	 *     @type string  $name     Input name (shared across radio group).
	 *     @type string  $label    Label text.
	 *     @type string  $value    Input value.
	 *     @type bool    $checked  Whether this radio is selected.
	 *     @type string  $help     Help text.
	 *     @type bool    $disabled Whether disabled.
	 *     @type string  $class    Additional CSS classes.
	 * }
	 */
	public function radio(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"name" => "",
			"label" => "",
			"value" => "",
			"checked" => false,
			"help" => "",
			"disabled" => false,
			"class" => "",
		]);
		$this->render("radio.php", $atts);
	}

	/**
	 * Render a group of radio buttons.
	 *
	 * @param array $atts {
	 *     @type string  $name     Input name.
	 *     @type string  $label    Group label (legend).
	 *     @type string  $value    Currently selected value.
	 *     @type array   $options  [['value','label','help','disabled'], ...].
	 *     @type string  $help     Group-level help text.
	 *     @type string  $error    Error message.
	 *     @type bool    $required Whether required.
	 *     @type bool    $disabled Whether all disabled.
	 *     @type string  $class    Additional CSS classes.
	 * }
	 */
	public function radio_group(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"name" => "",
			"label" => "",
			"value" => "",
			"options" => [],
			"help" => "",
			"error" => "",
			"required" => false,
			"disabled" => false,
			"class" => "",
		]);
		$this->render("radio-group.php", $atts);
	}

	/**
	 * Render an on/off toggle switch.
	 *
	 * @param array $atts {
	 *     @type string  $name     Input name.
	 *     @type string  $label    Label text.
	 *     @type bool    $checked  Whether toggled on.
	 *     @type string  $value    Value sent when on. Default: '1'.
	 *     @type string  $help     Help text.
	 *     @type bool    $disabled Whether disabled.
	 *     @type string  $class    Additional CSS classes.
	 * }
	 */
	public function toggle(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"name" => "",
			"label" => "",
			"checked" => false,
			"value" => "1",
			"help" => "",
			"disabled" => false,
			"class" => "",
		]);
		$this->render("toggle.php", $atts);
	}

	/**
	 * Render a segmented control — pick one from a small set of options.
	 * Primer equivalent: SegmentedControl.
	 *
	 * @param array $atts {
	 *     @type string  $name     Input name (hidden input).
	 *     @type string  $label    Label text shown above.
	 *     @type string  $value    Currently selected value.
	 *     @type array   $options  [['value','label','icon','disabled'], ...].
	 *     @type string  $help     Help text.
	 *     @type bool    $disabled Whether all options disabled.
	 *     @type string  $class    Additional CSS classes.
	 * }
	 */
	public function segmented_control(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"name" => "",
			"label" => "",
			"value" => "",
			"options" => [],
			"help" => "",
			"disabled" => false,
			"class" => "",
		]);
		$this->render("segmented-control.php", $atts);
	}

	// =========================================================================
	// LAYOUT & CONTAINERS
	// =========================================================================

	/**
	 * Render a card container.
	 *
	 * @param array $atts {
	 *     @type string    $title        Card title.
	 *     @type string    $description  Card subtitle/description.
	 *     @type callable  $header_right Callable for right side of header.
	 *     @type callable  $content      Callable for card body.
	 *     @type callable  $footer       Callable for card footer.
	 *     @type bool      $padded       Whether body has padding. Default: true.
	 *     @type string    $class        Additional CSS classes.
	 * }
	 */
	public function card(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"title" => "",
			"description" => "",
			"header_right" => null,
			"content" => null,
			"footer" => null,
			"padded" => true,
			"class" => "",
		]);
		$this->render("card.php", $atts);
	}

	// =========================================================================
	// FEEDBACK & STATUS
	// =========================================================================

	/**
	 * Render a notice / inline alert.
	 *
	 * @param array $atts {
	 *     @type string  $message      Notice text (HTML allowed via wp_kses_post).
	 *     @type string  $type         'info' | 'success' | 'warning' | 'danger'.
	 *     @type bool    $dismissible  Whether notice can be closed.
	 *     @type string  $class        Additional CSS classes.
	 * }
	 */
	public function notice(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"message" => "",
			"type" => "info",
			"dismissible" => false,
			"class" => "",
		]);
		$this->render("notice.php", $atts);
	}

	/**
	 * Render a full-width banner for important messages.
	 * Primer equivalent: Banner.
	 *
	 * @param array $atts {
	 *     @type string  $title        Bold banner title (optional).
	 *     @type string  $message      Message text (HTML allowed via wp_kses_post).
	 *     @type string  $type         'info' | 'success' | 'warning' | 'danger'.
	 *     @type bool    $dismissible  Whether banner can be closed.
	 *     @type string  $class        Additional CSS classes.
	 * }
	 */
	public function banner(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"title" => "",
			"message" => "",
			"type" => "info",
			"dismissible" => false,
			"class" => "",
		]);
		$this->render("banner.php", $atts);
	}

	/**
	 * Render a badge / label tag.
	 *
	 * @param array $atts {
	 *     @type string  $label    Badge text.
	 *     @type string  $variant  'default' | 'primary' | 'success' | 'warning' | 'danger' | 'info'.
	 *     @type bool    $dot      Whether to show a colored dot before the label.
	 *     @type string  $class    Additional CSS classes.
	 * }
	 */
	public function badge(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"label" => "",
			"variant" => "default",
			"dot" => false,
			"class" => "",
		]);
		$this->render("badge.php", $atts);
	}

	/**
	 * Render a loading spinner.
	 * Primer equivalent: Spinner.
	 *
	 * @param array $atts {
	 *     @type string  $size        'sm' | 'md' | 'lg'. Default: 'md'.
	 *     @type string  $label       Accessible label text.
	 *     @type bool    $show_label  Whether to show visible label text. Default: false.
	 *     @type string  $class       Additional CSS classes.
	 * }
	 */
	public function spinner(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"size" => "md",
			"label" => "Loading…",
			"show_label" => false,
			"class" => "",
		]);
		$this->render("spinner.php", $atts);
	}

	/**
	 * Render a progress bar.
	 * Primer equivalent: ProgressBar.
	 *
	 * @param array $atts {
	 *     @type int     $value       Percentage 0-100.
	 *     @type string  $label       Label shown above the bar.
	 *     @type bool    $show_value  Whether to show % value next to label. Default: false.
	 *     @type string  $variant     '' | 'success' | 'warning' | 'danger'. Default: ''.
	 *     @type string  $class       Additional CSS classes.
	 * }
	 */
	public function progress_bar(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"value" => 0,
			"label" => "",
			"show_value" => false,
			"variant" => "",
			"class" => "",
		]);
		$this->render("progress-bar.php", $atts);
	}

	// =========================================================================
	// NAVIGATION
	// =========================================================================

	/**
	 * Render a pagination component.
	 * Primer equivalent: Pagination.
	 *
	 * @param array $atts {
	 *     @type int     $current     Current page number.
	 *     @type int     $total       Total number of pages.
	 *     @type string  $base_url    URL for link-based pagination (optional).
	 *                                If empty, renders <button> elements with data-pw-page attr.
	 *     @type int     $show_pages  Number of page buttons around current. Default: 2.
	 *     @type string  $class       Additional CSS classes.
	 * }
	 */
	public function pagination(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"current" => 1,
			"total" => 1,
			"base_url" => "",
			"show_pages" => 2,
			"class" => "",
		]);
		$this->render("pagination.php", $atts);
	}

	/**
	 * Render breadcrumbs navigation.
	 * Primer equivalent: Breadcrumbs.
	 *
	 * @param array $atts {
	 *     @type array   $items  [ ['label' => 'Home', 'href' => '/'], ... ] — last item = current.
	 *     @type string  $class  Additional CSS classes.
	 * }
	 */
	public function breadcrumbs(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"items" => [],
			"class" => "",
		]);
		$this->render("breadcrumbs.php", $atts);
	}

	/**
	 * Render a tabs navigation bar.
	 *
	 * @param array $atts {
	 *     @type array   $tabs   [ ['slug','label','active','count'], ... ]
	 *     @type string  $class  Additional CSS classes.
	 * }
	 */
	public function tabs(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"tabs" => [],
			"class" => "",
		]);
		$this->render("tabs.php", $atts);
	}

	/**
	 * Render a tab panel content wrapper.
	 *
	 * @param array $atts {
	 *     @type string    $slug     Tab slug — must match a tab's slug.
	 *     @type bool      $active   Whether this panel is visible initially.
	 *     @type callable  $content  Callable that outputs panel content.
	 *     @type string    $class    Additional CSS classes.
	 * }
	 */
	public function tab_panel(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"slug" => "",
			"active" => false,
			"content" => null,
			"class" => "",
		]);
		$this->render("tab-panel.php", $atts);
	}

	/**
	 * Render a tooltip wrapper around a trigger element.
	 * Primer equivalent: Tooltip.
	 *
	 * @param array $atts {
	 *     @type string          $text      Tooltip text shown on hover/focus.
	 *     @type string|callable $trigger   HTML string or callable that outputs the trigger element.
	 *     @type string          $position  'top' (default) | 'bottom'.
	 *     @type string          $class     Additional CSS classes for the wrapper.
	 * }
	 */
	public function tooltip(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"text" => "",
			"trigger" => "",
			"position" => "top",
			"class" => "",
		]);
		$this->render("tooltip.php", $atts);
	}

	// =========================================================================
	// TYPOGRAPHY
	// =========================================================================

	/**
	 * Render a heading h1-h6.
	 *
	 * @param array $atts {
	 *     @type string  $text   Heading text.
	 *     @type int     $level  1-6. Default: 2.
	 *     @type string  $class  Additional CSS classes.
	 * }
	 */
	public function heading(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"text" => "",
			"level" => 2,
			"class" => "",
		]);
		$this->render("heading.php", $atts);
	}

	/**
	 * Render a paragraph.
	 *
	 * @param array $atts {
	 *     @type string  $text     Paragraph text (HTML allowed via wp_kses_post).
	 *     @type string  $variant  'default' | 'muted' | 'small'.
	 *     @type string  $class    Additional CSS classes.
	 * }
	 */
	public function paragraph(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"text" => "",
			"variant" => "default",
			"class" => "",
		]);
		$this->render("paragraph.php", $atts);
	}

	/**
	 * Render an anchor link.
	 *
	 * @param array $atts {
	 *     @type string  $label    Link text.
	 *     @type string  $href     URL.
	 *     @type string  $target   '_self' | '_blank'. Default: '_self'.
	 *     @type string  $variant  'default' | 'muted'. Default: 'default'.
	 *     @type string  $class    Additional CSS classes.
	 * }
	 */
	public function link(array $atts = []): void
	{
		$atts = wp_parse_args($atts, [
			"label" => "",
			"href" => "#",
			"target" => "_self",
			"variant" => "default",
			"class" => "",
		]);
		$this->render("link.php", $atts);
	}

	/**
	 * Render a horizontal separator.
	 *
	 * @param array $atts {
	 *     @type string  $class  Additional CSS classes.
	 * }
	 */
	public function separator(array $atts = []): void
	{
		$atts = wp_parse_args($atts, ["class" => ""]);
		$this->render("separator.php", $atts);
	}
}
