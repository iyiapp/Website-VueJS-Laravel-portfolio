<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');  

Route::group(['prefix' => 'tr', 'namespace' => 'Turkish', 'middleware' => 'locale:tr'], function() {
    Route::get('/', [WelcomeController::class, 'welcome'])->name('trHome');
});

Route::group(['prefix' => 'en', 'namespace' => 'English', 'middleware' => 'locale:en'], function() {
    Route::get('/', [WelcomeController::class, 'welcome'])->name('enHome');
});

Route::get('/', function() {
    return redirect()->route('trHome');
});


Route::post('/contact', ContactController::class)->name('contact');
 
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('/skills', SkillController::class);
    Route::resource('/projects', ProjectController::class);
});
require __DIR__.'/auth.php';
