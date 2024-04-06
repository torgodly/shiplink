<?php

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $customers = \App\Models\User::where('type', 'user')->count();
    $packages = Package::all();

    $totalRating = $packages->where('rating', '!=', 0)->sum('rating');
    $totalCount = $packages->where('rating', '!=', 0)->count();
    $avgRating = $totalCount > 0 ? round($totalRating / $totalCount, 1) : 0;

    $completedPackages = $packages->where('status', 'Delivered')->count();
    return view('welcome', compact('customers', 'avgRating', 'completedPackages'));
})->name('home');

//price calculator
Route::get('/calculator', function () {
    return view('calculator');
})->name('calculator');

//contact us store image
Route::post('/contact/store', [\App\Http\Controllers\MessageController::class, 'store'])->name('contact.store');


//change language route and logic
Route::post('/language-switch', function (Request $request) {

//Get the language from the form
    $language = $request->input(key: 'language');

//Store the language in the session
    session(key: ['language' => $language]);

    return redirect()->back()->with(key: ['language_switched' => $language]);
})->name('language.switch');
