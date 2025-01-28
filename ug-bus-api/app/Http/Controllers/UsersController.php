<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index(){
        $users = User::all();
        return view('pages.users.index', ['users'=> $users]);
    }


    public function update(Request $request){
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->save();
        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function destroy(Request $request){
        $user = User::find($request->id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
