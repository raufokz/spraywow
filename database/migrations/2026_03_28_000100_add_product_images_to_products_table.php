<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->json('product_images')->nullable()->after('image_url');
        });

        DB::table('products')
            ->orderBy('id')
            ->get(['id', 'image_url', 'gallery'])
            ->each(function (object $product): void {
                $images = collect([$product->image_url])
                    ->merge(json_decode($product->gallery ?: '[]', true) ?: [])
                    ->filter()
                    ->values()
                    ->all();

                DB::table('products')
                    ->where('id', $product->id)
                    ->update([
                        'product_images' => json_encode($images, JSON_UNESCAPED_SLASHES),
                    ]);
            });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->dropColumn('product_images');
        });
    }
};
