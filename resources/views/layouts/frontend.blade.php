<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">


            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>

        <!-- Video Modal -->
        <div id="videoModal" class="fixed inset-0 z-50 hidden">
            <!-- Semi-transparent background overlay -->
            <div class="fixed inset-0 bg-black/80" onclick="closeVideoModal()"></div>
            
            <!-- Modal content -->
            <div class="fixed inset-0 flex items-center justify-center p-4" onclick="closeVideoModal()">
                <div class="relative w-full max-w-4xl bg-black rounded-lg shadow-xl" onclick="event.stopPropagation()">
                    <div class="relative" style="padding-bottom: 56.25%;">
                        <iframe id="youtubeVideo" 
                                class="absolute top-0 left-0 w-full h-full rounded-lg"
                                src=""
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                        </iframe>
                    </div>
                    <button onclick="closeVideoModal()" class="absolute -top-2 -right-2 text-white hover:text-gray-300 bg-black bg-opacity-70 rounded-full p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <script>
            function openVideoModal() {
                const modal = document.getElementById('videoModal');
                const iframe = document.getElementById('youtubeVideo');
                
                // Set the YouTube video URL with autoplay
                iframe.src = 'https://www.youtube.com/embed/uV_Mna9EEY0?autoplay=1';
                
                // Show the modal
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeVideoModal() {
                const modal = document.getElementById('videoModal');
                const iframe = document.getElementById('youtubeVideo');
                
                // Clear the iframe src to stop the video
                iframe.src = '';
                
                // Hide the modal
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            // Close modal on escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeVideoModal();
                }
            });
        </script>
    </body>
</html>
