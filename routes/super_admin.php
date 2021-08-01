<?php
use Illuminate\Support\Facades\Route;
Route::get('/solayman', function () {
// return view('welcome'); prefix Admin controller Admin
return 'super Admin';
});
// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth']], function () {
// volunteer
Route::get('/volunteer', 'volunteer_controller@show_show_volunteer');

Route::get('/get-all-volunteer-api', 'volunteer_controller@get_all_volunteer')->name('all_volunteer.list');
Route::delete('/delete_volunteer_api/{id}', 'volunteer_controller@delete_volunteer_api');
Route::get('/single-volunteer-table-information/{id}', 'volunteer_controller@single_volunteer_info');
Route::get('/add-volunteer', 'volunteer_controller@add_volunteer');
Route::post('store-volunteer', 'volunteer_controller@store_volunteer')->name('volunteer.store');
Route::post('update-volunteer', 'volunteer_controller@update_volunteer')->name('volunteer.update');
// end volunteer
// update profile
Route::get('/update_profile', 'homeController@update_profile');
Route::post('/update-user-info', 'homeController@update_user_info');
});