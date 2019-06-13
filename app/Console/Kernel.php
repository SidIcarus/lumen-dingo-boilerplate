<?php declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\GenerateDocumentationCommand;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        GenerateDocumentationCommand::class,
    ];


    protected function schedule(Schedule $schedule): void
    {
        //
    }
}
