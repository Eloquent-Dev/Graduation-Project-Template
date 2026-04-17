<?php

namespace App\Providers;

use App\Listeners\SetEmployeeOffDutyOnLogout;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Microsoft\MicrosoftExtendSocialite;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
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
        Event::listen(
            SocialiteWasCalled::class,
            [MicrosoftExtendSocialite::class, 'handle'],
        );

        Event::listen(
            Logout::class,
            SetEmployeeOffDutyOnLogout::class
        );

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by('ip_' . $request->ip())
                ->response(function () {
                    abort(429, 'Too many login attempts.');
                });
        });

        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinutes(30, 10)->by('ip_' . $request->ip())
                ->response(function () {
                    abort(429, 'Too many registration attempts.');
                });
        });

        RateLimiter::for('oauth', function (Request $request) {
            return Limit::perMinutes(30, 10)->by('ip_' . $request->ip())
                ->response(function () {
                    abort(429, 'Too many oauth registration attempts.');
                });
        });

        RateLimiter::for('complaints', function (Request $request) {
            return [
                Limit::perMinute(3)->by('ip_' . $request->ip())
                    ->response(function () {
                        abort(429, 'Too many complaints submitted.');
                    }),
                Limit::perMinute(3)->by('user_' . $request->user()->id)
                    ->response(function () {
                        abort(429, 'Too many complaints submitted.');
                    })
            ];
        });

        RateLimiter::for('feedback', function (Request $request) {
            return Limit::perMinute(3)->by('user_' . $request->user()->id)
                ->response(function () {
                    abort(429, 'Too many complaint feedback submitted.');
                });
        });

        RateLimiter::for('password', function (Request $request) {
            return Limit::perHour(3)->by('user_' . $request->user()->id)
                ->response(function () {
                    abort(429, 'Too many password changes.');
                });
        });

        RateLimiter::for('tracking-data', function (Request $request) {
            return Limit::perMinute(15)->by('user_' . $request->user()->id)
                ->response(function () {
                    abort(429, 'Too many tracking data requests.');
                });
        });
    }
}
