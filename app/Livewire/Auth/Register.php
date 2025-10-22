<?php

namespace App\Livewire\Auth;

use App\Enums\AccountType;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        $this->createAccount($user);

        Auth::login($user);

        $this->redirect(route('vehicles.create', absolute: false), navigate: true);
    }

    private function createAccount(User $user): void
    {
        $account = $user->accounts()->create([
            'user_id' => $user->id,
            'type' => AccountType::VEHICLE_OWNER,
        ]);

        $user->current_account_id = $account->id;
        $user->save();
    }
}
