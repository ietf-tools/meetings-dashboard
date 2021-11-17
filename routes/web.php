<?php

use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\Documentation\ReferencesController;
use App\Http\Controllers\Logs\AuditLogsController;
use App\Http\Controllers\Logs\SystemLogsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ParticipantsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
    //return view('pages.index');
});
//Route::get('dashboard', [PagesController::class, 'index'])->name('dashboard');
$menu = theme()->getMenu();
array_walk($menu, function ($val) {
    if (isset($val['path'])) {
        $route = Route::get($val['path'], [PagesController::class, 'index']);

        // Exclude documentation from auth middleware
        if (!Str::contains($val['path'], 'documentation')) {
            $route->middleware('auth');
        }
    }
});

// Documentations pages
Route::prefix('documentation')->group(function () {
    Route::get('getting-started/references', [ReferencesController::class, 'index']);
    Route::get('getting-started/changelog', [PagesController::class, 'index']);
});

Route::middleware('auth')->group(function () {
    // Account pages
    Route::prefix('account')->group(function () {
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::put('settings/email', [SettingsController::class, 'changeEmail'])->name('settings.changeEmail');
        Route::put('settings/password', [SettingsController::class, 'changePassword'])->name('settings.changePassword');
    });

    // Logs pages
    Route::prefix('log')->name('log.')->group(function () {
        Route::resource('system', SystemLogsController::class)->only(['index', 'destroy']);
        Route::resource('audit', AuditLogsController::class)->only(['index', 'destroy']);
    });
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::post('users/{id}/promote', [AdminController::class, 'promote'])->name('users.promote');
        Route::resource('users', AdminController::class)->only(['index', 'destroy']);
        Route::get('systems', [AdminController::class, 'systems'])->name('admin.systems');
        Route::post('systems/{id}/active', [AdminController::class, 'meetingActive'])->name('meeting-info.active');
        Route::delete('systems/{id}/delete', [AdminController::class, 'meetingDestroy'])->name('meeting-info.destroy');
        Route::post('systems/addMeeting', [AdminController::class, 'addMeeting'])->name('meeting-info.create');
        Route::post('updateMeetEchoParams', [AdminController::class, 'updateMeetEchoParams'])->name('admin.updateMeetEchoParams');
    });
    Route::get('test', [ReportsController::class, 'test'])->name('reports.test');
    Route::post('participants/{id}/hide', [ParticipantsController::class, 'hide'])->name('participant.hide');
    Route::get('participants/index', [ParticipantsController::class, 'index'])->name('participants.index');
    Route::get('participants/{id}/index', [ParticipantsController::class, 'participant'])->name('participants.participant');

    Route::post('session/{id}/hide', [SessionsController::class, 'hide'])->name('session.hide');
    Route::get('sessions/index', [SessionsController::class, 'index'])->name('sessions.index');
    Route::get('sessions/{id}/index', [SessionsController::class, 'session'])->name('sessions.session');
});
Route::get('dashboard', [PagesController::class, 'index'])->name('dashboard');
Route::get('reports', [ReportsController::class, 'index'])->name('reports');

Route::get('monitoring', [MonitoringController::class, 'index'])->name('monitoring');
Route::get('/auth/callback', function (Request $request) {
    $user = Socialite::driver('okta')->user();

    $users = User::where(['email' => $user->email])->first();
    $ip = $request->getClientIp();
    $ipinfo = $request->ipinfo->all;

    if($users){
        $users->generateToken();
        if(!$users->ipAddress){
            $users->ipAddress = $ip;
            $users->timezone = $ipinfo['timezone'];
            $users->save();
        }elseif($users->ipAddress != $ip){
            $users->ipAddress = $ip;
            $users->timezone = $ipinfo['timezone'];
            $users->save();
        }
        Auth::login($users);
        return redirect('dashboard');
    }else{
        $newUser = User::create([
            'name' => $user->user['name'],
            'dtID' => $user->user['sub'],
            'password' => Str::random(60),
            'email' => $user->email,
            'first' => $user->user['given_name'],
            'last' => $user->user['family_name'],
            'avatar' => $user->avatar,
            'timezone' => $ipinfo['timezone'],
            'ipAddress' => $ip,
        ]);
        $newUser->generateToken();
        Auth::login($newUser);
        return redirect('dashboard');
    }
    // $user->token
});

/**
 * Socialite login using IETF Datatracker service
 */
Route::get('/auth/redirect/{provider}', [SocialiteLoginController::class, 'redirect']);

require __DIR__.'/auth.php';
