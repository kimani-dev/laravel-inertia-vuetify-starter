<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'role' => $request->user()->getRoleNames(),
                    'profile_photo_path' => $request->user()->profile_photo_path,
                    'profile_photo_url' => $request->user()->profile_photo_url,
                    'two_factor_enabled' => ! is_null($request->user()->two_factor_secret),
                    'permissions' => $request->user()->getAllPermissions()->pluck('name'),
                    'notifications' => $request->user()->notifications,
                ] : null,
            ],
            'flash' => [
                'message' => $request->session()->get('message'),
                'type' => $request->session()->get('type'),
            ],
        ]);
    }
}
