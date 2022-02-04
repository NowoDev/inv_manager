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
        $validator = Validator::make($input, [
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
     * @param $id
     * @return InventoryResource|JsonResponse
     */
    public function show($id): InventoryResource|JsonResponse
    {
        $inventory = Inventory::find($id);

        if (is_null($inventory)) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Inventory Doesn\'t Exist',
            ]);
        }

        return new InventoryResource($inventory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Inventory $inventory
     * @return JsonResponse|InventoryResource
     */
    public function update(Request $request, Inventory $inventory): JsonResponse|InventoryResource
    {
        $input = $request->all();
        $validator = Validator::make($input, [
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

        $inventory->update($input);

        return new InventoryResource($inventory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Inventory $inventory
     * @return JsonResponse
     */
    public function destroy(Inventory $inventory): JsonResponse
    {
        $inventory->delete();

        return response()->json([
            'status' => 'OK',
            'message' => 'Inventory Deleted'
        ]);
    }
}
