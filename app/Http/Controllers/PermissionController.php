<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function show()
    {
        $permissions = Permission::all();
        return response()->json(["data" => $permissions], Response::HTTP_OK);
    }

    public function index(Request $request)
    {
        $name = $request->name;
        $count_page = $request->count_page;

        $permission = Permission::query()
            ->where('name', 'LIKE', '%' . $name . '%')
            ->paginate($count_page);

        if ($permission->isEmpty()) {
            return response()->json(["error" => "Not Found Permission"], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $permission], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        /*** validate ***/
        $validate = $request->validate([
            'name' => 'required|unique:permissions',
            'image' => 'required',
        ]);

        Permission::query()->create([
            'name' => $request->input('name'),
            'image' => $request->input('image'),
        ]);

        return response()->json(["message" => "This Item SuccessFully Inserted"], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        /*** validate ***/
        $validator = Validator::make(
            [
                'id' => $id,
                'name' => $request->input('name'),
                'image' => $request->input('image')
            ],
            [
                'id' => 'required|exists:permissions,id',
                'name' => 'required|unique:permissions,name,' . $id,
                'image' => 'required'
            ]);

        if ($validator->fails()) {
            return response()->json(
                ['success' => false, 'errors' => $validator->messages()],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $item = Permission::query()->find($id);
        $item->update([
            'name' => $request->input('name'),
            'image' => $request->input('image'),
        ]);

        return response()->json(["message" => "This Item SuccessFully Updated"], Response::HTTP_OK);
    }

    public function destroy(Request $request, $id)
    {
        /*** validation ***/
        /*** validate ***/
        $validator = Validator::make(['id' => $id], ['id' => 'required|exists:permissions,id',]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()],
                Response::HTTP_UNPROCESSABLE_ENTITY);}


        $item = Permission::query()->find($id);
        $item->delete();

        return response()->json(["message" => "This Item SuccessFully Deleted"], Response::HTTP_CREATED);
    }

}
