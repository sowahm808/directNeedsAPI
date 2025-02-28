<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Example of scheduled task: Automatic File Closure
        $schedule->call(function () {
            \App\Models\Application::where('status', 'approved')
                ->where('updated_at', '<=', now()->subDays(45))
                ->update(['status' => 'closed']);
        })->daily();

        // Example of scheduled task: 14-Day Follow-Up Email
        $schedule->call(function () {
            $applications = \App\Models\Application::where('status', 'approved')
                ->whereDate('approval_date', '=', now()->subDays(14))
                ->get();

            foreach ($applications as $application) {
                \Illuminate\Support\Facades\Mail::to($application->applicant->email)
                    ->send(new \App\Mail\StateResourcesMail($application));
            }
        })->daily();

        // Example of scheduled task: 30-Day Follow-Up Email
        $schedule->call(function () {
            $applications = \App\Models\Application::where('status', 'approved')
                ->whereDate('approval_date', '=', now()->subDays(30))
                ->get();

            foreach ($applications as $application) {
                \Illuminate\Support\Facades\Mail::to($application->applicant->email)
                    ->send(new \App\Mail\PartnershipsLetterMail($application));
            }
        })->daily();
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
