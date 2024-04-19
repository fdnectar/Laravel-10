<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    use FileUploadTrait;

    public function updateProfile(Request $request) {
        $request->validate([
            'avator'=>'nullable|image|max:500',
            'name'=>'required|string|max:50',
            'username'=>'required|string|max:50|unique:users,username,'.auth()->user()->id,
            'email'=>'required|max:50',
        ]);
        $imageFile = $this->uploadFIle($request, 'avator');

        $user = Auth::user();
        if($imageFile) $user->avatar = $imageFile;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if($request->filled('current_password')) {
            $request->validate([
                'current_password' => 'required|current_password',
                'password' => 'required|string|min:8|confirmed'
            ]);
            $user->password = bcrypt($request->password);
        }
        $user->save();

        notyf()->addSuccess('Profile Updated Successfully!');
        return response(['message' => 'Profile Updated Successfuly'], 200);

    }
}
