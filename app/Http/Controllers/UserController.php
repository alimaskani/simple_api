<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function Index(Request $request){
        $name  = $request->name;
        $count_page = $request->count_page;

        $users = DB::table('users')->where('name', 'LIKE', '%' . $name . '%')->paginate($count_page);

        if ($users->isEmpty()){
            return response()->json('Please Enter Name ',400);
        }

        return response()->json($users,201);
    }

    public function Store(Request $request){
        /*** validate ***/
        $request->validate([
            'name' => 'required',
            'family' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required|min:3|max:255',
            'username' => 'required|min:3',
            'password' => 'required|min:3',
            'email' => 'required|unique:users',
            'permission_id' => 'required',
        ]);

        User::create([
            'name' => $request->input('name'),
            'family' => $request->input('family'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'email' => $request->input('email'),
            'permission_id' => $request->input('permission_id'),
            'image' => $request->input('image'),
        ]);

        return response()->json("This Item SuccessFully Insert", 201);
    }

    public function Update(Request $request,$id){
        /*** validate ***/
        $validate = $request->validate([
            'name' => 'required',
            'family' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required|min:3|max:255',
            'username' => 'required|min:3',
            'password' => 'required|min:3',
            'email' => 'required|unique:users',
            'permission_id' => 'required',
        ]);

        $item =  User::find($id);
        $item->update($request->all());

        return response()->json("This Item SuccessFully Update", 201);
    }

    public function Destroy(Request $request,$id){
        $item = User::find($id);
        $item->delete();

        return response()->json("This Item SuccessFully Delete", 201);
    }

}
