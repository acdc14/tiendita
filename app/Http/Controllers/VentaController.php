<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Venta;
use App\Models\Product;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $venta = Venta::with(['product', 'user'])->get();
        $venta = Venta::with('product')->get();

        return response()->json([
            'data' => $venta
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'date' => 'required|date',
            'product' => 'required|integer|exists:products,id',
            'user' => 'required|integer|exists:users,id',
            'quantiy' => 'required|integer'
            // 'total' => 'required|decimal:0,2'
        ])->validate();

        $product = Product::find($request->product);

        $newStock = $product->stock - $request->quantiy;
        $total = $request->quantiy * $product->price;

        if ($newStock < 0) {
            return response()->json([
                'message' => 'No stock available'
            ], 400);
        }

        $product->stock = $newStock;
        $product->save();

        Venta::create([
            'date' => $request->date,
            'product' => $request->product,
            'user' => $request->user,
            'quantiy' => $request->quantiy,
            'total' => $total
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
        $venta = Venta::with(['product', 'user'])->find($id);

        if (!empty($venta)) {
            return response()->json([
                'message' => 'Ok',
                'data' => $venta
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
            'date' => 'required|date',
            'product' => 'required|integer|exists:products,id',
            'user' => 'required|integer|exists:users,id',
            'quantiy' => 'required|integer'
            // 'total' => 'required|decimal:0,2'
        ])->validate();

        $exist = Venta::where('id', $id)->exists();

        if ($exist) {
            $venta = Venta::find($id);
            $product = Product::find($venta->product);

            $newStock = $product->stock + $venta->quantiy - $request->quantiy;
            $total = $request->quantiy * $product->price;

            if ($newStock < 0) {
                return response()->json([
                    'message' => 'No stock available'
                ], 400);
            }

            $product->stock = $newStock;
            $product->save();

            $venta->update($request->all());

            return response()->json([
                'message' => 'Updated'
            ], 204);
        }

        // return response()->json([
        //     'message' => 'Not Found'
        // ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $exist = Venta::where('id', $id)->exists();

        if ($exist) {
            $venta = Venta::find($id);
            $product = Product::find($venta->product);

            $newStock = $product->stock + $venta->quantiy;
            $product->stock = $newStock;
            $product->save();

            $venta->delete();

            return response()->json([
                'message' => 'Deleted'
            ], 204);
        }

        return response()->json([
            'message' => 'Not Found'
        ], 404);
    }
}
