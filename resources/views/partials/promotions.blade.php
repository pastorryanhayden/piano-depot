{{--
    Promotions Section Component
    - Displays special offers/promotions when active
    - Features a "SPECIAL OFFER" flag that overlaps with hero section
    - Includes promotional content: image, copy, CTA button
    - Hides entire section when no promotion is active
    - Responsive design for all screen sizes
--}}

@php
    // Configuration for the current promotion
    $promotionActive = true; // Set to false to hide the entire section
    $promotion = [
        'title' => 'SPRING SALES EVENT',
        'brand' => 'Yamaha',
        'image' => '/images/yamaha-spring-promotion.jpg',
        'offer' => '0% APR 24 months',
        'description' => 'Limited Time Financing Available',
        'cta_text' => 'LEARN MORE',
        'cta_url' => '/promotions/spring-sales',
        'disclaimer' => '* Subject to credit approval. 0% APR for 24 months on select Yamaha acoustic pianos. Offer expires May 31, 2024.'
    ];
@endphp

@if($promotionActive)
<!-- Promotions Section -->
<section class="relative">
    <!-- Special Offer Flag/Badge - Overlaps with Hero Section -->
    <div class="relative -mt-8 z-20 flex justify-center">
        <div class="bg-[#CC2E23] text-white px-8 py-3 transform -rotate-1 shadow-lg">
            <div class="relative">
                <!-- Flag corners -->
                <div class="absolute -left-2 top-0 w-0 h-0 border-t-[24px] border-b-[24px] border-r-[8px] border-t-transparent border-b-transparent border-r-[#E6352A]"></div>
                <div class="absolute -right-2 top-0 w-0 h-0 border-t-[24px] border-b-[24px] border-l-[8px] border-t-transparent border-b-transparent border-l-[#E6352A]"></div>
                <span class="text-lg font-bold tracking-wide">SPECIAL OFFER</span>
            </div>
        </div>
    </div>

    <!-- Promotional Banner -->
    <div class="bg-white text-black py-12 px-6 md:px-8 lg:px-12">
        <div class="w-full max-w-3xl mx-auto">
            <a href="{{$promotion['cta_url']}}" class="w-full">
                <img src="/promotion.jpg" alt="">

            </a>

            <!-- Disclaimer -->
            <div class="mt-8 pt-6 border-t border-black">
                <p class="text-xs text-black/70 text-center max-w-4xl mx-auto leading-relaxed">
                    {{ $promotion['disclaimer'] }}
                </p>
            </div>
        </div>
    </div>
</section>
@endif
