<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $products = Product::query()
            ->paginate(5);
        return view('backend.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Application|Factory|View
     */
    public function create(): Factory|View|Application
    {
        return view('backend.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $product = Product::create($this->validateProduct($request));
        $this->checkFile($request, $product);

        return redirect()
            ->route('backend.products.index')
            ->with('success', __('New product successfully added.'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return Application|Factory|View
     */
    public function edit(Product $product): Factory|View|Application
    {
        return view('backend.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->update($this->validateProduct($request));
        $this->checkFile($request, $product);

        return redirect()
            ->route('backend.products.index')
            ->with('success', __('Product updated successfully.'));
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
            'image' => 'image|mimes:jpg, jpeg, png, bmp, gif, svg',
        ]);
    }

    protected function checkFile(Request $request, $product)
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
     * @param Product $product
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product = Product::query()->findOrFail($product->id);
        $product->delete();
        $path = 'public\products_images\\' . $product->image;
        if ($product->image) {
            Storage::disk()->delete($path);
        }

        return redirect()
            ->route('backend.products.index')
            ->with('success', __('Product deleted.'));
    }
}
