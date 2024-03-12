<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.pages.index');
    }

    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function AdminLogin()
    {
        return view('admin.pages.admin_login');
    }

    public function AdminProfile() {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        // dd($profileData);
        return view('admin.pages.admin_profile', compact('profileData'));
    }
}
