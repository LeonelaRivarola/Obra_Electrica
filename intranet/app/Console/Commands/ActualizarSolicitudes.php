<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tecnica\ObrasElectricas\Solicitud;
use App\Models\Tecnica\ObrasElectricas\SolicitudEstado;
use Illuminate\Support\Facades\DB;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LogLevel;

class ActualizarSolicitudes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'solicitudes:actualizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar solicitudes que superan los 15 días de su último estado presupuestado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logger = new Logger('actualizar_solicitudes'); // Crear un logger específico para esta tarea
        $logger->pushHandler(new StreamHandler(storage_path('logs/LogActualizarSolicitudes.log'), LogLevel::INFO));

        try {
            DB::connection('ALUM')->beginTransaction();

            $solicitudesIds = DB::connection('ALUM')->table('ALUM.dbo.SOLICITUD_ESTADO as se')
                ->select('se.SES_SOLICITUD_ID')
                ->whereRaw('se.SES_FECHA = (SELECT TOP 1 SES_FECHA
                                                FROM ALUM.dbo.SOLICITUD_ESTADO
                                                WHERE SES_SOLICITUD_ID = se.SES_SOLICITUD_ID
                                                ORDER BY SES_FECHA DESC)')
                ->where('se.SES_ESTADO_ID', 6)
                ->whereRaw('DATEDIFF(day, se.SES_FECHA, GETDATE()) > 15')
                ->groupBy('se.SES_SOLICITUD_ID')
                ->get()
                ->pluck('SES_SOLICITUD_ID');

            if ($solicitudesIds->isEmpty()) {
                $logger->info('No hay solicitudes para actualizar.');
                return;
            }

            $solicitudes = Solicitud::whereIn('SOE_ID', $solicitudesIds)->get();

            foreach ($solicitudes as $solicitud) {
                $logger->info('Actualizando solicitud con ID: ' . $solicitud->SOE_ID);
                SolicitudEstado::create([
                    'SES_SOLICITUD_ID' => $solicitud->SOE_ID,
                    'SES_ESTADO_ID' => 2,
                    'SES_USUARIO' => 'sistemas',
                    'SES_FECHA' => now(),
                ]);
            }

            DB::connection('ALUM')->commit();
            $logger->info('Proceso de actualización completado.');
        } catch (\Exception $e) {
            DB::connection('ALUM')->rollBack();
            $logger->error('Error en el proceso de actualización: ' . $e->getMessage());
        }
    }
}
