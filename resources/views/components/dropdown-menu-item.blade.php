@props(['label', 'showChevron' => true])

<div class="relative group" x-data="{showMenu: false}">
    <button class="flex items-center space-x-1 text-black hover:text-[#725CA7]" @click="showMenu = true">
        <span>{{ $label }}</span>
        @if($showChevron)
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        @endif
    </button>
    <div class="absolute top-0 bg-white shadow-md mt-12 py-4 px-4 -ml-4" x-show="showMenu" @click.away="showMenu = false">
        {{ $slot }}
    </div>
</div>
