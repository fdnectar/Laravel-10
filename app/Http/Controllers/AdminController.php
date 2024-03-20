<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index() {
        return view('admin.pages.index');
    }

    public function AdminLogout(Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function AdminLogin() {
        return view('admin.pages.admin_login');
    }

    public function AdminProfile() {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.pages.admin_profile', compact('profileData'));
    }

    public function AdminProfileUpdate(Request $request) {

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('images/admin_images/'.$data->photo));
            $fileName = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('images/admin_images'), $fileName);
            $data->photo = $fileName;
        }

        $data->save();

        $showToaster = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($showToaster);
    }

    public function AdminChangePassword() {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.pages.change_password', compact('profileData'));
    }

    public function AdminUpdatePassword(Request $request) {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password, auth::user()->password)) {
            $showToaster = array(
                'message' => 'Old Password does not match',
                'alert-type' => 'error'
            );
            return back()->with($showToaster);
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $showToaster = array(
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success'
        );
        return back()->with($showToaster);
    }

    public function AllType()
    {
        $type = PropertyType::latest()->get();
        return view('admin.pages.all_type', compact('type'));
    }

    public function AddType()
    {
        return view('admin.pages.add_type');
    }
}
