<?php

namespace App\Http\Controllers;

use App\Actions\Product\AddReview;
use App\Actions\Product\RenderProductShowPage;
use App\Actions\Product\RenderProductsPage;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(RenderProductsPage $action, Request $request)
    {
        return $action->render_products_page($request);
    }
    public function show(RenderProductShowPage $action, $slug)
    {
        return $action->render_product_show_page($slug);
    }
    public function reviewAdd(AddReview $action, Request $request, $id)
    {
        return $action->add_review($request, $id);
    }
    public function search(Request $request)
    {
        $query = $request->query('query');

        if (!$query) {
            return response()->json([
                'results' => []
            ]);
        }

        $results = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->select('id', 'name', 'description', 'slug')
            ->limit(15)
            ->get();

        return response()->json([
            'results' => $results
        ]);
    }
}
