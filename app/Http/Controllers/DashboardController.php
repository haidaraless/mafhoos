<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Provider;
use Illuminate\Support\Facades\Auth;
use App\Enums\AccountType;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = User::with('currentAccount')->find(Auth::user()->id);

        if ($user->currentAccount->type === AccountType::PROVIDER) {
            $provider = Provider::find($user->currentAccount->provider_id);
        }

        return redirect()->route('dashboard.vehicle-owner');
    }
}
