<?php

namespace App\Livewire;

use App\Models\Account;
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

                return [
                    'id' => $account->id,
                    'label' => $label,
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
}


