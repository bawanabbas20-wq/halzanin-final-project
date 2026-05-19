<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationStatusChanged extends Notification
{
    use Queueable;

    public function __construct(protected Application $application) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'tracking_code'  => $this->application->tracking_code,
            'new_status'     => $this->application->current_status,
            'applicant_name' => $this->application->appointment?->full_name
                                ?? $this->application->user?->name,
        ];
    }
}
