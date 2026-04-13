# pw/backend-ui — Layout Recipes, Tokens & Events

## Spacing Rules

### Token Scale

| Token | Value | Use |
|-------|-------|-----|
| `--pw-space-1` | 4px | Icon gaps, inner spacing |
| `--pw-space-2` | 8px | Control gaps, label-to-input |
| `--pw-space-3` | 12px | Nav item horizontal padding |
| `--pw-space-4` | 16px | Card padding, form-gap |
| `--pw-space-5` | 20px | Intra-card block spacing |
| `--pw-space-6` | 24px | Content padding, layout-gap |
| `--pw-space-8` | 32px | Section-to-section |
| `--pw-content-padding` | 24px | Main content area padding |
| `--pw-layout-gap` | 24px | Column grid gap |
| `--pw-card-padding` | 16px | Card interior padding |
| `--pw-form-gap` | 16px | Vertical gap between form fields |

### Element-to-Element Rules

| Context | Token | Value |
|---------|-------|-------|
| Heading to paragraph | `--pw-space-2` | 8px |
| Paragraph to paragraph | `--pw-space-2` | 8px |
| Card to card (horizontal) | `--pw-layout-gap` | 24px |
| Section to section | `--pw-space-8` | 32px |
| Label to form control | `--pw-space-2` | 8px |
| Field to field | `--pw-form-gap` | 16px |
| Container to sibling container | `--pw-layout-gap` | 24px |

Always use tokens — never arbitrary pixel values.

---

## Design Tokens

### Backgrounds (nesting depth)

Use progressively deeper backgrounds for nested containers:

| Level | Token | Use |
|-------|-------|-----|
| 0 (root) | `--pw-color-bg-subtle` | Cards, surfaces |
| 1 (nested) | `--pw-color-bg-inset` | Inputs, thead, inner containers |
| 2 (deeper) | `--pw-color-bg-emphasis` | Secondary buttons, emphasis areas |
| 3 (leaf) | `--pw-color-bg-overlay` | Hover, overlays, floating panels |

Page base is `--pw-color-bg-default` (pure black in dark / pure white in light).

### Foreground

| Token | Use |
|-------|-----|
| `--pw-color-fg-default` | Primary text |
| `--pw-color-fg-muted` | Secondary text, descriptions |
| `--pw-color-fg-subtle` | Tertiary text, labels, captions |
| `--pw-color-fg-onEmphasis` | Text on emphasis backgrounds |

### Borders

| Token | Use |
|-------|-----|
| `--pw-color-border-default` | Standard dividers |
| `--pw-color-border-muted` | Subtle inner dividers |
| `--pw-color-border-emphasis` | High-contrast borders |

### Semantic Colors

Each semantic color has four tiers: `-fg`, `-emphasis`, `-subtle`, `-muted`.

| Prefix | Use |
|--------|-----|
| `--pw-color-accent-*` | Brand red (#ff0000) |
| `--pw-color-success-*` | Green — success states |
| `--pw-color-warning-*` | Yellow — warnings |
| `--pw-color-danger-*` | Red — errors, destructive |
| `--pw-color-info-*` | Blue — informational |

### Focus, Controls & Other

| Token | Use |
|-------|-----|
| `--pw-color-focus-border` | Blue focus ring on inputs (#5ba4e5) |
| `--pw-color-focus-ring` | Outer focus ring |
| `--pw-color-control-border` | Input/select border color |
| `--pw-radius-field` | Input/select border radius |
| `--pw-radius-button` | Button border radius |
| `--pw-radius-card` | Card border radius |
| `--pw-shadow-sm/md/lg` | Elevation levels |
| `--pw-font-sans` | Roboto, system stack |
| `--pw-font-mono-codes` | Courier New — for codes/RUTs |

---

## CSS Grid Layout Recipes

Use CSS Grid with design tokens. Tailwind utility classes also available (CDN, no `@apply`).

### Two equal columns
```php
echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--pw-layout-gap);">';
```

### Main + sidebar (2fr 1fr)
```php
echo '<div style="display:grid;grid-template-columns:2fr 1fr;gap:var(--pw-layout-gap);">';
```

### Three-column metrics
```php
echo '<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:var(--pw-layout-gap);">';
```

### Four-column grid
```php
echo '<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:var(--pw-layout-gap);">';
```

### Center-dominant (1fr 2fr 1fr)
```php
echo '<div style="display:grid;grid-template-columns:1fr 2fr 1fr;gap:var(--pw-layout-gap);">';
```

### Dashboard geometry (grid-template-areas)
```php
echo '<div style="display:grid;grid-template-columns:1fr 1fr 280px;grid-template-rows:40px auto 1fr;gap:var(--pw-layout-gap);grid-template-areas:\'status status aside\' \'m1 m2 aside\' \'table table aside\';">';
echo '<div style="grid-area:status;">...</div>';
echo '<div style="grid-area:m1;">...</div>';
echo '<div style="grid-area:aside;">...</div>';
echo '</div>';
```

### Scroll container with sticky header
```php
echo '<div style="border:1px solid var(--pw-color-border-default);">';
echo '<div style="position:sticky;top:0;padding:8px 16px;background:var(--pw-color-bg-emphasis);border-bottom:1px solid var(--pw-color-border-default);">Header</div>';
echo '<div class="pw-bui-scroll" style="max-height:300px;">';
// scrollable rows
echo '</div></div>';
```

### Split panes (master-detail)
```php
echo '<div style="display:grid;grid-template-columns:1fr 1fr;align-items:stretch;border:1px solid var(--pw-color-border-default);">';
echo '<div style="border-right:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);">Left</div>';
echo '<div style="padding:var(--pw-card-padding);">Right</div>';
echo '</div>';
```

### Masonry (CSS columns)
```php
echo '<div style="column-count:3;column-gap:var(--pw-layout-gap);">';
echo '<div style="break-inside:avoid;margin-bottom:var(--pw-layout-gap);">Item</div>';
echo '</div>';
```

### Action grid buttons

Flat, full-bleed action buttons at the bottom of a container:
```html
<div style="display:grid;grid-template-columns:1fr 1fr;border-top:1px solid var(--pw-color-border-default);">
    <button type="button" class="pw-bui-action-grid">Action A</button>
    <button type="button" class="pw-bui-action-grid" style="border-left:1px solid var(--pw-color-border-default);">Action B</button>
</div>
```
Variant: `pw-bui-action-grid--orange` for accent actions.
Inline badge-style actions for row items: `pw-bui-action`, `pw-bui-action--orange`, `pw-bui-action--danger`.

---

## JS Events

Listen on `document`:

| Event | detail | Fired when |
|-------|--------|------------|
| `pw-bui:ready` | — | JS fully initialized |
| `pw-bui:theme-changed` | `{ theme }` | Theme toggled (`'dark'` or `'light'`) |
| `pw-bui:tab-changed` | `{ slug }` | Tab switched (JS mode) |
| `pw-bui:toggle-changed` | `{ name, checked, value }` | Toggle state changed |
| `pw-bui:segment-changed` | `{ name, value }` | Segmented control changed |
| `pw-bui:accordion-changed` | `{ open, title }` | Accordion panel toggled |
| `pw-bui:wizard-step-changed` | `{ from, to, index }` | Wizard step navigation |

---

## WordPress Hooks

| Hook | Type | Parameters |
|------|------|------------|
| `pw_bui/page_config` | filter | `array $page` — modify page config before render |
| `pw_bui/enqueue_assets` | action | `$hook_suffix, $assets_url, $version` |
| `pw_bui/header_right` | action | `array $page` — inject content in header right area |
