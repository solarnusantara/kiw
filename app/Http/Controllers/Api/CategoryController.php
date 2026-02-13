<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AllCategoryCollection;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
		$categories = cache()->remember('all_categories', 60, function () {
			return Category::where('level', 0)->orderBy('order_level', 'desc')->get();
		});

		return new AllCategoryCollection($categories);
    }

    public function featured()
    {
        return new CategoryCollection(Category::where('featured', 1)->get());
    }

    public function first_level_categories()
    {
        return new CategoryCollection(Category::where('level', 0)->get());
    }
}
