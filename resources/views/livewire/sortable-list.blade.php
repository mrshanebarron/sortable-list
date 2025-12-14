<div
    x-data="{
        items: @entangle('items'),
        draggedIndex: null,
        dragOverIndex: null,
        handleDragStart(e, index) {
            this.draggedIndex = index;
            e.dataTransfer.effectAllowed = 'move';
        },
        handleDragOver(e, index) {
            e.preventDefault();
            this.dragOverIndex = index;
        },
        handleDrop(e, index) {
            e.preventDefault();
            if (this.draggedIndex !== null && this.draggedIndex !== index) {
                const newOrder = [...this.items];
                const [removed] = newOrder.splice(this.draggedIndex, 1);
                newOrder.splice(index, 0, removed);
                const ids = newOrder.map(item => item.id || item);
                $wire.reorder(ids);
            }
            this.draggedIndex = null;
            this.dragOverIndex = null;
        },
        handleDragEnd() {
            this.draggedIndex = null;
            this.dragOverIndex = null;
        }
    }"
    @class([
        'space-y-2' => $direction === 'vertical',
        'flex gap-2' => $direction === 'horizontal',
    ])
>
    @foreach($items as $index => $item)
        <div
            draggable="true"
            @dragstart="handleDragStart($event, {{ $index }})"
            @dragover="handleDragOver($event, {{ $index }})"
            @drop="handleDrop($event, {{ $index }})"
            @dragend="handleDragEnd()"
            :class="{ 'opacity-50': draggedIndex === {{ $index }}, 'border-t-2 border-blue-500': dragOverIndex === {{ $index }} && draggedIndex !== {{ $index }} }"
            class="flex items-center gap-3 p-3 bg-white border rounded-lg cursor-move hover:shadow-sm transition-all"
        >
            @if($handle)
                <span class="text-gray-400 cursor-grab">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                </span>
            @endif
            <span class="flex-1">{{ is_array($item) ? ($item['label'] ?? $item['title'] ?? '') : $item }}</span>
        </div>
    @endforeach
</div>
