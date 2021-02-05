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

    public function search(Request $request) {
        $term = $request->input('term');
        $products = Product::query()
            ->select([
                'id',
                'name',
                'description',
                'price',
                'currency',
            ])
            ->when($term, function ($query) use ($term) {
                $query->whereRaw("MATCH (`name`, `description`) AGAINST ('*$term*' IN BOOLEAN MODE)");
//            ->where('name', 'like', "%$term%")
//            ->orWhere('description', 'like', "%$term%")
            })
            ->paginate(3);

        return json_encode($products);
    }
}
