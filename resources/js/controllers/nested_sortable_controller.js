import { Controller } from '@hotwired/stimulus';
import Sortable from 'sortablejs';

export default class extends Controller {
    static targets = ['list'];
    static values = { 
        url: String,
        location: String
    };

    connect() {
        this.initNestedSortable(this.listTarget);
    }

    initNestedSortable(element) {
        const sortable = Sortable.create(element, {
            group: `menu-${this.locationValue}`,
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            ghostClass: 'opacity-50',
            dragClass: 'cursor-move',
            handle: '.drag-handle',
            onEnd: this.handleSort.bind(this)
        });

        element.querySelectorAll('.nested-menu').forEach(nestedList => {
            if (!nestedList.hasAttribute('data-sortable-initialized')) {
                this.initNestedSortable(nestedList);
                nestedList.setAttribute('data-sortable-initialized', 'true');
            }
        });

        element.sortableInstance = sortable;
    }

    async handleSort(event) {
        const items = this.collectItems(this.listTarget);
        
        if (this.hasUrlValue) {
            try {
                const response = await fetch(this.urlValue, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ items: items })
                });

                if (!response.ok) {
                    throw new Error('Failed to update menu order');
                }

                const result = await response.json();
                
                if (result.success) {
                    this.showNotification('Menu order updated successfully', 'success');
                }
            } catch (error) {
                console.error('Sort error:', error);
                this.showNotification('Failed to update menu order', 'error');
                window.location.reload();
            }
        }
    }

    collectItems(element, parentId = null) {
        const items = [];
        const children = Array.from(element.children).filter(child => 
            child.classList.contains('menu-item')
        );

        children.forEach((item, index) => {
            const itemData = {
                id: parseInt(item.dataset.id),
                parent_id: parentId,
                order: index
            };

            items.push(itemData);

            const nestedMenu = item.querySelector('.nested-menu');
            if (nestedMenu) {
                const nestedItems = this.collectItems(nestedMenu, itemData.id);
                items.push(...nestedItems);
            }
        });

        return items;
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} fixed top-4 right-4 z-50 max-w-sm shadow-lg transition-all duration-500`;
        notification.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'}" />
            </svg>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('opacity-0');
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }

    disconnect() {
        this.destroySortable(this.listTarget);
    }

    destroySortable(element) {
        if (element.sortableInstance) {
            element.sortableInstance.destroy();
        }

        element.querySelectorAll('.nested-menu').forEach(nestedList => {
            this.destroySortable(nestedList);
        });
    }
}