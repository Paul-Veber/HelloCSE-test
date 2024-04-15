<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix("api/profile")->group(function () {
    Route::get("/all", [ProfileController::class, "GetAllProfiles"])
        ->name("api.profile.all");


    Route::middleware('auth')->group(function () {
        Route::post("/store", [ProfileController::class, "store"])
            ->name("api.profile.store");
        Route::patch("/update", [ProfileController::class, "update"])
            ->name("api.profile.update");
        Route::delete("/delete/{profile}", [ProfileController::class, "destroy"])
            ->name("api.profile.delete");
    });
});
