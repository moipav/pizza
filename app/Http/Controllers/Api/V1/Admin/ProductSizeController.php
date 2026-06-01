<?php declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\StoreProductSizeRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Requests\Admin\UpdateProductSizeRequest;
use App\Http\Resources\Api\V1\ProductSizeResource;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\JsonResponse;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProductSizeResource::collection(ProductSize::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductSizeRequest $request): JsonResponse
    {
        ProductSize::create($request->validated());

        return response()->json(['message' => 'Продукт успешно добавлен']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $productSize = ProductSize::find($id);
        if (!$productSize) {
            return response()->json(['message' => 'Размер не найден']);
        }
        return response()->json(['data' => new ProductSizeResource($productSize)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductSizeRequest $request, ProductSize $productSize): JsonResponse
    {
        $productSize->update($request->validated());

        return response()->json(['message' => $productSize->size_name . ' обновлен']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSize $productSize)
    {
        $productSize->delete();
        return response()->json(['message' => 'Удалено']);
    }
}
