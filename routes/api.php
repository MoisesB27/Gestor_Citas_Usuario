<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PuntoGobController;
use App\Http\Controllers\SoporteController;
use App\Http\Controllers\TestimonialController;

// Ruta pública para login
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/tickets/create', [SoporteController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [SoporteController::class, 'store'])->name('tickets.store');
Route::apiResource('punto-gobs', PuntoGobController::class)->only(['index', 'store']);

// Listado de controladores del sistema
$controllers = [
    'users'                   => 'UserController',
    'user-profiles'           => 'UserProfileController',
    'user-preferences'        => 'UserPreferenceController',
    'user-documents'          => 'UserDocumentController',
    'user-notifications'      => 'UserNotificationController',
    'user-activities'         => 'UserActivityController',
    'sessions'                => 'SessionController',
    'password-resets'         => 'PasswordResetController',
    'government-dependencies' => 'GovernmentDependencyController',
    'tramites'                => 'TramiteController',
    'services'                => 'ServiceController',
    'appointments'            => 'AppointmentController',
    'History'                 => 'HistoryController',
    'servicios'               => 'ServicioController',
    'appointment-access-logs' => 'AppointmentAccessLogController',
];

// RUTAS PÚBLICAS: Esta ruta habilita el poder hacer get, show;

Route::get('/testimonios', [TestimonialController::class, 'index', 'store', 'show']); // Ruta pública para testimonios

foreach ($controllers as $routeName => $controller) {
    $controllerClass = "App\\Http\\Controllers\\Api\\{$controller}";

    if (class_exists($controllerClass)) {
        Route::resource($routeName, $controllerClass)->only(['index', 'show']);
    } else {
        logger("Controlador no encontrado: {$controllerClass}");
    }
}


// RUTAS PRIVADAS: Esta ruta habilita el poder hacer put, delete, post;
Route::middleware('auth:sanctum')->group(function () use ($controllers) {
    foreach ($controllers as $routeName => $controller) {
        $controllerClass = "App\\Http\\Controllers\\Api\\{$controller}";

        if (class_exists($controllerClass)) {
            Route::resource($routeName, $controllerClass)->only(['store', 'update', 'destroy']);
        }
    }
});
