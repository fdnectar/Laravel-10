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
            'username'=>'required|string|max:50',
            'email'=>'required|max:50',
        ]);

        $imageFile = $this->uploadFIle($request, 'avator');
        // dd($imageFile);

        $user = Auth::user();
        if($imageFile) $user->avatar = $imageFile;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        notyf()->addSuccess('Profile Updated Successfully!');
        return response(['message' => 'Profile Updated Successfuly'], 200);

    }
}
