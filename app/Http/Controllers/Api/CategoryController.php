<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\GameResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return new GameResource(true, 'List Data Categories', $categories);
    }
}
