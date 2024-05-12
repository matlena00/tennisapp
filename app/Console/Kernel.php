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
            $reservations = \App\Models\Reservation::where('end_time', '<=', Carbon::now('Europe/Warsaw'))
                ->where('status', '!=', ReservationStatus::COMPLETED)
                ->get();

            foreach ($reservations as $reservation) {
                $reservation->update(['status' => 'completed']);
            }
        })->hourly();
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
