<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the chat space usage dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function espacioChat()
    {
        $user = Auth::user();
        
        // Simular datos de espacio de chat para el usuario
        $espacioTotal = 1024 * 1024 * 100; // 100 MB en bytes
        $espacioUsado = $this->calcularEspacioUsado($user->id);
        $espacioDisponible = $espacioTotal - $espacioUsado;
        $porcentajeUsado = ($espacioUsado / $espacioTotal) * 100;
        
        // Obtener estadísticas de mensajes
        $totalMensajes = $this->contarMensajes($user->id);
        $mensajesHoy = $this->contarMensajesHoy($user->id);
        $conversacionesActivas = $this->contarConversacionesActivas($user->id);
        
        return view('chat.espacio', compact(
            'espacioTotal',
            'espacioUsado',
            'espacioDisponible',
            'porcentajeUsado',
            'totalMensajes',
            'mensajesHoy',
            'conversacionesActivas'
        ));
    }

    /**
     * Calcular espacio usado por el usuario en el chat
     *
     * @param int $userId
     * @return int
     */
    private function calcularEspacioUsado($userId)
    {
        // Simulación del cálculo de espacio usado
        // En una implementación real, esto consultaría la base de datos
        $baseUsage = 1024 * 512; // 512 KB base
        $randomUsage = rand(1024 * 100, 1024 * 1024 * 20); // Entre 100 KB y 20 MB
        
        return $baseUsage + $randomUsage;
    }

    /**
     * Contar total de mensajes del usuario
     *
     * @param int $userId
     * @return int
     */
    private function contarMensajes($userId)
    {
        // Simulación - en implementación real consultaría la tabla de mensajes
        return rand(50, 1500);
    }

    /**
     * Contar mensajes de hoy del usuario
     *
     * @param int $userId
     * @return int
     */
    private function contarMensajesHoy($userId)
    {
        // Simulación - en implementación real consultaría mensajes de hoy
        return rand(0, 25);
    }

    /**
     * Contar conversaciones activas del usuario
     *
     * @param int $userId
     * @return int
     */
    private function contarConversacionesActivas($userId)
    {
        // Simulación - en implementación real consultaría conversaciones activas
        return rand(2, 15);
    }

    /**
     * Limpiar espacio de chat (eliminar mensajes antiguos)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function limpiarEspacio(Request $request)
    {
        $user = Auth::user();
        
        // Simulación de limpieza
        // En implementación real, eliminaría mensajes antiguos o archivos
        
        return response()->json([
            'success' => true,
            'message' => 'Espacio de chat limpiado exitosamente',
            'espacioLiberado' => $this->formatBytes(rand(1024 * 100, 1024 * 1024 * 5))
        ]);
    }

    /**
     * Formatear bytes a formato legible
     *
     * @param int $bytes
     * @return string
     */
    public static function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}