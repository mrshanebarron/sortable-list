<template>
  <div class="space-y-2">
    <div
      v-for="(item, index) in items"
      :key="item.id || index"
      draggable="true"
      @dragstart="handleDragStart($event, index)"
      @dragover.prevent="handleDragOver($event, index)"
      @dragend="handleDragEnd"
      @drop="handleDrop($event, index)"
      :class="['p-3 bg-white border border-gray-200 rounded-lg cursor-move transition-all', draggedIndex === index && 'opacity-50', dragOverIndex === index && 'border-blue-500 border-2']"
    >
      <div class="flex items-center gap-3">
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
        </svg>
        <slot name="item" :item="item" :index="index">
          <span>{{ item.label || item.title || item.name || item }}</span>
        </slot>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  name: 'SbSortableList',
  props: {
    items: { type: Array, default: () => [] }
  },
  emits: ['update:items', 'reorder'],
  setup(props, { emit }) {
    const draggedIndex = ref(null);
    const dragOverIndex = ref(null);

    const handleDragStart = (e, index) => {
      draggedIndex.value = index;
      e.dataTransfer.effectAllowed = 'move';
    };

    const handleDragOver = (e, index) => {
      if (draggedIndex.value === null) return;
      dragOverIndex.value = index;
    };

    const handleDrop = (e, toIndex) => {
      if (draggedIndex.value === null || draggedIndex.value === toIndex) return;

      const newItems = [...props.items];
      const [removed] = newItems.splice(draggedIndex.value, 1);
      newItems.splice(toIndex, 0, removed);

      emit('update:items', newItems);
      emit('reorder', { from: draggedIndex.value, to: toIndex, items: newItems });
    };

    const handleDragEnd = () => {
      draggedIndex.value = null;
      dragOverIndex.value = null;
    };

    return { draggedIndex, dragOverIndex, handleDragStart, handleDragOver, handleDrop, handleDragEnd };
  }
};
</script>
