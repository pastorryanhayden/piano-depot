import { Controller } from '@hotwired/stimulus';
import Sortable from 'sortablejs';

export default class extends Controller {
    static targets = ['list'];
    static values = { 
        url: String,
        handle: String
    };

    connect() {
        this.initSortable();
    }

    initSortable() {
        const options = {
            animation: 150,
            ghostClass: 'opacity-50',
            dragClass: 'cursor-move',
            onEnd: this.handleSort.bind(this)
        };

        if (this.hasHandleValue && this.handleValue) {
            options.handle = this.handleValue;
        }

        this.sortable = Sortable.create(this.listTarget, options);
    }

    async handleSort(event) {
        const items = Array.from(this.listTarget.children);
        const sortData = items.map((item, index) => ({
            id: item.dataset.id,
            order: index
        }));

        if (this.hasUrlValue) {
            try {
                const response = await fetch(this.urlValue, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ pages: sortData })
                });

                if (!response.ok) {
                    throw new Error('Failed to update order');
                }

                const result = await response.json();
                
                if (result.success) {
                    this.showNotification('Order updated successfully', 'success');
                }
            } catch (error) {
                console.error('Sort error:', error);
                this.showNotification('Failed to update order', 'error');
                this.sortable.sort(this.sortable.toArray());
            }
        }
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} fixed top-4 right-4 z-50 max-w-sm shadow-lg`;
        notification.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'}" />
            </svg>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('opacity-0', 'transition-opacity', 'duration-500');
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }

    disconnect() {
        if (this.sortable) {
            this.sortable.destroy();
        }
    }
}