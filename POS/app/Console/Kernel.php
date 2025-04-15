<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Los comandos de Artisan que provee tu aplicación.
     *
     * @var array
     */
    protected $commands = [
        // \App\Console\Commands\TuComando::class,
    ];

    /**
     * Define el cronograma de comandos de la aplicación.
     */
    protected function schedule(Schedule $schedule)
    {
        // Ejemplo: $schedule->command('inspire')->hourly();
    }

    /**
     * Registra los comandos para la aplicación.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
