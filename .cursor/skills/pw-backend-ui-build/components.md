# pw/backend-ui — Component API Reference

Access: `$ui = $bui->ui();` then `$ui->method($atts)`.

## Forms

**input**
```php
$ui->input([
    'name' => '', 'label' => '', 'value' => '', 'type' => 'text',
    'placeholder' => '', 'help' => '', 'error' => '',
    'required' => false, 'disabled' => false,
    'min' => '', 'max' => '',
    'class' => '', 'wrapper_class' => '',
]);
```
Types: `text`, `email`, `password`, `url`, `number`, `search`, `tel`, `time`, `datetime-local`, `file`, `range`, `color`.

**date_input** — alias for `input()` with `type => 'date'`.
```php
$ui->date_input(['name' => 'start', 'label' => 'Start Date', 'min' => '2024-01-01']);
```

**textarea**
```php
$ui->textarea([
    'name' => '', 'label' => '', 'value' => '', 'rows' => 4,
    'placeholder' => '', 'help' => '', 'error' => '',
    'required' => false, 'disabled' => false,
]);
```

**select**
```php
$ui->select([
    'name' => '', 'label' => '', 'value' => '',
    'options' => ['val' => 'Label', ...],
    'placeholder' => '', 'help' => '', 'error' => '',
    'required' => false, 'disabled' => false,
    'wrapper_class' => '',
]);
```
Options accept associative `['value' => 'label']` or array-of-arrays `[['value' => '', 'label' => '', 'disabled' => false]]`.

**checkbox**
```php
$ui->checkbox([
    'name' => '', 'label' => '', 'value' => '1',
    'checked' => false, 'help' => '', 'disabled' => false,
]);
```

**toggle**
```php
$ui->toggle([
    'name' => '', 'label' => '', 'checked' => false, 'disabled' => false,
]);
```

**switch**
```php
$ui->switch([
    'name' => '', 'label' => '', 'checked' => false,
    'variant' => 'default',     // 'default' | 'status'
    'status_label' => '',       // shown when variant='status'
    'data_attrs' => [],
]);
```

**radio** (single)
```php
$ui->radio(['name' => '', 'label' => '', 'value' => '', 'checked' => false]);
```

**radio_group**
```php
$ui->radio_group([
    'name' => '', 'label' => '', 'value' => '',
    'options' => [['value' => '', 'label' => '', 'help' => ''], ...],
]);
```

**segmented_control**
```php
$ui->segmented_control([
    'name' => '', 'label' => '', 'value' => '',
    'options' => [['value' => '', 'label' => ''], ...],
]);
```

## Buttons

**button**
```php
$ui->button([
    'label' => '', 'variant' => 'primary', 'size' => 'md',
    'type' => 'button',         // 'button' | 'submit' | 'reset'
    'icon' => '',               // SVG HTML string
    'disabled' => false,
    'href' => '',               // if set, renders <a> instead of <button>
    'target' => '',
    'class' => '', 'wrapper_class' => '',
    'attrs' => [],              // e.g. ['data-pw-wizard-next' => '']
]);
```
Variants: `primary`, `secondary`, `outline`, `ghost`, `danger`, `invisible`.
Sizes: `sm`, `md`, `lg`.
When `href` is set, `disabled` is not supported.

## Content / Structure

**card**
```php
$ui->card([
    'title' => '', 'description' => '',
    'content' => function () use ($ui) { ... },
    'footer'  => function () use ($ui) { ... },
    'padded' => true,           // false for flush content (e.g. list rows)
]);
```

**notice**
```php
$ui->notice([
    'type' => 'info',           // 'info' | 'success' | 'warning' | 'danger'
    'title' => '', 'message' => '',
    'dismissible' => false,
]);
```

**badge**
```php
$ui->badge([
    'label' => '', 'variant' => 'default', 'size' => 'md',
]);
```
Variants: `default`, `primary`, `success`, `warning`, `danger`, `info`.

**separator**
```php
$ui->separator();
```

## Typography

**heading**
```php
$ui->heading(['text' => '', 'level' => 2]);        // h1-h6
$ui->heading(['text' => '', 'variant' => 'eyebrow']); // renders <p>, small caps
```

**section_label** — small caps section divider
```php
$ui->section_label(['text' => 'Section name']);
```

**paragraph**
```php
$ui->paragraph(['text' => '', 'variant' => 'default']); // 'default' | 'muted' | 'small'
```

**link**
```php
$ui->link(['label' => '', 'href' => '', 'target' => '_blank', 'variant' => 'default']);
```
Variants: `default`, `muted`, `danger`.

## Feedback / State

**spinner**
```php
$ui->spinner(['size' => 'md']); // 'sm' | 'md' | 'lg'
```

**progress_bar**
```php
$ui->progress_bar([
    'value' => 65, 'label' => '', 'show_value' => true,
    'variant' => 'default', 'size' => 'sm',
]);
```

**skeleton**
```php
$ui->skeleton(['type' => 'text', 'lines' => 3]);
$ui->skeleton(['type' => 'box', 'height' => '120px']);
```
Types: `text`, `title`, `box`, `avatar`.

**tooltip**
```php
$ui->tooltip([
    'text' => 'Tooltip text', 'position' => 'top',
    'trigger' => function () use ($ui) {
        $ui->button(['label' => 'Hover me', 'variant' => 'ghost']);
    },
]);
```

## Data Display

**stats_bar**
```php
$ui->stats_bar([
    'items' => [
        ['label' => 'Total', 'value' => '$1,200'],
        ['label' => 'Net', 'value' => '$980', 'breakdown' => '<span>Sub <strong>$800</strong></span>'],
    ],
]);
```

**data_table**
```php
$ui->data_table([
    'headers' => ['Field', 'Value'],
    'rows'    => [['Name', 'Acme'], ['Status', 'Active']],
    'full_width_headers' => false,
]);
```

## Navigation

**tabs + tab_panel** (JS mode)
```php
$ui->tab_panel([
    'slug' => 'general', 'active' => true,
    'content' => function () use ($ui) { ... },
]);
```

**side_nav**
```php
$ui->side_nav([
    'items' => [
        ['label' => 'Connection', 'href' => '#conn', 'active' => true],
        ['label' => 'Advanced',   'href' => '#adv'],
        ['separator' => true],
        ['group' => 'Danger Zone'],
        ['label' => 'Reset', 'href' => '#reset'],
    ],
]);
```

**breadcrumbs**
```php
$ui->breadcrumbs([
    'items' => [
        ['label' => 'Dashboard', 'href' => admin_url()],
        ['label' => 'Settings'],
    ],
]);
```

**pagination**
```php
$ui->pagination([
    'current' => 1, 'total' => 10,
    'base_url' => admin_url('admin.php?page=my-plugin'),
    'param' => 'paged', 'window' => 2,
]);
```

**accordion**
```php
$ui->accordion([
    'items' => [
        ['title' => 'Section A', 'content' => function () use ($ui) { ... }, 'open' => true],
        ['title' => 'Section B', 'content' => 'Plain text content'],
    ],
    'multiple' => false,
]);
```

**stepper** (wizard indicator)
```php
$ui->stepper([
    'steps' => [
        ['slug' => 'step-1', 'label' => 'Account',  'state' => 'active'],
        ['slug' => 'step-2', 'label' => 'Settings', 'state' => 'pending'],
        ['slug' => 'step-3', 'label' => 'Finish',   'state' => 'pending'],
    ],
]);
```
