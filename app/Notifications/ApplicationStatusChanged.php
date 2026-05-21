<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusChanged extends Notification
{
    use Queueable;

    public function __construct(protected Application $application) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];

        if (in_array($this->application->current_status, ['approved', 'rejected'], true)
            && filled($notifiable->email)) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $status = ucfirst(str_replace('_', ' ', $this->application->current_status));

        return (new MailMessage)
            ->subject("Your application has been {$status} — {$this->application->tracking_code}")
            ->view('emails.status-updated', ['application' => $this->application]);
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
