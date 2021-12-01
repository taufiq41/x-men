<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\HeroSkillController;
use App\Http\Controllers\CombinationController;

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
    return view('welcome');
});

Auth::routes();
//Route::get('/',[LoginController::class,'showLoginForm'])->name('/');
// Route::get('/login',[LoginController::class,'showLoginForm'])->name('login');
// Route::post('/login',[LoginController::class,'login'])->name('login');
// Route::get('/logout',[LoginController::class,'logout'])->name('logout');

Route::get('/home',[HomeController::class,'index'])->name('home');

Route::group(['middleware' => 'auth'],function(){
    Route::get('/hero',[HeroController::class,'index'])->name('hero.index');
    Route::get('/hero/show/{id}',[HeroController::class,'show'])->name('hero.show');
    Route::post('/hero/store',[HeroController::class,'store'])->name('hero.store');
    Route::get('/hero/edit/{id}',[HeroController::class,'edit'])->name('hero.edit');
    Route::put('/hero/update/{id}',[HeroController::class,'update'])->name('hero.update');
    Route::post('/hero/datatable',[HeroController::class,'datatable'])->name('hero.datatable');
    Route::delete('/hero/destroy/{id}',[HeroController::class,'destroy'])->name('hero.destroy');

    Route::get('/skill',[SkillController::class,'index'])->name('skill.index');
    Route::get('/skill/show/{id}',[SkillController::class,'show'])->name('skill.show');
    Route::post('/skill/store',[SkillController::class,'store'])->name('skill.store');
    Route::get('/skill/edit/{id}',[SkillController::class,'edit'])->name('skill.edit');
    Route::put('/skill/update/{id}',[SkillController::class,'update'])->name('skill.update');
    Route::post('/skill/datatable',[SkillController::class,'datatable'])->name('skill.datatable');
    Route::delete('/skill/destroy/{id}',[SkillController::class,'destroy'])->name('skill.destroy');

    Route::post('/heroskill/store_skill/{hero_id}',[HeroSkillController::class,'store_skill'])->name('heroskill.store_skill');
    Route::delete('/heroskill/destroy_skill/{id}/{hero_id}',[HeroSkillController::class,'destroy_skill'])->name('heroskill.destroy_skill');
    
    Route::post('/heroskill/store_hero/{skill_id}',[HeroSkillController::class,'store_hero'])->name('heroskill.store_hero');
    Route::delete('/heroskill/destroy_hero/{id}/{skill_id}',[HeroSkillController::class,'destroy_hero'])->name('heroskill.destroy_hero');

    Route::get('/combination',[CombinationController::class,'index'])->name('combination.index');
    Route::post('/combination/datatable',[CombinationController::class,'datatable'])->name('combination.datatable');
});

