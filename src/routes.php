<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Kai\L5Swagger\Http\Controllers\SwaggerController;

if (Config::get('swagger.enable', true)) {
    Route::prefix(config('swagger.path', '/docs'))->group(static function() {
        Route::get('', [SwaggerController::class, 'api']);
        Route::get('content', [SwaggerController::class, 'documentation']);
    });
}
