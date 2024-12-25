<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function index()
    {
        session()->regenerate();
        session()->regenerateToken();

        $most_sold_in_store = Product::most_sold_in_store('4');

        $region = 'Фортечний';
        $most_sold_in_region = Product::most_sold_in_region($region, '4');

        return Inertia::render('Home/Home', [
            'most_sold_in_store' => $most_sold_in_store,
            'most_sold_in_region' => $most_sold_in_region,
            'region' => $region,
        ]);
    }
    public function faq()
    {
        return Inertia::render('Faq/Index');
    }
    public function contact()
    {
        return Inertia::render('Contact/Index');
    }
    public function about()
    {
        return Inertia::render('About/Index');
    }
}
