<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->firstOrCreate(['email' => 'admin@spraywow.com'], [
            'name' => 'SprayWow Admin',
            'email' => 'admin@spraywow.com',
            'phone' => '555-0100',
            'is_admin' => true,
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $customers = User::factory(6)->create();

        $products = $this->productsFromCsv();

        $products->each(function (array $row, int $index): void {
            $categoryName = $this->resolveCategoryName($row);
            $category = $this->categoryFor($categoryName);
            $images = $this->parseImages($row['Images'] ?? '');
            $image = $images[0] ?? $this->svgPlaceholder($row['Name'], $category->accent_color);

            Product::query()->updateOrCreate(
                ['slug' => Str::slug($row['Name'])],
                [
                    'category_id' => $category->id,
                    'name' => $row['Name'],
                    'slug' => Str::slug($row['Name']),
                    'sku' => $row['SKU'] ?: 'SW-'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                    'tagline' => Str::limit(strip_tags((string) ($row['Short description'] ?: $row['Description'])), 90),
                    'short_description' => Str::limit(strip_tags((string) ($row['Short description'] ?: $row['Description'])), 140),
                    'description' => trim(strip_tags((string) ($row['Description'] ?: $row['Short description']))),
                    'price' => (float) ($row['Regular price'] ?: 0),
                    'compare_price' => $row['Sale price'] ? (float) $row['Regular price'] : null,
                    'image_url' => $image,
                    'gallery' => $images,
                    'benefits' => $this->benefitsFor($row['Name']),
                    'stock' => max(1, (int) ($row['Stock'] ?: 25)),
                    'is_featured' => $index < 8,
                    'is_active' => (bool) ($row['Published'] ?? true),
                    'meta_title' => "{$row['Name']} | SprayWow",
                    'meta_description' => Str::limit(strip_tags((string) ($row['Short description'] ?: $row['Description'])), 150),
                ]
            );
        });

        collect([
            ['code' => 'WOW10', 'description' => '10% off your first SprayWow order', 'type' => 'percent', 'value' => 10, 'minimum_amount' => 30, 'used_count' => 0, 'is_active' => true],
            ['code' => 'FRESH15', 'description' => '$15 off orders above $90', 'type' => 'fixed', 'value' => 15, 'minimum_amount' => 90, 'used_count' => 0, 'is_active' => true],
        ])->each(fn (array $coupon) => Coupon::query()->updateOrCreate(['code' => $coupon['code']], $coupon));

        foreach (Product::query()->take(3)->get() as $index => $product) {
            Review::query()->updateOrCreate(
                ['user_id' => $customers[$index]->id, 'product_id' => $product->id],
                [
                    'rating' => 5 - ($index % 2),
                    'title' => ['Works fast', 'Looks cleaner instantly', 'Fresh finish'][$index],
                    'comment' => 'The trigger is smooth, the finish feels premium, and the cleaning result is noticeably better than typical store sprays.',
                ]
            );
        }

        $blogCategories = collect([
            ['name' => 'Cleaning Tips', 'description' => 'Actionable cleaning routines, checklists, and seasonal care guides.'],
            ['name' => 'Product Guides', 'description' => 'Deep dives into SprayWow formulas, surfaces, and best-use scenarios.'],
            ['name' => 'Home Care', 'description' => 'Fresh, practical ideas for keeping rooms, fabrics, and surfaces spotless.'],
        ])->mapWithKeys(function (array $category) {
            $model = BlogCategory::query()->updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                ['name' => $category['name'], 'slug' => Str::slug($category['name']), 'description' => $category['description']]
            );

            return [$category['name'] => $model];
        });

        $blogTags = collect(['cleaning sprays', 'home cleaning tips', 'kitchen care', 'glass cleaning', 'shoe cleaner', 'fabric refresh'])
            ->mapWithKeys(function (string $tag) {
                $model = BlogTag::query()->updateOrCreate(
                    ['slug' => Str::slug($tag)],
                    ['name' => Str::title($tag), 'slug' => Str::slug($tag)]
                );

                return [$tag => $model];
            });

        $posts = [
            [
                'category' => 'Cleaning Tips',
                'title' => '5 Smart Ways to Keep Your Kitchen Cleaner for Longer',
                'excerpt' => 'Simple kitchen habits, targeted spray use, and a better wipe-down routine can keep surfaces fresher between deep cleans.',
                'content' => '<h2>Start with the high-touch zones</h2><p>Focus on handles, counters, backsplashes, and appliance fronts first. These spots pick up fingerprints, grease, and quick spills faster than anywhere else.</p><h2>Use the right spray for the job</h2><p>A dedicated kitchen cleaner saves time and keeps residue low. SprayWow kitchen formulas work best when applied lightly and wiped with a dry microfiber cloth.</p><h3>Build a two-minute reset habit</h3><p>End each day with a quick counter reset, sink spray, and stovetop wipe. Small consistency creates a visibly cleaner kitchen without a big time investment.</p>',
                'keywords' => 'kitchen cleaning tips, home cleaning spray, kitchen cleaner',
                'tags' => ['cleaning sprays', 'home cleaning tips', 'kitchen care'],
            ],
            [
                'category' => 'Product Guides',
                'title' => 'How to Choose the Best Cleaning Spray for Glass, Fabric, and Shoes',
                'excerpt' => 'Different surfaces need different spray behavior. Here is how to match the right SprayWow formula to the finish you want.',
                'content' => '<h2>Glass and mirrors need clarity</h2><p>Choose a glass-focused cleaner when you want a streak-free finish on windows, mirrors, and shiny surfaces.</p><h2>Fabrics need a lighter touch</h2><p>Fabric refresh sprays are designed to lift odors and leave upholstery feeling fresher without over-wetting the material.</p><h2>Shoes need targeted care</h2><p>Shoe cleaners work best with spot treatment, a soft brush, and quick wipe-downs. They are ideal for regular maintenance and visible stain reduction.</p>',
                'keywords' => 'best cleaning spray, glass cleaner, fabric spray, shoe cleaner',
                'tags' => ['glass cleaning', 'fabric refresh', 'shoe cleaner'],
            ],
            [
                'category' => 'Home Care',
                'title' => 'A Fresh-Feeling Weekend Home Reset with SprayWow',
                'excerpt' => 'Use a room-by-room cleaning flow to create a calmer home in under an hour, without making the process feel heavy or complicated.',
                'content' => '<h2>Begin with airflow and surfaces</h2><p>Open windows where possible, then wipe the most visible surfaces first to create instant momentum.</p><h2>Move room by room</h2><p>Kitchen, bathroom, living room, and entryway is a practical order. It helps you move from heavy-use areas to comfort zones without backtracking.</p><h2>Finish with fabrics and glass</h2><p>A quick fabric refresh and mirror clean gives the whole home a polished final look.</p>',
                'keywords' => 'weekend cleaning routine, home reset, cleaning spray guide',
                'tags' => ['cleaning sprays', 'home cleaning tips', 'fabric refresh'],
            ],
        ];

        foreach ($posts as $index => $post) {
            $record = BlogPost::query()->updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    'blog_category_id' => $blogCategories[$post['category']]->id,
                    'title' => $post['title'],
                    'slug' => Str::slug($post['title']),
                    'author_name' => 'SprayWow Editorial Team',
                    'featured_image' => Product::query()->skip($index)->value('image_url'),
                    'excerpt' => $post['excerpt'],
                    'content' => $post['content'],
                    'meta_title' => $post['title'].' | SprayWow Blog',
                    'meta_description' => Str::limit($post['excerpt'], 150),
                    'meta_keywords' => $post['keywords'],
                    'is_published' => true,
                    'published_at' => now()->subDays(10 - ($index * 3)),
                ]
            );

            $record->tags()->sync(
                collect($post['tags'])->map(fn (string $tag) => $blogTags[$tag]->id)->all()
            );
        }
    }

    protected function productsFromCsv(): Collection
    {
        $path = storage_path('app/imports/products.csv');

        if (! is_file($path)) {
            return collect();
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $headers = str_getcsv(array_shift($lines));

        return collect($lines)
            ->map(fn (string $line) => array_combine($headers, str_getcsv($line)))
            ->filter(fn (array $row) => ($row['Type'] ?? null) === 'simple' && ($row['Published'] ?? '0') === '1')
            ->values();
    }

    protected function resolveCategoryName(array $row): string
    {
        $category = trim((string) ($row['Categories'] ?? ''));
        $name = Str::lower($row['Name']);

        return match (true) {
            str_contains($name, 'shoe') => 'Shoe Care',
            str_contains($name, 'window') || str_contains($name, 'glass') => 'Glass & Surface',
            str_contains($name, 'rust') => 'Heavy Duty',
            str_contains($name, 'fabric') || str_contains($name, 'linen') => 'Fabric & Linen',
            str_contains($name, 'pet') => 'Pet Care',
            str_contains($name, 'hair') || str_contains($name, 'dandruff') => 'Personal Care',
            str_contains($name, 'roach') || str_contains($name, 'mosquito') || str_contains($name, 'bedbug') || str_contains($name, 'lizard') || str_contains($name, 'termite') => 'Pest Control',
            $category !== '' && $category !== 'Cleaning' && $category !== 'spray' => Str::title($category),
            default => 'Home Cleaning',
        };
    }

    protected function categoryFor(string $name): Category
    {
        $palette = [
            'Home Cleaning' => ['#1fb6ff', 'Everyday sparkle for every room.'],
            'Shoe Care' => ['#38bdf8', 'Keep every pair fresh and bright.'],
            'Glass & Surface' => ['#22d3ee', 'Crystal-clear shine without residue.'],
            'Heavy Duty' => ['#fbbf24', 'Serious power for stubborn messes.'],
            'Fabric & Linen' => ['#60a5fa', 'Soft surfaces, crisp scent.'],
            'Pest Control' => ['#0ea5e9', 'Protection with fast action.'],
            'Pet Care' => ['#67e8f9', 'Fresh coats and happy companions.'],
            'Personal Care' => ['#fde047', 'Daily care with a cleaner finish.'],
        ];

        [$accent, $copy] = $palette[$name] ?? ['#38bdf8', 'Premium spray care, everywhere.'];

        return Category::query()->updateOrCreate(
            ['slug' => Str::slug($name)],
            [
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "{$name} products curated from the SprayWow product range.",
                'accent_color' => $accent,
                'hero_copy' => $copy,
            ]
        );
    }

    protected function parseImages(string $raw): array
    {
        return collect(explode(',', $raw))
            ->map(fn (string $image) => trim($image))
            ->filter()
            ->values()
            ->all();
    }

    protected function benefitsFor(string $name): array
    {
        $name = Str::lower($name);

        return match (true) {
            str_contains($name, 'shoe') => ['Fast stain lift', 'Safe on daily footwear', 'Brightens without residue', 'Easy 500ml trigger bottle'],
            str_contains($name, 'window') => ['Streak-free glass finish', 'Quick-drying formula', 'Cuts smudges fast', 'Works on mirrors and panes'],
            str_contains($name, 'rust') => ['Heavy-duty breakdown', 'Precise spray application', 'Suitable for metal surfaces', 'Restores a cleaner look'],
            str_contains($name, 'fabric') || str_contains($name, 'linen') => ['Long-lasting freshness', 'Residue-free mist', 'Ideal for soft furnishings', 'Easy room-wide refresh'],
            default => ['Fast-acting formula', 'Fresh SprayWow scent', 'Easy everyday use', 'Controlled 500ml spray'],
        };
    }

    protected function svgPlaceholder(string $name, string $accent): string
    {
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 600">
  <defs><linearGradient id="g" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#ffffff"/><stop offset="100%" stop-color="{$accent}"/></linearGradient></defs>
  <rect width="600" height="600" rx="48" fill="url(#g)"/>
  <rect x="180" y="120" width="170" height="340" rx="34" fill="#e0f2fe"/>
  <rect x="225" y="70" width="82" height="78" rx="18" fill="#082f49"/>
  <text x="300" y="235" font-size="28" fill="#082f49" text-anchor="middle" font-family="Arial, sans-serif">SprayWow</text>
  <text x="300" y="280" font-size="24" fill="#eab308" text-anchor="middle" font-family="Arial, sans-serif">{$name}</text>
</svg>
SVG;

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }
}
