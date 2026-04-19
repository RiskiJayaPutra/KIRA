<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- 1. SEED BLINDBOXES ---
        $blindboxes = [
            [
                'name' => 'Cyberpunk RED: Night City Edgerunners Series 1',
                'description' => 'Koleksi blindbox brutal dari jalanan Night City. Berisi 1 dari 6 karakter ikonik dengan detail krom dan senjata.',
                'image_url' => 'https://placehold.co/800x1000/ffd803/272343?text=CYBERPUNK+RED',
            ],
            [
                'name' => 'Neon Genesis: Angels Awakening',
                'description' => 'Rasakan kengerian kosmik. Blindbox seri terbatas menampilkan wujud malaikat dalam bentuk geometris brutalist.',
                'image_url' => 'https://placehold.co/800x1000/bae8e8/272343?text=NEON+GENESIS',
            ],
            [
                'name' => 'Tokyo Ghoul: Kagune Unleashed',
                'description' => 'Detail mengerikan dari organ pemangsa. Setiap box memiliki peluang mendapatkan centipede secret variant.',
                'image_url' => 'https://placehold.co/800x1000/2d334a/fffffe?text=TOKYO+GHOUL',
            ],
            [
                'name' => 'Jujutsu Kaisen: Cursed Spirits',
                'description' => 'Kutukan tingkat spesial kini bisa Anda pajang di rak. Termasuk Ryomen Sukuna variant.',
                'image_url' => 'https://placehold.co/800x1000/fffffe/272343?text=JUJUTSU+KAISEN',
            ],
        ];

        foreach ($blindboxes as $bb) {
            $product = Product::create([
                'name' => $bb['name'],
                'slug' => Str::slug($bb['name']),
                'is_blindbox' => true,
                'description' => $bb['description'],
                'image_url' => $bb['image_url'],
                'release_date' => now()->subDays(rand(1, 30)),
            ]);

            // Buat varian rahasia (Secret) dan reguler
            $product->variants()->create([
                'variant_name' => 'Regular Drop',
                'stock' => rand(50, 200),
                'price' => rand(250000, 350000),
                'drop_rate' => 95.0, // 95%
                'image_url' => 'https://placehold.co/400x400/eeeeee/272343?text=REGULAR',
            ]);

            $product->variants()->create([
                'variant_name' => 'SECRET: Chase Variant',
                'stock' => rand(5, 10),
                'price' => rand(1500000, 2500000), // Harga estimasi reseller
                'drop_rate' => 5.0, // 5% chance
                'image_url' => 'https://placehold.co/400x400/272343/ffd803?text=SECRET',
            ]);
        }

        // --- 2. SEED PREMIUM FIGURES (Non-Blindbox) ---
        $figures = [
            [
                'name' => '1/4 Scale Nier Automata: 2B (Deluxe)',
                'description' => 'Patung resin premium skala 1/4. Termasuk base diorama brutalist dan pedang Virtuous Contract yang bisa menyala.',
                'image_url' => 'https://placehold.co/800x1000/272343/fffffe?text=2B+1/4+SCALE',
                'price' => 12500000,
            ],
            [
                'name' => 'Metal Build Evangelion Unit-01 (Test Type)',
                'description' => 'Die-cast metal figure dengan artikulasi ekstrem. Dirancang khusus oleh Ikuto Yamashita.',
                'image_url' => 'https://placehold.co/800x1000/ffd803/272343?text=EVA-01+METAL',
                'price' => 6800000,
            ],
            [
                'name' => 'Berserk: Guts (Berserker Armor) 1/6 Scale',
                'description' => 'Detail berdarah dan zirah baja legendaris. Dilengkapi dengan pedang raksasa Dragon Slayer.',
                'image_url' => 'https://placehold.co/800x1000/2d334a/fffffe?text=GUTS+BERSERKER',
                'price' => 8900000,
            ],
            [
                'name' => 'Godzilla Minus One (Monochrome Edition)',
                'description' => 'Edisi terbatas hitam putih dari sang raja monster. Dicetak menggunakan 3D scan dari model asli film.',
                'image_url' => 'https://placehold.co/800x1000/fffffe/272343?text=GODZILLA+-1.0',
                'price' => 4500000,
            ],
        ];

        foreach ($figures as $fig) {
            $product = Product::create([
                'name' => $fig['name'],
                'slug' => Str::slug($fig['name']),
                'is_blindbox' => false,
                'description' => $fig['description'],
                'image_url' => $fig['image_url'],
                'release_date' => now()->subDays(rand(1, 30)),
            ]);

            // Figure biasanya tidak punya varian rahasia
            $product->variants()->create([
                'variant_name' => 'Standard Edition',
                'stock' => rand(2, 15),
                'price' => $fig['price'],
                'drop_rate' => 100.0,
                'image_url' => $fig['image_url'],
            ]);
        }
    }
}
