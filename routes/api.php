<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('guests', [GuestController::class, 'index'])->name('guests.index');
Route::get('guests/{guest}', [GuestController::class, 'show'])->name('guests.show');
Route::post('guests', [GuestController::class, 'store'])->name('guests.store');
Route::match(['put', 'patch'],'guests/{guest}', [GuestController::class, 'update'])->name('guests.update');
Route::delete('guests/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');

Route::get('rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::post('rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::match(['put', 'patch'],'rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
Route::delete('rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
Route::post('reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::match(['put', 'patch'],'reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
