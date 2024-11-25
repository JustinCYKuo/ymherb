<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 創建新使用者的邏輯 App\Actions\Fortify\CreateNewUser
        Fortify::createUsersUsing(CreateNewUser::class);
        // 更新使用者資料的邏輯 App\Actions\Fortify\UpdateUserProfileInformation
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        // 更新使用者密碼的邏輯 App\Actions\Fortify\UpdateUserPassword
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        // 重設使用者密碼的邏輯 App\Actions\Fortify\ResetUserPassword
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Fortify::authenticateUsing(function ($request) {
        //     // 登入認證邏輯
        //     $user = User::where('email', $request->email)->first();
        //     if ($user && Hash::check($request->password, $user->password)) {
        //         // 登錄記錄到log檔
        //         // \Log::info('Custom authentication: User logged in: ' . $user->email);

        //         // 紀錄登錄時間或(登入次數
        //         $user->last_login_at = now();
        //         $user->save();

        //         return $user;
        //     }
        // });

        // 限制每分鐘最多5次登入嘗試
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        // 限制每分鐘最多5次二階段驗證嘗試
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
