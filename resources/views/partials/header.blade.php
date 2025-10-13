<!-- Announcement Bar -->
<div class="bg-black text-white text-sm py-2">
    <div class="container mx-auto px-4 text-center">
        <span class="inline-flex items-center space-x-4">
            <span>📞 570-352-5501</span>
            <span class="mx-2">|</span>
            <span>📍 Appointment Only - Schedule Today</span>
        </span>
    </div>
</div>
<!-- Header Navigation -->
<header class="sticky top-0 z-50 bg-white shadow-md">
    <div class="container mx-auto px-4 relative">
        <nav class="flex items-center justify-between py-4">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="absolute -top-10 left-4 z-[60]">
                   <span class="sr-only">Piano Depot</span>
                   <img src="/piano_depot.png" alt="Piano Depot" class="h-32 w-auto">
                </a>
                <!-- Spacer for logo -->
                <div class="w-36"></div>
            </div>

            <!-- Main Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                <x-dropdown-menu-item label="About Us">
                    <a href="#" class="hover:underline">Something</a>
                </x-dropdown-menu-item>

                <x-dropdown-menu-item label="Pianos">
                    <a href="#" class="hover:underline">Something</a>
                </x-dropdown-menu-item>

                <x-dropdown-menu-item label="Services">
                    <a href="#" class="hover:underline">Something</a>
                </x-dropdown-menu-item>

                <x-dropdown-menu-item label="Resources">
                    <a href="#" class="hover:underline">Something</a>
                </x-dropdown-menu-item>

                <a href="#" class="text-black hover:text-[#725CA7]">Contact</a>

                <a href="/appointment" class="bg-[#CC2E23] text-white px-6 py-2 rounded-md hover:bg-[#E6352A] transition">
                    Schedule Appointment
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button class="lg:hidden" @click="showMobileMenu = true">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </nav>
    </div>
</header>
<div class="fixed backdrop-grayscale inset-0 backdrop-blur-xs w-full h-screen z-60" x-show="showMobileMenu">
    <nav class="absolute right-0 top-0 bg-black w-full max-w-md bottom-0 p-6 text-white" @click.away="showMobileMenu = false">
        <button @click="showMobileMenu = false" class="absolute top-0 right-0 mr-2 mt-2 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <x-mobile-dropdown-menu-item label="About Us" :first="true">
            <a href="#">Something</a>
        </x-mobile-dropdown-menu-item>

        <x-mobile-dropdown-menu-item label="Pianos">
            <a href="#">Something</a>
        </x-mobile-dropdown-menu-item>

        <x-mobile-dropdown-menu-item label="Services">
            <a href="#">Something</a>
        </x-mobile-dropdown-menu-item>

        <x-mobile-dropdown-menu-item label="Resources">
            <a href="#">Something</a>
        </x-mobile-dropdown-menu-item>

        <a href="#" class="w-full font-bold text-xl cursor-pointer">
            Contact
        </a>
    </nav>
</div>
