@props(['label', 'showChevron' => true, 'first' => false])

<div x-data="{showMenu: false}" @class(['mt-6' => $first])>
    <h3 class="flex w-full justify-between items-center font-bold text-xl cursor-pointer" @click="showMenu = !showMenu">
        {{ $label }}
        @if($showChevron)
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" x-show="!showMenu">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" x-show="showMenu">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
        @endif
    </h3>
    <div x-show="showMenu" class="pl-6">
        {{ $slot }}
    </div>
</div>
