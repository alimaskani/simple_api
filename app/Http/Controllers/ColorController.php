<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{

    public function show()
    {
        $colors = Color::all();
        return response()->json(['data' => $colors], Response::HTTP_OK);
    }

    public function index(Request $request)
    {
        $name = $request->name;
        $count_page = $request->count_page;


        $data = Color::query()
            ->where('name', 'LIKE', '%' . $name . '%')
            ->paginate($count_page);

        if ($data->isEmpty()) {
            return response()->json(["message" => "Not Found Color"], Response::HTTP_NOT_FOUND);
        }

        return response()->json(["data" => $data], Response::HTTP_OK);

    }

    public function store(Request $request){
        /*** validate ***/
        $request->validate([
            'name' => 'required',
            'hex_code' => 'required|unique:colors,hex_code'
        ]);

        Color::query()->create([
            'name' => $request->name,
            'hex_code' => $request->hex_code,
        ]);

        return response()->json(["message" => "This Color SuccessFully Inserted"], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        /*** validate ***/
        $validator = Validator::make(
            [
                'id' => $id,
                'name' => $request->input('name'),
                'hex_code' => $request->input('hex_code')
            ],
            [
                'id' => 'required|exists:users,id',
                'name' => 'required',
                'hex_code' => 'required|exists:colors,hex_code|unique:colors,hex_code,' . $id
            ]);
        if ($validator->fails()) {
            return response()->json(
                ['success' => false, 'errors' => $validator->messages()],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $color = Color::query()->find($id);
        $color->update([
            'name' => $request->name,
            'hex_code' => $request->hex_code,
        ]);

        return response()->json(["message" => "This Color SuccessFully Updated"], Response::HTTP_OK);
    }

    public function destroy($id){
        /*** validate ***/
        $validator = Validator::make(['id' => $id], ['id' => 'required|exists:colors,id',]);
        if ($validator->fails()) {
            return response()->json(
                ['success' => false, 'errors' => $validator->messages()],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $color = Color::query()->find($id);
        $color->delete();

        return response()->json(['message' => "This Color SuccessFully Deleted"], Response::HTTP_OK);
    }

}
