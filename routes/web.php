<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::view('/users/admin/home', 'users.admin.home')->name('admin.home');
    Route::view('/users/teachers/home', 'users.teachers.home')->name('teachers.home');
    Route::view('/users/students/home', 'users.students.home')->name('students.home');

    // Admin additional pages
    Route::view('/users/admin/subjects', 'users.admin.subjects')->name('admin.subjects');
    Route::view('/users/admin/sections', 'users.admin.sections')->name('admin.sections');
    Route::view('/users/admin/rooms', 'users.admin.rooms')->name('admin.rooms');
    Route::view('/users/admin/schedules', 'users.admin.schedules')->name('admin.schedules');
    Route::view('/users/admin/students', 'users.admin.students')->name('admin.students');
    Route::view('/users/admin/teachers', 'users.admin.teachers')->name('admin.teachers');

    // Student additional pages
    Route::view('/users/students/schedules', 'users.students.schedules')->name('students.schedules');

    // Teacher additional pages
    Route::view('/users/teachers/schedules', 'users.teachers.schedules')->name('teachers.schedules');
});

require __DIR__ . '/auth.php';
