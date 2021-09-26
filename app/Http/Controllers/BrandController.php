<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function show()
    {
        $brands = Brand::all();
        return response()->json(['data' => $brands], Response::HTTP_OK);
    }

    public function index(Request $request)
    {
        $name = $request->name;
        $count_page = $request->count_page;


        $data = Brand::query()
            ->where('name', 'LIKE', '%' . $name . '%')
            ->paginate($count_page);

        if ($data->isEmpty()) {
            return response()->json(["message" => "Not Found Brand"], Response::HTTP_NOT_FOUND);
        }

        return response()->json(["brand" => $data], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        /*** validate ***/
        $request->validate([
            'name' => 'required|unique:brands,name',
        ]);

        Brand::query()->create([
            'name' => $request->name
        ]);

        return response()->json(["message" => "Brand SuccessFully Insert"], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        /*** validate ***/
        $validator = Validator::make(['id' => $id, 'name' => $request->name], [
            'id' => 'required|exists:brands,id',
            'name' => 'required|unique:brands,name,' . $id
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $color = Brand::query()->find($id);
        $color->update([
            'name' => $request->name
        ]);

        return response()->json(["message" => "This Brand SuccessFully Updated"], Response::HTTP_OK);
    }

    public function destroy(Request $request, $id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|exists:brands,id',]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $color = Brand::query()->find($id);
        $color->delete();


        return response()->json(["message" => "This Brand SuccessFully Deleted"], Response::HTTP_OK);
    }

}
