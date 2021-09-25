<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{

    public function Index(Request $request){
        $name  = $request->name;
        $count_page = $request->count_page;

        $data = DB::table('brands')->where('name', 'LIKE', '%' . $name . '%')->paginate($count_page);

        if ($data->isEmpty()){
            return response()->json("Not Found Your Color", 201);
        }

        return response()->json($data, 201);
    }

    public function Store(Request $request){
        /*** validate ***/
        $validate = $request->validate([
            'name' => 'required|unique:brands',
        ]);

        Brand::create([
            'name' => $request->name
        ]);

        return response()->json("Brand SuccessFully Insert", 201);
    }

    public function Update(Request $request, $id){
        /*** validate ***/
        $validate = $request->validate([
            'name' => 'required|unique:brands',
        ]);

        $color = Brand::find($id);
        $color->update($request->all());
        return response()->json("This Brand SuccessFully Update", 201);
    }

    public function Destroy(Request $request ,  $id){

        $color = Brand::find($id);
        $color->delete();

        return response()->json("This Brand SuccessFully Delete", 201);
    }

}
