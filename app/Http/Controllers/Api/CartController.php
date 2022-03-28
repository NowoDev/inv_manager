<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\AllCartResource;
use App\Http\Resources\AllCartResourceCollection;

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

    public function viewAll()
    {
        $cart = Cart::with('user', 'inventory')->get();

        if (is_null($cart)) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Cart Doesn\'t Exist',
            ]);
        }

        return new AllCartResourceCollection($cart);
    }

    public function view($id)
    {
        $cart = Cart::with('user', 'inventory')->find($id);

        if (is_null($cart)) {
            return response()->json([
                'status_code' => 404,
                'status' => 'Error',
                'message' => 'Cart Doesn\'t Exist',
            ]);
        }

        return new AllCartResource($cart);
    }
}
