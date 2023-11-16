<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::simplePaginate(3);
        return $product;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'stock' => 'required|integer',
            'price' => 'required|decimal:0,2'
        ])->validate();

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'stock' => $request->stock,
            'price' => $request->price
        ]);

        return response()->json([
            'message' => 'Created'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if (!empty($product)) {
            return response()->json([
                'message' => 'Ok',
                'data' => $product
            ], 200);
        }

        return response()->json([
            'message' => 'Not Found'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'stock' => 'required|integer',
            'price' => 'required|decimal:0,2'
        ])->validate();

        $exist = Product::where('id', $id)->exists();

        if ($exist) {
            $product = Product::find($id);

            $product->update($request->all());

            return response()->json([
                'message' => 'Updated'
            ], 204);
        }

        return response()->json([
            'message' => 'Not Found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $exist = Product::where('id', $id)->exists();

        if ($exist) {
            $product = Product::find($id);
            $product->delete();

            return response()->json([
                'message' => 'Deleted'
            ], 204);
        }

        return response()->json([
            'message' => 'Not Found'
        ], 404);
    }
}
