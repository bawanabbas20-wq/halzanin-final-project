<?php

use App\Models\Application;
use App\Models\Appointment;
use App\Models\StatusLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Appointment::whereDoesntHave('application')
            ->whereNotNull('citizen_id')
            ->get()
            ->each(function (Appointment $appt) {
                do {
                    $code = 'TRK-' . strtoupper(Str::random(8));
                } while (Application::where('tracking_code', $code)->exists());

                $application = Application::create([
                    'user_id'        => $appt->citizen_id,
                    'appointment_id' => $appt->id,
                    'tracking_code'  => $code,
                    'current_status' => 'submitted',
                    'submitted_at'   => $appt->created_at,
                ]);

                StatusLog::create([
                    'application_id' => $application->id,
                    'status'         => 'submitted',
                    'changed_by'     => $appt->citizen_id,
                    'notes'          => 'Application record backfilled for existing appointment.',
                ]);
            });
    }

    public function down(): void
    {
        // No rollback — removing backfilled records would be destructive
    }
};
