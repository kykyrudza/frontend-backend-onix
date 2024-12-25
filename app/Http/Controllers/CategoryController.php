<?php

namespace App\Http\Controllers;

use App\Actions\Category\CategoryAction;

class CategoryController extends Controller
{
    public function show(CategoryAction $action, $slug)
    {
       return $action->render_category($slug);
    }
    public function subcategory(CategoryAction $action, $slug)
    {
        return $action->render_subcategory($slug);
    }
}
