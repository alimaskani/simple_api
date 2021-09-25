<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function Index(Request $request){
        $name  = $request->name;
        $count_page = $request->count_page;

        $item = DB::table(  'items')->where('name', 'LIKE', '%' . $name . '%')->paginate($count_page);

        /*** check response ***/
        if ($item->isEmpty()){
            return response()->json("Not Found Your Item", 400);
        }

        return response()->json($item, 201);
    }

    public function Store(Request $request){
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
         $validate_duplicate_item =DB::table('items')->where([
             ['name','=',$name],
             ['brand_id','=',$brand]
         ])->get();
         if ($validate_duplicate_item->count()>0){
             return response()->json("Your Item has exit", 400);
         }

         /*** insert ***/
        Item::create([
            'name' => $request->name,
            'color_id'=>$request->color_id,
            'brand_id'=>$request->brand_id,
            'subtitle'=>$request->subtitle,
        ]);

        return response()->json("This Item SuccessFully Insert", 201);
    }

    public function Update(Request $request,$id){
        /*** validate ***/
        $validate = $request->validate([
            'name' => 'required',
            'color_id' => 'required|exists:colors,id',
            'brand_id' => 'required|exists:brands,id',
            'subtitle' => 'required|min:3|max:255',
        ]);

        $item =  Item::find($id);
        $item->update($request->all());

        return response()->json("This Item SuccessFully Update", 201);
    }

    public function Destroy(Request $request,$id){
        $item = Item::find($id);
        $item->delete();

        return response()->json("This Item SuccessFully Delete", 201);
    }
}
