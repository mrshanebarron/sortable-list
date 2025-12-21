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
    style="{{ $this->direction === 'horizontal' ? 'display: flex; gap: 8px;' : 'display: flex; flex-direction: column; gap: 8px;' }}"
>
    @foreach($this->items as $index => $item)
        <div
            draggable="true"
            @dragstart="handleDragStart($event, {{ $index }})"
            @dragover="handleDragOver($event, {{ $index }})"
            @drop="handleDrop($event, {{ $index }})"
            @dragend="handleDragEnd()"
            :style="draggedIndex === {{ $index }} ? 'opacity: 0.5;' : (dragOverIndex === {{ $index }} && draggedIndex !== {{ $index }} ? 'border-top: 2px solid #3b82f6;' : '')"
            style="display: flex; align-items: center; gap: 12px; padding: 12px; background: white; border: 1px solid #e5e7eb; border-radius: 8px; cursor: move; transition: box-shadow 0.15s;"
            onmouseover="this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)'"
            onmouseout="this.style.boxShadow='none'"
        >
            @if($this->handle)
                <span style="color: #9ca3af; cursor: grab;">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                </span>
            @endif
            <span style="flex: 1;">{{ is_array($item) ? ($item['label'] ?? $item['title'] ?? '') : $item }}</span>
        </div>
    @endforeach
</div>
