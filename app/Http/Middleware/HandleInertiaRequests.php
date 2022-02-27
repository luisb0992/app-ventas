<?php

namespace App\Http\Middleware;

use App\Utils\AppFilePath;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $fullname = $request->user() ? $request->user()->fullname : null;

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => collect($request->user())->put('fullname', $fullname),
            ],
            'path' => [
                'brandLogo' => AppFilePath::brandLogos(),
                'saleVoucher' => AppFilePath::saleVouchers(),
            ],
            'flash' => [
                'failed' => $request->session()->get('failed'),
            ],
            'appName' => config('app.name'),
        ]);
    }
}
