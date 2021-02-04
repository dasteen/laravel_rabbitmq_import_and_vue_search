<?php

namespace App\Http\Controllers;

use App\Jobs\ImportJob;
use App\Models\Marketplace;
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

        $marketplaces = Marketplace::all();

        foreach ($marketplaces as $marketplace) {
            try {
                ImportJob::dispatch($marketplace)->onQueue('import');
            }
            catch (\Exception $exception) {
                return redirect()->route('index')->withErrors($exception->getMessage());
            }
        }

        return redirect()->route('index');
    }
}
