# Sortable List

Drag and drop reorderable lists for Laravel applications. Supports vertical and horizontal directions, optional drag handles, and emits reorder events. Works with Livewire and Vue 3.

## Installation

```bash
composer require mrshanebarron/sortable-list
```

## Livewire Usage

### Basic Usage

```blade
@php
$items = [
    ['id' => 1, 'title' => 'First Item'],
    ['id' => 2, 'title' => 'Second Item'],
    ['id' => 3, 'title' => 'Third Item'],
];
@endphp

<livewire:sb-sortable-list :items="$items" />
```

### With Drag Handle

```blade
<livewire:sb-sortable-list :items="$items" :handle="true" />
```

### Horizontal Direction

```blade
<livewire:sb-sortable-list :items="$items" direction="horizontal" />
```

### With Wire Model

```blade
<livewire:sb-sortable-list wire:model="items" :handle="true" />
```

### Livewire Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `items` | array | `[]` | Array of items with `id` and `title` keys (modelable) |
| `handle` | boolean | `false` | Show drag handle instead of full-item drag |
| `direction` | string | `'vertical'` | Direction: `vertical` or `horizontal` |

### Item Structure

```php
$items = [
    ['id' => 1, 'title' => 'Homepage Banner', 'description' => 'Image'],
    ['id' => 2, 'title' => 'Featured Products', 'description' => 'Collection'],
    ['id' => 3, 'title' => 'Newsletter Signup', 'description' => 'Form'],
];
```

### Events

```blade
<livewire:sb-sortable-list
    :items="$items"
    @items-reordered="handleReorder"
/>
```

The `items-reordered` event includes the reordered items array.

## Vue 3 Usage

### Setup

```javascript
import { SbSortableList } from './vendor/sb-sortable-list';
app.component('SbSortableList', SbSortableList);
```

### Basic Usage

```vue
<template>
  <SbSortableList v-model="items" />
</template>

<script setup>
import { ref } from 'vue';

const items = ref([
  { id: 1, title: 'First' },
  { id: 2, title: 'Second' },
  { id: 3, title: 'Third' },
]);
</script>
```

### With Options

```vue
<template>
  <SbSortableList
    v-model="items"
    :handle="true"
    direction="vertical"
    @reordered="onReorder"
  />
</template>
```

### Vue Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `modelValue` | Array | `[]` | v-model binding for items |
| `handle` | Boolean | `false` | Show drag handle |
| `direction` | String | `'vertical'` | Layout direction |

### Events

| Event | Payload | Description |
|-------|---------|-------------|
| `update:modelValue` | array | Emitted when items are reordered |
| `reordered` | array | Emitted with new order after drag ends |

## Handling Reorder in Backend

```php
// In your Livewire component
public array $items = [];

#[On('items-reordered')]
public function handleReorder(array $items): void
{
    foreach ($items as $index => $item) {
        Model::where('id', $item['id'])->update(['order' => $index]);
    }
}
```

## Styling

The sortable list includes:
- Smooth drag animations
- Visual feedback during drag
- Optional grab cursor on handles
- Border and shadow effects

## Requirements

- PHP 8.1+
- Laravel 10, 11, or 12
- Tailwind CSS 3.x
- Alpine.js (for drag functionality)

## License

MIT License
