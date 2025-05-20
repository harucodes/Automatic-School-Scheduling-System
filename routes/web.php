<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AdminSubjectController;
use App\Http\Controllers\AdminSectionController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\AdminTeacherController;
use App\Http\Controllers\AdminScheduleController;
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
    // Admin manage rooms
    Route::get('/users/admin/rooms', [AdminRoomController::class, 'index'])
        ->name('admin.rooms')
        ->middleware('auth');
    Route::post('/users/admin/rooms', [AdminRoomController::class, 'store'])
        ->name('admin.rooms.store')
        ->middleware('auth');
    Route::put('/users/admin/rooms/{room}', [AdminRoomController::class, 'update'])
        ->name('admin.rooms.update')
        ->middleware('auth');
    Route::delete('/users/admin/rooms/{room}', [AdminRoomController::class, 'destroy'])
        ->name('admin.rooms.destroy')
        ->middleware('auth');

    //admin manage teachers
    Route::get('/users/admin/teachers', [AdminTeacherController::class, 'index'])
        ->name('admin.teachers')
        ->middleware('auth');
    Route::put('/users/admin/teachers/{teacher}', [AdminTeacherController::class, 'update'])
        ->name('admin.teachers.update')
        ->middleware('auth');
    Route::delete('/users/admin/teachers/{teacher}', [AdminTeacherController::class, 'destroy'])
        ->name('admin.teachers.destroy')
        ->middleware('auth');
    //admin manage teacher schedule
    Route::get('/users/admin/schedules', [AdminScheduleController::class, 'index'])
        ->name('admin.schedules')
        ->middleware('auth');
    Route::post('/users/admin/schedules', [AdminScheduleController::class, 'store'])
        ->name('admin.schedules.store')
        ->middleware('auth');
    Route::put('/users/admin/schedules/{schedule}', [AdminScheduleController::class, 'update'])
        ->name('admin.schedules.update')
        ->middleware('auth');
    Route::delete('/users/admin/schedules/{schedule}', [AdminScheduleController::class, 'destroy'])
        ->name('admin.schedules.destroy')
        ->middleware('auth');

    //admin manage students schedule

    Route::view('/users/admin/students', 'users.admin.students')->name('admin.students');




    // Student additional pages
    Route::view('/users/students/schedules', 'users.students.schedules')->name('students.schedules');

    // Teacher additional pages
    Route::view('/users/teachers/schedules', 'users.teachers.schedules')->name('teachers.schedules');
});

require __DIR__ . '/auth.php';
