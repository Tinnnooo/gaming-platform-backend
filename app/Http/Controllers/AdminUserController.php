<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{

    // render login page
    public function index()
    {
        if(!Auth::guard('admin_users')->check()){
            return view('AdministratorPortal.index');
        }
        return redirect()->intended('/dashboard');
    }


    // login function
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required', 'min:5']
        ]);

        if(Auth::guard('admin_users')->attempt($credentials)){
            $user = Auth::guard('admin_users')->user();
            $user->last_login_at = now();
            $user->save();
            return redirect()->intended('/dashboard');
        }

            return back()->with('loginError', 'Username or Password is incorrect');
    }

    // Logout function
    public function logout()
    {
        Auth::guard('admin_users')->logout();
        return redirect()->route('admin');
    }

    // render dashboard page
    public function index_dashboard()
    {
        if(Auth::guard('admin_users')->check()){
            return view('AdministratorPortal.dashboard');
        }
            return redirect('/');
    }

    // render and get admin users data
    public function admin_users(){
        return view('AdministratorPortal.admin_users', [
         "admin_users" => AdminUser::all(),
        ]);
    }
}
