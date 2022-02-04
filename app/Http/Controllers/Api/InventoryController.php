<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Resources\InventoryResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\InventoryResourceCollection;

class InventoryController extends Controller
{
    /**
     * Display a listing of the inventory.
     *
     * @return InventoryResourceCollection
     */
    public function index(): InventoryResourceCollection
    {
        $inventories = Inventory::get();

        return new InventoryResourceCollection($inventories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|InventoryResource
     */
    public function store(Request $request): JsonResponse|InventoryResource
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:inventories,name',
            'price' => 'integer|required',
            'quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Error Validation',
                'data' => [
                    $validator->errors()
                ],
            ]);
        }

        $inventory = Inventory::create($input);

        return new InventoryResource($inventory);
//        return response()->json([
//            'status_code' => 201,
//            'data' => [new InventoryResource($inventory)],
//            'message' => 'Added to Inventory',
//        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Inventory $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Inventory $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Inventory $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
