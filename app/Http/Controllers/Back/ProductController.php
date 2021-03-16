<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->paginate(10);
        if (request()->ajax()) {
            return response()->json($products);
        } else {
            return view('backend.products.index', compact('products'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request

     */
    public function store(Request $request)
    {
        $product = Product::create($this->validateProduct($request));
        $this->saveProductFile($request, $product);

        if ($request->ajax()) {
            return response()->json($product);
        } else {
            return redirect()
                ->route('backend.products.index')
                ->with('success', __('New product successfully added.'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     * @param Product $product
     * @param Request $request
     */
    public function edit(Product $product, Request $request)
    {
        $product = Product::query()->findOrFail($product->id);

        if ($request->ajax()) {
            return response()->json($product);
        } else {
            return view('backend.products.edit', compact('product'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     */
    public function update(Request $request, Product $product)
    {
        $product->update($this->validateProduct($request));
        $this->saveProductFile($request, $product);

        if ($request->ajax()) {
            return response()->json($product);
        } else {
            return redirect()
                ->route('backend.products.index')
                ->with('success', __('Product updated successfully.'));
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function validateProduct(Request $request): array
    {
        return $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,bmp,gif,svg',
        ]);
    }

    protected function saveProductFile(Request $request, $product)
    {
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $filename = $product->id . '.' . $uploadedFile->extension();
            $uploadedFile->storeAs('products_images', $filename, 'public');
            $product->update(['image' => $filename]);
        }
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param Product $product
     */
    public function destroy(Request $request, Product $product)
    {
        $product = Product::query()->findOrFail($product->id);
        $product->delete();
        $path = 'public\products_images\\' . $product->image;
        if ($product->image) {
            Storage::disk()->delete($path);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $product->title . __(' deleted successfully!')]);
        } else {
            return redirect()
                ->route("backend.products.index")
                ->with('success', __('Product deleted.'));
        }
    }
}
