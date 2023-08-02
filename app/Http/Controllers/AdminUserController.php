<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Models\AdminUser;
use App\Models\BlockedUser;
use App\Models\Game;
use App\Models\GameVersion;
use App\Models\PlatformUser;
use App\Models\Score;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{

    public function __construct(protected AdminService $adminService)
    {
    }

    // render login page
    public function index()
    {
        if (!Auth::guard('admin_users')->check()) {
            return view('AdministratorPortal.index');
        }
        return redirect()->intended('/dashboard');
    }


    // login function
    public function login(AdminLoginRequest $request)
    {
        if (Auth::guard('admin_users')->attempt($request->validated())) {
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
        if (Auth::guard('admin_users')->check()) {
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

    public function detail_platformUser($username)
    {
        return view('AdministratorPortal.detail_platform_user', [
            'platform_user' => $this->adminControllerService->getUser($username),
        ]);
    }

    public function block_platformUser($username, Request $request)
    {
        $user = PlatformUser::where('username', $username)->firstOrFail();

        if (!$user->blocked) {
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

    public function index_manageGames()
    {
        $games = Game::with('author', 'gameVersions')->get();
        return view(
            'AdministratorPortal.manage_games',
            compact('games')
        );
    }

    public function index_manageGameScores()
    {
        $games = Game::with('gameVersions.gameScores')->get();

        return view('AdministratorPortal.manage_game_scores', compact('games'));
    }

    public function delete_gameScore($score_id)
    {
        $score = Score::findOrFail($score_id);

        $user = $score->user;

        $user->game_scores -= $score->score;
        $user->save();

        $score->delete();

        return back()->with('deleteSuccess', 'Score Deleted.');
    }

    public function reset_gameScores($game_id)
    {
        $game = Game::findOrFail($game_id);

        $game->gameVersions->each(function ($version) {
            $version->gameScores->each(function ($score) {
                $user = $score->user;
                $user->game_scores -= $score->score;
                $user->save();
            });
            $version->gameScores()->delete();
        });

        return back()->with('resetSuccess', 'Game Scores is reset.');
    }

    public function reset_versionHighScores($version_id)
    {
        $gameVersion = GameVersion::findOrFail($version_id);

        $gameVersion->gameScores->each(function ($score) {
            $user = $score->user;
            $user->game_scores -= $score->score;
            $user->save();
        });

        $gameVersion->gameScores()->delete();

        return back()->with('resetSuccess', 'Highscores is reset.');
    }
}
