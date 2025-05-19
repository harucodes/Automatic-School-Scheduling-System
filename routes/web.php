<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AdminSubjectController;
use App\Http\Controllers\AdminSectionController;
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

    // Admin manage subjects
    Route::get('/users/admin/subjects', [AdminSubjectController::class, 'index'])->name('admin.subjects');
    Route::post('/users/admin/subjects', [AdminSubjectController::class, 'store'])
        ->name('admin.subjects.store')
        ->middleware('auth');
    Route::put('/users/admin/subjects/{subject}', [AdminSubjectController::class, 'update'])
        ->name('admin.subjects.update')
        ->middleware('auth');
    Route::delete('/users/admin/subjects/{subject}', [AdminSubjectController::class, 'destroy'])
        ->name('admin.subjects.destroy')
        ->middleware('auth');
    // Admin manage sections
    Route::get('/users/admin/sections', [AdminSectionController::class, 'index'])
        ->name('admin.sections')
        ->middleware('auth');
    Route::post('/users/admin/sections', [AdminSectionController::class, 'store'])
        ->name('admin.sections.store')
        ->middleware('auth');
    Route::put('/users/admin/sections/{section}', [AdminSectionController::class, 'update'])
        ->name('admin.sections.update')
        ->middleware('auth');
    Route::delete('/users/admin/sections/{section}', [AdminSectionController::class, 'destroy'])
        ->name('admin.sections.destroy')
        ->middleware('auth');


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
