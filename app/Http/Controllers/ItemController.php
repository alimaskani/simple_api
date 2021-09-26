<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function show()
    {
        $items = Item::all();

        return response()->json(["data" => $items], Response::HTTP_OK);
    }

    public function index(Request $request)
    {
        $name = $request->name;
        $count_page = $request->count_page;

        $item = Item::query()
            ->where('name', 'LIKE', '%' . $name . '%')
            ->paginate($count_page);

        /*** check response ***/
        if ($item->isEmpty()) {
            return response()->json(["message" => "Not Found Item"], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['item' => $item], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        /*** validate ***/
        $request->validate([
            'name' => 'required',
            'color_id' => 'required|exists:colors,id',
            'brand_id' => 'required|exists:brands,id',
            'subtitle' => 'required|min:3|max:255',
        ]);


        /*** validate duplicate data ***/
        $name = $request->name;
        $brand = $request->brand_id;
        $color_id = $request->color_id;

        $validate_duplicate_item = Item::query()->where([
            ['name', '=', $name],
            ['color_id', '=', $color_id],
            ['brand_id', '=', $brand]
        ])->get();
        if ($validate_duplicate_item->count() > 0) {
            return response()->json(["message" => "item has exist"], Response::HTTP_BAD_REQUEST);
        }

        /*** insert ***/
        Item::query()->create([
            'name' => $request->input('name'),
            'color_id' => $request->input('color_id'),
            'brand_id' => $request->input('brand_id'),
            'subtitle' => $request->input('subtitle'),
        ]);

        return response()->json(["message" => "This Item SuccessFully Insert"], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        /*** validate ***/
        $validator = Validator::make(
            [
                'id' => $id,
                'name' => $request->input('name'),
                'color_id' => $request->input('color_id'),
                'brand_id' => $request->input('brand_id'),
                'subtitle' => $request->input('subtitle'),
            ]
            , [
            'id' => 'required|exists:items,id',
            'name' => 'required',
            'color_id' => 'required|exists:colors,id',
            'brand_id' => 'required|exists:brands,id',
            'subtitle' => 'required|min:3|max:255',

        ]);
        if ($validator->fails()) {
            return response()->json(
                ['success' => false, 'errors' => $validator->messages()],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        /*** validate duplicate data ***/
        $name = $request->name;
        $brand = $request->brand_id;
        $color_id = $request->color_id;

        $validate_duplicate_item = Item::query()->where([
            ['name', '=', $name],
            ['color_id', '=', $color_id],
            ['brand_id', '=', $brand]
        ])->get();

        if ($validate_duplicate_item->count() > 0 && $validate_duplicate_item[0]['id'] != $id) {
            return response()->json(["message" => "item has exist"], Response::HTTP_BAD_REQUEST);
        }


        $item = Item::query()->find($id);
        $item->update([
            'name' => $request->input('name'),
            'color_id' => $request->input('color_id'),
            'brand_id' => $request->input('brand_id'),
            'subtitle' => $request->input('subtitle'),
        ]);

        return response()->json(["message" => "This Item SuccessFully Updated "], Response::HTTP_OK);
    }

    public function destroy(Request $request, $id)
    {

        /*** validate ***/
        $validator = Validator::make(['id' => $id,], ['id' => 'required|exists:items,id',]);
        if ($validator->fails()) {
            return response()->json(
                ['success' => false, 'errors' => $validator->messages()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $item = Item::query()->find($id);
        $item->delete();

        return response()->json(["message" => "This Item SuccessFully Delete"], Response::HTTP_OK);
    }

}
