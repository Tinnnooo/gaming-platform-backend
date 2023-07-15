<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\BlockedUser;
use App\Models\PlatformUser;
use App\Services\AdminControllerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{

    public function __construct(protected AdminControllerService $adminControllerService)
    {

    }

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
            return view('AdministratorPortal.dashboard', [
                "admin_users" => AdminUser::all()
            ]);
        }
            return redirect('/');
    }

    public function index_platformUsers()
    {
        return view('AdministratorPortal.platform_users', [
            "platform_users" => PlatformUser::all()
        ]);
    }

    public function detail_platformUser($username){
        return view('AdministratorPortal.detail_platform_user', [
            'platform_user' => $this->adminControllerService->getUser($username),
        ]);
    }

    public function block_platformUser($username, Request $request){
        $user = PlatformUser::where('username', $username)->firstOrFail();

        if(!$user->blocked){
            $validator = $request->validate([
                'reason' => 'required',
            ]);

            BlockedUser::create([
                'user_id' => $user->id,
                'reason' => $validator['reason'],
            ]);

            return back()->with('blockInfo', 'User is blocked.');
        }

        $user->blocked->delete();
        return back()->with('blockInfo', 'User is unblock.');

    }
}
