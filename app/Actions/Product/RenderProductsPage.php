<?php

namespace App\Actions\Product;

use App\Models\BatteryCapacity;
use App\Models\Brand;
use App\Models\CameraResolution;
use App\Models\Category;
use App\Models\Color;
use App\Models\Condition;
use App\Models\OperatingSystem;
use App\Models\Processor;
use App\Models\Product;
use App\Models\Ram;
use App\Models\ScreenType;
use App\Models\Size;
use App\Models\Storage;
use Inertia\Inertia;
use Inertia\Response;

class RenderProductsPage
{
    public function render_products_page($request): Response
    {
        $filterMapping = [
            'deviceType' => 'category_id',
            'brand' => 'brand_id',
            'screenSize' => 'screen_size_id',
            'screenType' => 'screen_type_id',
            'os' => 'os_id',
            'processor' => 'processor_id',
            'ram' => 'ram_id',
            'storage' => 'storage_id',
            'cameraResolution' => 'camera_resolution_id',
            'batteryCapacity' => 'battery_capacity_id',
            'color' => 'color_id',
            'condition' => 'condition_id',
            'availability' => 'availability',
        ];

        $query = Product::with(['category:id,name', 'images']);

        foreach ($filterMapping as $filterKey => $column) {
            if ($request->filled($filterKey)) {
                $values = $request->get($filterKey);
                if (is_array($values)) {
                    $query->whereIn($column, $values);
                } else {
                    $query->where($column, $values);
                }
            }
        }

        if ($request->filled('priceMin')) {
            $query->where('price', '>=', $request->input('priceMin'));
        }

        if ($request->filled('priceMax')) {
            $query->where('price', '<=', $request->input('priceMax'));
        }

        $products = $query->paginate(15);

        $filtersOptions = [
            'deviceType' => Category::all()->pluck('name')->toArray(),
            'brand' => Brand::all()->pluck('name')->toArray(),
            'screenSize' => Size::all()->pluck('name')->toArray(),
            'screenType' => ScreenType::all()->pluck('name')->toArray(),
            'os' => OperatingSystem::all()->pluck('name')->toArray(),
            'processor' => Processor::all()->pluck('name')->toArray(),
            'ram' => Ram::all()->pluck('name')->toArray(),
            'storage' => Storage::all()->pluck('name')->toArray(),
            'cameraResolution' => CameraResolution::all()->pluck('name')->toArray(),
            'batteryCapacity' => BatteryCapacity::all()->pluck('battery_capacity')->toArray(),
            'color' => Color::all()->pluck('name')->toArray(),
            'condition' => Condition::all()->pluck('name')->toArray(),
        ];
        try {
            return Inertia::render('Products/ProductsAll', [
                'products' => $products->items(),
                'currentPage' => $products->currentPage(),
                'lastPage' => $products->lastPage(),
                'total' => $products->total(),
                'perPage' => $products->perPage(),
                'filtersOptions' => $filtersOptions,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
