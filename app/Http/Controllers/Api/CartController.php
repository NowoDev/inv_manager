<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    /**
     * add inventory to cart.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse|CartResource
     */
    public function add(Request $request, $id): JsonResponse|CartResource
    {
        $input = $request->all();

        $quantity = $input['quantity'];
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
}
