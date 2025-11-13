<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Enums\ProviderType;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = User::with('currentAccount')->find(Auth::user()->id);

        if ($user->currentAccount->isProvider()) {

            $provider = Provider::find($user->currentAccount->accountable_id);

            return match ($provider->type) {
                ProviderType::VEHICLE_INSPECTION_CENTER => redirect()->route('dashboard.vehicle-inspection-center'),
                ProviderType::SPARE_PARTS_SUPPLIER => redirect()->route('dashboard.spare-parts-supplier'),
                ProviderType::AUTO_REPAIR_WORKSHOP => redirect()->route('dashboard.auto-repair-workshop'),
                default => abort(404, 'Provider type not found'),
            };
        }

        if ($user->vehicles()->count() === 0) {
            return redirect()->route('vehicles.create');
        }

        return redirect()->route('dashboard.vehicle-owner');
    }
}