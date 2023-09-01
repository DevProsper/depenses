<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\DepensesComponent;
use App\Http\Livewire\RecettesComponent;
use App\Http\Livewire\UtilisateurComponent;
use App\Http\Livewire\CategoriesDepensesComponent;
use App\Http\Livewire\CategoriesRecettesComponent;
use App\Http\Livewire\GroupeCategoriesDepensesComponent;
use App\Http\Livewire\GroupeCategoriesRecettesComponent;

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

Route::group(
    [
        "middleware" => ["auth", "auth.administration"],
        'as' => 'administration.'
    ],
    function () {

        Route::group([
            "prefix" => "groupedepenses",
            'as' => 'groupedepenses.'
        ], function () {
            Route::get('/groupedepenses', GroupeCategoriesDepensesComponent::class)->name('groupedepenses.index');
        });

        Route::group(
            [
                "prefix" => "grouperecettes",
                'as' => 'grouperecettes.'
            ],
            function () {
                Route::get('/grouperecettes', GroupeCategoriesRecettesComponent::class)->name('grouperecettes.index');
            }
        );

        Route::group(
            [
                "prefix" => "categoriedepenses",
                'as' => 'categoriedepenses.'
            ],
            function () {
                Route::get('/categoriedepenses', CategoriesDepensesComponent::class)->name('categoriedepenses.index');
            }
        );

        Route::group(
            [
                "prefix" => "categorierecettes",
                'as' => 'categorierecettes.'
            ],
            function () {
                Route::get('/categorierecettes', CategoriesRecettesComponent::class)->name('categorierecettes.index');
            }
        );
    }
);

Route::group(
    [
        "middleware" => ["auth", "auth.utilisateurs"],
        'as' => 'users.'
    ],
    function () {
        Route::get('/utilisateurs', UtilisateurComponent::class)->name('utilisateurs.index');
    }
);


Route::group(
    [
        "middleware" => ["auth", "auth.recettes"],
        'as' => 'recettes.'
    ],
    function () {
        Route::get('/recettes', RecettesComponent::class)->name('recettes.index');
    }
);

Route::group(
    [
        "middleware" => ["auth", "auth.depenses"],
        'as' => 'depenses.'
    ],
    function () {
        Route::get('/depenses', DepensesComponent::class)->name('depenses.index');
    }
);
