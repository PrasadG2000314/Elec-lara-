<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\admin\PostsController;
use App\Http\Controllers\admin\TestimonialController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Middleware\TimeRestrictedAccess;
use App\Http\Middleware\ROLE_SUPER_ADMIN;
use App\Http\Middleware\ROLE_ADMIN;
use App\Http\Middleware\ROLE_USER;
use App\Http\Middleware\ROLE_GUEST;
use App\Http\Middleware\ROLE_SUPER_USER;
use App\Models\slider;
use App\Models\Testimonial;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(TimeRestrictedAccess::class);
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
