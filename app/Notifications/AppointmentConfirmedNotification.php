<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentConfirmedNotification extends Notification
{
    use Queueable;

    public function __construct(protected Appointment $appointment)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toArray(mixed $notifiable): array
    {
        $appointment = $this->appointment->refresh();

        return [
            'title' => 'Appointment confirmed',
            'body' => sprintf(
                'Your appointment %s has been confirmed for %s.',
                $appointment->number,
                optional($appointment->scheduled_at)?->timezone(config('app.timezone'))->format('M d, Y h:i A') ?? 'the scheduled time'
            ),
            'reference' => [
                'appointment_id' => $appointment->id,
                'appointment_number' => $appointment->number,
            ],
            'action_url' => route('dashboard'),
            'icon' => 'phosphor-calendar-check',
        ];
    }
}

