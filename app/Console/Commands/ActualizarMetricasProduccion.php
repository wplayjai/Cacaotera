<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Produccion;

class ActualizarMetricasProduccion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'produccion:actualizar-metricas {--id= : ID específico de producción}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza las métricas de rendimiento de producciones completadas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🔄 Actualizando métricas de rendimiento...');
        
        if ($this->option('id')) {
            // Actualizar producción específica
            $produccion = Produccion::find($this->option('id'));
            if (!$produccion) {
                $this->error("❌ Producción con ID {$this->option('id')} no encontrada");
                return 1;
            }
            
            $this->actualizarProduccion($produccion);
            $this->info("✅ Métricas actualizadas para producción ID: {$produccion->id}");
        } else {
            // Actualizar todas las producciones completadas
            $producciones = Produccion::where('estado', 'completado')
                                    ->whereHas('recolecciones')
                                    ->get();
            
            if ($producciones->isEmpty()) {
                $this->info('ℹ️ No hay producciones completadas con recolecciones para actualizar');
                return 0;
            }
            
            $this->info("📊 Encontradas {$producciones->count()} producciones completadas");
            
            $bar = $this->output->createProgressBar($producciones->count());
            $bar->start();
            
            foreach ($producciones as $produccion) {
                $this->actualizarProduccion($produccion);
                $bar->advance();
            }
            
            $bar->finish();
            $this->newLine();
            $this->info("✅ Métricas actualizadas para {$producciones->count()} producciones");
        }
        
        return 0;
    }
    
    private function actualizarProduccion($produccion)
    {
        $totalRecolectado = $produccion->total_recolectado;
        
        if ($totalRecolectado > 0) {
            $produccion->actualizarMetricasRendimiento();
            
            $this->line("  📈 Producción ID {$produccion->id}:");
            $this->line("     - Total recolectado: {$totalRecolectado} kg");
            $this->line("     - Estimación: {$produccion->estimacion_produccion} kg");
            $this->line("     - Rendimiento: " . number_format($produccion->rendimiento_real, 2) . "%");
            $this->line("     - Desviación: " . number_format($produccion->desviacion_estimacion, 2) . " kg");
        } else {
            $this->warn("  ⚠️ Producción ID {$produccion->id} no tiene recolecciones registradas");
        }
    }
}
