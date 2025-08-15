<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PianoCategory;
use Illuminate\Support\Str;

class PianoCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Disklavier Pianos',
                'slug' => 'disklavier-pianos',
                'description' => 'Yamaha Disklavier pianos combine acoustic excellence with cutting-edge technology.',
                'content' => '<h2>Experience the Future of Piano Performance</h2><p>Disklavier pianos represent the pinnacle of musical innovation, seamlessly blending the rich, authentic sound of acoustic pianos with advanced digital capabilities. These remarkable instruments allow you to record and playback performances with stunning accuracy, access a vast library of music, and even enjoy live performances streamed directly to your piano.</p>',
                'show_prices' => false,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Acoustic Grand Pianos',
                'slug' => 'acoustic-grand-pianos',
                'description' => 'Premium grand pianos delivering unparalleled sound and touch.',
                'content' => '<h2>The Ultimate Expression in Piano Craftsmanship</h2><p>Our collection of acoustic grand pianos represents over a century of craftsmanship and innovation. From compact baby grands perfect for intimate spaces to concert grands that fill the largest venues with magnificent sound, each instrument is meticulously crafted to deliver exceptional tone, responsive touch, and lasting beauty.</p>',
                'show_prices' => false,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Silent & Trans Acoustic Pianos',
                'slug' => 'silent-trans-acoustic-pianos',
                'description' => 'Revolutionary pianos that offer silent practice and enhanced acoustic capabilities.',
                'content' => '<h2>Practice Anytime, Perform Anywhere</h2><p>Silent and TransAcoustic pianos offer the best of both worlds. Practice silently with headphones when needed, or enjoy the full acoustic experience when you can. TransAcoustic technology goes even further, allowing digital sounds to resonate through the piano\'s soundboard, creating an immersive playing experience unlike any other.</p>',
                'show_prices' => false,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Acoustic Upright Pianos',
                'slug' => 'acoustic-upright-pianos',
                'description' => 'Space-efficient upright pianos with exceptional sound quality.',
                'content' => '<h2>Perfect Pianos for Every Home</h2><p>Our acoustic upright pianos deliver remarkable sound in a space-conscious design. From studio uprights ideal for students to professional uprights that rival many grands in tone and touch, these instruments prove that you don\'t need a large space to enjoy authentic piano performance.</p>',
                'show_prices' => false,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Clavinova and Hybrid Pianos',
                'slug' => 'clavinova-hybrid-pianos',
                'description' => 'Digital and hybrid pianos combining tradition with innovation.',
                'content' => '<h2>Where Digital Innovation Meets Acoustic Tradition</h2><p>Clavinova and hybrid pianos represent the cutting edge of digital piano technology. With authentic piano samples, weighted keys that replicate grand piano action, and features like recording, lesson functions, and hundreds of instrument voices, these pianos offer incredible versatility for modern musicians.</p>',
                'show_prices' => false,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Portable Digital Pianos',
                'slug' => 'portable-digital-pianos',
                'description' => 'Lightweight, versatile digital pianos for musicians on the go.',
                'content' => '<h2>Take Your Music Anywhere</h2><p>Our portable digital pianos offer professional features in a lightweight, transportable package. Perfect for gigging musicians, students who need to move between locations, or anyone who values flexibility without compromising on sound quality or playing experience.</p>',
                'show_prices' => false,
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Used & Refurbished Pianos',
                'slug' => 'used-refurbished-pianos',
                'description' => 'Quality pre-owned and professionally refurbished pianos at exceptional values.',
                'content' => '<h2>Exceptional Pianos, Exceptional Value</h2><p>Our carefully selected used and refurbished pianos offer an affordable entry into piano ownership without compromising on quality. Each instrument is thoroughly inspected, serviced, and guaranteed to provide years of musical enjoyment. From vintage classics to recent models, find the perfect piano to match your budget and musical aspirations.</p>',
                'show_prices' => true,
                'sort_order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            PianoCategory::create($category);
        }
    }
}