<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Ruta pública para login
Route::post('/login', [LoginController::class, 'login'])->name('login');

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
    'servicios'               => 'ServicioController',
    'appointment-access-logs' => 'AppointmentAccessLogController',
];

// RUTAS PÚBLICAS: Esta ruta habilita el poder hacer get, show;
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
