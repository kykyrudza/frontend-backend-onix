<?php

namespace App\Actions\Category;

use App\Models\Category;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class CategoryAction
{
    public function render_category($slug): Response
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $subCategories = $category->allChildren;

        $products = Product::whereIn('category_id', $subCategories->pluck('id'))->with(['category:id,name', 'images'])->get();

        return Inertia::render('Category/ShowCategories', [
            'category' => $category,
            'products' => $products,
        ]);
    }

    public function render_subcategory($slug): Response
    {
        $subCategory = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $subCategory->id)->with(['category:id,name', 'images'])->get();

        return Inertia::render('Category/ShowSubCategories', [
            'category' => $subCategory,
            'products' => $products,
        ]);
    }
}
