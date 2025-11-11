<?php

namespace App\Livewire;

use App\Enums\ProviderType;
use App\Models\Account;
use App\Models\Provider;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AccountSwitcher extends Component
{
    public array $accounts = [];

    public ?string $currentAccountId = null;

    public function mount(): void
    {
        $user = Auth::user();

        $this->currentAccountId = $user->current_account_id;

        $this->accounts = $user->accounts()
            ->with('accountable')
            ->get()
            ->map(function (Account $account) {
                $label = $this->makeAccountLabel($account);
                $icon = $this->getAccountIcon($account);
                $color = $this->getAccountColor($account);

                return [
                    'id' => $account->id,
                    'label' => $label,
                    'icon' => $icon,
                    'color' => $color,
                ];
            })
            ->all();
    }

    public function switch(string $accountId): void
    {
        $user = Auth::user();

        $ownsAccount = $user->accounts()->whereKey($accountId)->exists();

        if (! $ownsAccount) {
            abort(403);
        }

        $user->current_account_id = $accountId;
        $user->save();

        $this->currentAccountId = $accountId;

        $this->redirect(route('dashboard'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.account-switcher');
    }

    private function makeAccountLabel(Account $account): string
    {
        $accountable = $account->accountable;

        if (method_exists($accountable, 'getAttribute') && $account->isProvider()) {
            $name = (string) $accountable->getAttribute('name');
            return $name !== '' ? $name : __('Provider');
        }

        if (method_exists($accountable, 'getAttribute') && $account->isUser()) {
            $name = (string) $accountable->getAttribute('name');
            return $name !== '' ? $name.' ('.__('Personal').')' : __('Personal');
        }

        return __('Account');
    }

    private function getAccountIcon(Account $account): string
    {
        if ($account->isUser()) {
            return 'phosphor-user-circle';
        }

        if ($account->isProvider()) {
            $provider = $account->accountable;
            
            if ($provider instanceof Provider) {
                return match ($provider->type) {
                    ProviderType::SPARE_PARTS_SUPPLIER => 'phosphor-package',
                    ProviderType::AUTO_REPAIR_WORKSHOP => 'phosphor-wrench',
                    ProviderType::VEHICLE_INSPECTION_CENTER => 'phosphor-clipboard-check',
                    default => 'phosphor-storefront',
                };
            }
        }

        return 'phosphor-storefront';
    }

    private function getAccountColor(Account $account): string
    {
        if ($account->isUser()) {
            return 'text-blue-500';
        }

        if ($account->isProvider()) {
            $provider = $account->accountable;
            
            if ($provider instanceof Provider) {
                return match ($provider->type) {
                    ProviderType::SPARE_PARTS_SUPPLIER => 'text-green-500',
                    ProviderType::AUTO_REPAIR_WORKSHOP => 'text-orange-500',
                    ProviderType::VEHICLE_INSPECTION_CENTER => 'text-violet-500',
                    default => 'text-gray-500',
                };
            }
        }

        return 'text-gray-500';
    }
}


