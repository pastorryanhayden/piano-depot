import './bootstrap';

import Alpine from 'alpinejs';
import { Application } from '@hotwired/stimulus';
import SortableController from './controllers/sortable_controller';
import NestedSortableController from './controllers/nested_sortable_controller';

window.Alpine = Alpine;
Alpine.start();

window.Stimulus = Application.start();
window.Stimulus.register('sortable', SortableController);
window.Stimulus.register('nested-sortable', NestedSortableController);
