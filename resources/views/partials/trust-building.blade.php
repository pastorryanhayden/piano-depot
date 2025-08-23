<!-- Trust Building Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div>
                <h2 class="text-3xl md:text-4xl font-bold mb-8 font-serif">WHY PIANO DEPOT?</h2>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-lg">Family Owned Since 1982</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-lg">Authorized Yamaha Dealer</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-lg">40+ Years Musical Experience</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-lg">Appointment-Only Personalized Service</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-lg">Complete Piano Services</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-lg">Honest, No-Pressure Guidance</span>
                    </li>
                </ul>
                <div class="space-x-4">
                    <a href="/our-story" class="inline-block bg-gray-800 text-white px-6 py-3 rounded-md hover:bg-gray-900 transition">
                        Read Our Story
                    </a>
                    <button onclick="openVideoModal()" class="inline-block border-2 border-gray-800 text-gray-800 px-6 py-3 rounded-md hover:bg-gray-800 hover:text-white transition">
                        Meet Frank
                    </button>
                </div>
            </div>

            <!-- Right Content - Frank's Photo -->
            <div class="bg-gray-100 rounded-lg p-8 text-center">
                <div class="relative inline-block cursor-pointer group" onclick="openVideoModal()">
                    <img src="{{ file_exists(public_path('images/frank-playing-piano.jpg')) ? asset('images/frank-playing-piano.jpg') : asset('images/frank-playing-piano.svg') }}" alt="Frank Bissol" class="w-48 h-48 rounded-full mx-auto mb-6 object-cover">
                    <!-- Play button overlay -->
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="bg-white bg-opacity-90 rounded-full p-4 shadow-lg transform group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <blockquote class="text-xl italic mb-4">
                    "Every piano has a story.<br>
                    Let me help you write yours."
                </blockquote>
                <p class="font-semibold">- Frank Bissol, Owner</p>
            </div>
        </div>
    </div>
</section>