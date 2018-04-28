<?php

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
Auth::routes();
Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware'=>['web','auth']], function(){
Route::get('/home',function(){
	if (Auth::user()->role==0) {
		return view('home');
	}
	else
	{
		$users['users']=\App\User::all();
		return view('adminhome',$users);
	}
})->name('home');

});






Route::post('/home/profile/{id}', 'UserProfileController@index');
Route::post('/home/profile/{id}', 'UserProfileController@update');