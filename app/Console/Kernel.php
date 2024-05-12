<?php

namespace App\Console;

use App\Enums\ReservationStatus;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $now = Carbon::now('Europe/Warsaw');

            $reservations = \App\Models\Reservation::where('end_time', '<=', $now)
                ->where('status', '=', ReservationStatus::SCHEDULED)
                ->get();

            foreach ($reservations as $reservation) {
                $reservation->update(['status' => ReservationStatus::COMPLETED]);
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
