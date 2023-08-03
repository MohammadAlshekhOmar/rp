<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\User;

class HomeController extends Controller
{
    public function cp()
    {
        $usersCount = User::count();
        $usersTrashedCount = User::onlyTrashed()->count();
        $providersCount = Provider::count();
        $providersTrashedCount = Provider::onlyTrashed()->count();

        return view('Admin.SubViews.cp', [
            'usersCount' => $usersCount,
            'usersTrashedCount' => $usersTrashedCount,
            'providersCount' => $providersCount,
            'providersTrashedCount' => $providersTrashedCount,
        ]);
    }
}
