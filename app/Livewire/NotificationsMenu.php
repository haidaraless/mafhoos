<?php

namespace App\Livewire;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsMenu extends Component
{
    public function markAllAsRead(): void
    {
        $user = Auth::user();

        if (! $user) {
            return;
        }

        $user->unreadNotifications->markAsRead();
    }

    public function markAsRead(string $notificationId): void
    {
        $notification = $this->findNotification($notificationId);

        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function openNotification(string $notificationId)
    {
        $notification = $this->findNotification($notificationId);

        if (! $notification) {
            return;
        }

        $notification->markAsRead();

        $url = $notification->data['action_url'] ?? null;

        if ($url) {
            return $this->redirect($url, navigate: true);
        }
    }

    public function getNotificationsProperty(): Collection
    {
        $user = Auth::user();

        if (! $user) {
            return collect();
        }

        return $user->notifications()
            ->latest()
            ->limit(10)
            ->get();
    }

    public function getUnreadCountProperty(): int
    {
        return Auth::user()?->unreadNotifications()?->count() ?? 0;
    }

    public function render()
    {
        return view('livewire.notifications-menu');
    }

    private function findNotification(string $notificationId): ?DatabaseNotification
    {
        $user = Auth::user();

        if (! $user) {
            return null;
        }

        return $user->notifications()->find($notificationId);
    }
}

