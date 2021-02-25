<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Application|Factory|View
     */
    public function index()
    {
        $products = Product::query()
            ->paginate();
        return view('backend.products.index', compact('products'));
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
     * @param \Illuminate\Http\Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image_name' => 'nullable|image',
        ]);

        $product = new Product();
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->save();

        if ($request->hasFile('image_name')) {
            $uploaded_file = $request->file('image_name');
            $file_name = $product->id . '.' . $uploaded_file->extension();
            $uploaded_file->storeAs('public/products_images', $file_name);
            $product->image_name = $file_name;
            $product->save();
        }
        return redirect()
            ->route('backend.products.index')
            ->with('success', 'New product successfully added.');

    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return Application|Factory|View
     */
    public function edit(Product $product)
    {
        return view('backend.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image_name' => 'nullable|image',
        ]);

        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->save();
        if ($request->hasFile('image_name')) {
            $uploaded_file = $request->file('image_name');
            $file_name = $product->id . '.' . $uploaded_file->extension();
            $uploaded_file->storeAs('public/products_images', $file_name);
            $product->image_name = $file_name;
            $product->save();
        }
        return redirect()
            ->route('backend.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return RedirectResponse

     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()
            ->route('backend.products.index')
            ->with('success', 'Product deleted.');
    }
}
