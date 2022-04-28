<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function getUsers(){
        $users = User::all();

        return $users;
    }

    public function newUser(){
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        User::create($data);
    }

    public function updateUser($id){
        $user = User::find($id);
        $user->name = request('name');
        $user->email = request('email');
        $user->password = request('password');
        $user->save();
    }

    public function deleteUser($id){
       User::find($id)->delete();
    }
}
