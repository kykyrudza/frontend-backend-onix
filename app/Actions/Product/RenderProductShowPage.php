<?php

namespace App\Actions\Product;

use App\Models\Product;
use App\Models\Review;
use Inertia\Inertia;
use Inertia\Response;

class RenderProductShowPage
{
    public function render_product_show_page($slug): Response
    {
        $product = Product::with(['images', 'category', 'operatingSystem', 'brand', 'screenType', 'processor', 'color', 'condition'])
            ->where('slug', $slug)
            ->firstOrFail();

        $characteristics = [
            'category' => [
                'name' => 'Category',
                'value' => $product->category->name ?? 'N/A'
            ],
            'os' => [
                'name' => 'OS',
                'value' => $product->os->name ?? 'N/A'
            ],
            'brand' => [
                'name' => 'Brand',
                'value' => $product->brand->name ?? 'N/A'
            ],
            'screen_type' => [
                'name' => 'Screen Type',
                'value' => $product->screenType->name ?? 'N/A'
            ],
            'processor' => [
                'name' => 'Processor',
                'value' => $product->processor->name ?? 'N/A'
            ],
            'color' => [
                'name' => 'Color',
                'value' => $product->color->name ?? 'N/A'
            ],
            'condition' => [
                'name' => 'Condition',
                'value' => $product->condition->name ?? 'N/A'
            ],
        ];

        $reviews = Review::where('product_id', $product->id)
            ->with('user')
            ->get();

        $reviewsData = $reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'review' => $review->review,
                'rating' => $review->rating,
                'user' => [
                    'id' => $review->user->id ?? null,
                    'name' => $review->user->name ?? 'Anonymous'
                ]
            ];
        });

        return Inertia::render('Products/ProductShow', [
            'product' => $product,
            'characteristics' => $characteristics,
            'reviews' => $reviewsData,
        ]);
    }
}
