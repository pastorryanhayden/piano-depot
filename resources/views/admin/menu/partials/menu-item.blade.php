<li class="menu-item" data-id="{{ $item->id }}">
    <div class="card bg-base-200 hover:bg-base-300 transition-colors">
        <div class="card-body p-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="drag-handle cursor-move">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-semibold">{{ $item->title }}</span>
                            @if($item->type === 'page')
                                <span class="badge badge-primary badge-sm">Page</span>
                            @elseif($item->type === 'external')
                                <span class="badge badge-info badge-sm">External</span>
                            @else
                                <span class="badge badge-secondary badge-sm">Custom</span>
                            @endif
                            @if(!$item->is_active)
                                <span class="badge badge-ghost badge-sm">Inactive</span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            @if($item->type === 'page' && $item->page)
                                <span>→ {{ $item->page->title }}</span>
                            @else
                                <span>{{ $item->url }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <a href="{{ route('admin.menu.edit', $item) }}" class="btn btn-sm btn-ghost" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </a>
                    <form action="{{ route('admin.menu.toggle', $item) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-ghost" title="{{ $item->is_active ? 'Deactivate' : 'Activate' }}">
                            @if($item->is_active)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            @endif
                        </button>
                    </form>
                    <form action="{{ route('admin.menu.destroy', $item) }}" method="POST" class="inline" 
                          onsubmit="return confirm('Are you sure? Child items will be moved up one level.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-ghost text-error" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($item->children->count() > 0)
        <ul class="nested-menu space-y-2 mt-2">
            @foreach($item->children as $child)
                @include('admin.menu.partials.menu-item', ['item' => $child])
            @endforeach
        </ul>
    @endif
</li>