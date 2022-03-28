<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\CartResourceCollection;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with('user', 'inventory')->get();

        if (is_null($cart)) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Cart Doesn\'t Exist',
            ]);
        }

        return new CartResourceCollection($cart);
    }

    public function store(Request $request)
    {
        $quantity = $request['quantity'];
        $inventory = Inventory::find($id);

        if ($quantity > $inventory->quantity) {
            return response()->json([
                'status' => 'Error',
                'status_code' => 401,
                'message' => 'You\'ve exceeded the available quantity',
            ]);
        }

        $cart = Cart::firstOrCreate([
            'inventory_id' => $id,
            'user_id' => auth()->id(),
            'quantity' => $quantity,
        ]);

        if ($cart->wasRecentlyCreated) {
            $new_quantity = $inventory->quantity - $quantity;
            $inventory->update(['quantity' => $new_quantity]);
        }

        return new CartResource($cart);
    }

    public function show($id)
    {
        $cart = Cart::with('user', 'inventory')->find($id);

        if (is_null($cart)) {
            return response()->json([
                'status_code' => 404,
                'status' => 'Error',
                'message' => 'Cart Doesn\'t Exist',
            ]);
        }

        return new CartResource($cart);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
