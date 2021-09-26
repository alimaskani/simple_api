<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function show(){
        $users = User::all();

        return response()->json(["data" =>$users],Response::HTTP_OK);
    }

    public function index(Request $request){
        $name  = $request->name;
        $count_page = $request->count_page;

        $user = DB::table('users')->where('name', 'LIKE', '%' . $name . '%')->paginate($count_page);

        if ($user->isEmpty()){
            return response()->json(["message" => "Not Found User "],Response::HTTP_NOT_FOUND);
        }

        return response()->json(["user" => $user ],Response::HTTP_OK);
    }

    public function store(Request $request){
        /*** validate ***/
        $request->validate([
            'name' => 'required',
            'family' => 'required',
            'phone' => 'required',
            'address' => 'required|min:3|max:255',
            'username' => 'required|min:3',
            'password' => 'required|min:3',
            'email' => 'required|unique:users',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        User::query()->create([
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

        return response()->json(["message" => "This Item SuccessFully Insert"], Response::HTTP_CREATED);
    }

    public function update(Request $request,$id){
        /*** validate ***/
        $validator = Validator::make(
            [
                'id' => $id,
                'name' => $request->input('name'),
                'family' => $request->input('family'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'username' => $request->input('username'),
                'password' => $request->input('password'),
                'email' => $request->input('email'),
                'image' => $request->input('image'),
                'permission_id' => $request->input('permission_id'),
            ],
            [
                'id' => 'required|exists:users,id',
                'name' => 'required',
                'family' => 'required',
                'phone' => 'required',
                'address' => 'required|min:3|max:255',
                'username' => 'required|min:3|unique:users,username,'.$id,
                'password' => 'required|min:3',
                'email' => 'required|email|unique:users,email,'.$id,
                'permission_id' => 'required|exists:permissions,id',
            ]);

        if ($validator->fails()) {
            return response()->json(
                ['success' => false, 'errors' => $validator->messages()],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $item =  User::query()->find($id);
        $item->update([
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

        return response()->json(["message" => "This Item SuccessFully Update"], Response::HTTP_OK);
    }

    public function destroy(Request $request,$id){
        /*** validate ***/
        $validator = Validator::make(['id' => $id], ['id' => 'required|exists:users,id',]);
        if ($validator->fails()) {
            return response()->json(
                ['success' => false, 'errors' => $validator->messages()],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $item = User::query()->find($id);
        $item->delete();

        return response()->json(["message" => "This Item SuccessFully Delete"], Response::HTTP_OK);
    }

}
