<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class productController extends Controller
{
    public function index()
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'No products found',
                'status'  => 200,
                'data'    => [],
            ], 200);
        }

        return response()->json([
            'message' => 'Products retrieved successfully',
            'status'  => 200,
            'data'    => $products,
        ], 200);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
                'status'  => 404,
            ], 404);
        }

        return response()->json([
            'message' => 'Product retrieved successfully',
            'status'  => 200,
            'data'    => $product,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'  => 422,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $product = Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'status'  => 201,
            'data'    => $product,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
                'status'  => 404,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price'       => 'sometimes|numeric|min:0',
            'stock'       => 'sometimes|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'  => 422,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $product->update($request->only(['name', 'description', 'price', 'stock']));

        return response()->json([
            'message' => 'Product updated successfully',
            'status'  => 200,
            'data'    => $product->fresh(),
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
                'status'  => 404,
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
            'status'  => 200,
        ], 200);
    }
}