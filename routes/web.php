<?php
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';

use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureIsInstructor;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    Route::get('/become-instructor', [UserController::class, 'becomeInstructor'])->name('becomeInstructor');
});


Route::middleware(['auth', 'verified'])->prefix('courses')->name('courses.')->group(function () {
    Route::middleware([EnsureIsInstructor::class])->group(function () {
        Route::get('/my-courses', [CourseController::class, 'MyCourses'])->name('myCourses'); 
        Route::get('/create', [CourseController::class, 'create'])->name('create'); 
        Route::post('/store', [CourseController::class, 'store'])->name('store'); 
        Route::get('edit/{course}', [CourseController::class, 'edit'])->name('edit'); 
        Route::delete('delete/{course}', [CourseController::class, 'destroy'])->name('destroy'); 
        Route::put('update/{course}', [CourseController::class, 'update'])->name('update'); 
    });
    Route::get('/home', [CourseController::class, 'index'])->name('index'); //mostra todos os cursos do site na home, logado ou não logado.
    Route::get('/{course}', [CourseController::class, 'show'])->name('show'); //rota que mostra um curso por id
});


