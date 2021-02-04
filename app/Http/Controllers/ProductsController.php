<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index() {
        $products = Product::query()->paginate(3);

        return view('index', compact('products'));
    }

    public function show($id) {
        $product = Product::query()->find($id);

        return view('product', compact('product'));
    }

    public function import() {

    }
}
