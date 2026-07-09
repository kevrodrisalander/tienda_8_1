<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Monolog\Formatter\LineFormatter;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Tu configuración de Guzzle aquí
    }

    public function boot()
    {
        // Tu macro de Collection aquí

        // Configuración de formato de logs
        $monolog = Log::getLogger();

        foreach ($monolog->getHandlers() as $handler) {
            $formatter = new LineFormatter(
                "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
                "Y-m-d H:i:s", // formato de fecha y hora
                true,
                true
            );
            $handler->setFormatter($formatter);
        }
    }
}