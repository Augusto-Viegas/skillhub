<?php
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

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


Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function(){
    Route::get('/become-instructor', [UserController::class, 'becomeInstructor'])->name('becomeInstructor');
});


Route::middleware(['auth', 'verified'])->prefix('courses')->name('courses.')->group(function () {
    Route::get('/home', [CourseController::class, 'index'])->name('index'); //mostra todos os cursos do site na home, logado ou não logado.
    
    //Rotas exclusivas para instrutores
    Route::middleware([EnsureIsInstructor::class])->group(function(){
        Route::get('/my-courses', [CourseController::class, 'MyCourses'])->name('myCourses'); //mostra somente os cursos do instrutor.
        Route::get('/create', [CourseController::class, 'create'])->name('create'); //form para criar o curso
        Route::post('/store', [CourseController::class, 'store'])->name('store'); //rota para salvar o curso no bd
    });
    
    Route::get('/{course}', [CourseController::class, 'show'])->name('show'); //rota que mostra um curso por id
    Route::get('edit/{course}', [CourseController::class, 'edit'])->name('edit'); //form para editar um curso
    Route::put('update/{course}', [CourseController::class, 'update'])->name('update'); //rota para atualizar um curso
    Route::delete('delete/{course}', [CourseController::class, 'destroy'])->name('destroy'); //rota para deletar um curso
});


