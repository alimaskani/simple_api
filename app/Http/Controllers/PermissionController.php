<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function Index(Request $request){

        $name  = $request->name;
        $count_page = $request->count_page;

        $permission = DB::table('permissions')->where('name', 'LIKE', '%' . $name . '%')->paginate($count_page);

        if ($permission->isEmpty()){
            return response()->json('Not Found Your Permission',400);
        }

        return response()->json($permission,201);
    }

    public function Store(Request $request){
        /*** validate ***/
        $validate = $request->validate([
            'name' => 'required|unique:permissions',
            'image' => 'required',
        ]);

        Permission::create([
            'name' => $request->input('name'),
            'image' => $request->input('image'),
        ]);

        return response()->json("This Item SuccessFully Insert", 201);
    }

    public function Update(Request $request,$id){
        /*** validate ***/
        $validate = $request->validate([
            'name' => 'required|unique:permissions,id',
            'image' => 'required',
        ]);

        $item =  Permission::find($id);
        $item->update($request->all());

        return response()->json("This Item SuccessFully Update", 201);
    }

    public function Destroy(Request $request,$id){
        $item = Permission::find($id);
        $item->delete();

        return response()->json("This Item SuccessFully Delete", 201);
    }

}
