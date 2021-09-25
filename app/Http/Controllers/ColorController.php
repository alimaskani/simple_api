<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class ColorController extends Controller
{

    public function Index(Request $request){
        $name  = $request->name;
        $count_page = $request->count_page;

        $data = DB::table('colors')->where('name', 'LIKE', '%' . $name . '%')->paginate($count_page);

        if ($data->isEmpty()){
            return response()->json("Not Found Your Color", 400);
        }

        return response()->json($data, 201);
    }

    public function Store(Request $request){
        /*** validate ***/
        $validate = $request->validate([
            'name' => 'required',
            'hexcode' => 'required|unique:colors'
        ]);

        Color::create([
            'name' => $request->name,
            'hexcode' => $request->hexcode,
        ]);

        return response()->json("This Color SuccessFully Inserte", 201);
    }

    public function Update(Request $request, $id){
        /*** validate ***/
        $validate = $request->validate([
            'name' => 'required',
            'hexcode' => 'required|unique:colors'
        ]);

        $color = Color::find($id);
        $color->update($request->all());

        return response()->json("This Color SuccessFully Update", 201);
    }

    public function Destroy($id){
        $color = Color::find($id);
        $color->delete();

        return response()->json("This Color SuccessFully Delete", 201);
    }

}
