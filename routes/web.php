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
Route::get('/', 'HomeController@landing')->name('landing');

Route::get('/specialisten', 'SpecialistController@index')->name('listSpecialists');
Route::get('/specialist/{name}', 'SpecialistController@show')->name('specialist');

Route::get('/klachten', 'ComplaintController@index')->name('complaints');
Route::get('/klacht/{name}', 'ComplaintController@show')->name('complaint');

Route::get('/werkgebieden', 'SpecialismController@index')->name('specialisms');
Route::get('/werkgebied/{name}', 'SpecialismController@show')->name('specialism');

Route::get('/test', function () {
    return view("test.blank");
});


Route::group(['prefix' => '/zoek'], function () {
    Route::get('/', 'SearchController@searchDirector')->name('searchDirector');
    Route::get('/werkgebieden/resultaat', 'SearchController@searchSpecialism')->name('searchSpecialism');
    Route::get('/klacht/resultaat', 'SearchController@searchComplaint')->name('searchComplaint');
});
// Login + Register routes
Route::group(['prefix' => '/secure'], function () {

    Route::get('/login', 'LoginController@create')->name('login');
    Route::post('/login', 'LoginController@store');

    Route::get('/logout', 'LoginController@destroy')->name('logout');

    Route::get('/register', 'RegisterController@index')->name('register');
    Route::post('/register', 'RegisterController@store');

    Route::group(['prefix' => '/password-reset'], function() {
        Route::get('/create', 'PasswordResetController@create')->name('passwordreset.create');
        Route::post('/create', 'PasswordResetController@store')->name('passwordreset.store');
        Route::get('/edit/{token}', 'PasswordResetController@edit')->name('passwordreset.edit');
        Route::patch('/edit/{id}', 'PasswordResetController@update')->name('passwordreset.update');
    });
});
// Admin routes
Route::group(['namespace' => 'Admin' ,'prefix' => '/admin',  'as' => 'admin.', 'middleware' => ['isAdmin', 'CheckAccess']], function(){

    Route::get('', 'AdminController@show')->name('admin');

    Route::get('/instellingen',"AdminController@settings")->name("usettings");
    Route::patch('/instellingen',"AdminController@storeSettings")->name("storeSettings");

    Route::get('/berichten', "MessageController@index")->name('messages.index');
    Route::get('/berichten/nieuw/{type?}/{id?}/{subject?}', "MessageController@create")->name('messages.create');
    Route::post('/berichten/nieuw', "MessageController@store")->name('messages.store');
    Route::get('/berichten/{message}', "MessageController@show")->name('messages.show');
    Route::delete('/berichten/{message}', "MessageController@destroy")->name('messages.destroy');
    Route::patch('/berichten/{message}', "MessageController@archive")->name('messages.archive');
    Route::patch('/berichten/{message}/restore', "MessageController@restore")->name('messages.restore');

    Route::get('/groepen', 'GroupController@index')->name('groups.index');
    Route::get('/groepen/nieuw', 'GroupController@create')->name('groups.create');
    Route::post('/groepen/nieuw', 'GroupController@store')->name('groups.store');
    Route::get('/groepen/{group}', 'GroupController@show')->name('groups.show')->middleware('inGroup');
    Route::get('/groepen/{group}/bewerken', 'GroupController@edit')->name('groups.edit');
    Route::patch('/groepen/{group}', 'GroupController@update')->name('groups.update');
    Route::delete('/groepen/{group}', 'GroupController@destroy')->name('groups.destroy');

    Route::get('/specialisten', 'SpecialistController@index')->name('specialists.index')->middleware('CheckFIlterType');
    Route::get('/specialisten/nieuw', 'SpecialistController@create')->name('specialists.create');
    Route::get('/specialisten/lijst/{id}', 'SpecialistController@listSpec')->name('specialists.list')->middleware('NoDebugBar');
    Route::post('/specialisten/nieuw', 'SpecialistController@store')->name('specialists.store');
    Route::post('/specialisten/nieuw/profielafbeelding', 'SpecialistController@saveImage')->name('specialists.saveImage');
    Route::get('/specialisten/{specialist}', 'SpecialistController@show')->name('specialists.show');
    Route::get('/specialisten/{specialist}/bewerken', 'SpecialistController@edit')->name('specialists.edit');
    Route::patch('/specialisten/{specialist}', 'SpecialistController@update')->name('specialists.update');
    Route::delete('/specialisten/{specialist}', 'SpecialistController@destroy')->name('specialists.destroy');
    Route::patch('/specialisten/{id}/herstellen', "SpecialistController@restore")->name('specialists.restore');
    Route::delete('/specialisten/{id}/vergeten', "SpecialistController@forget")->name('specialists.forget');

    Route::get('/werkgebieden', 'SpecialismController@index')->name('specialisms.index');
    Route::get('/werkgebieden/nieuw', 'SpecialismController@create')->name('specialisms.create');
    Route::post('/werkgebieden/nieuw', 'SpecialismController@store')->name('specialisms.store');
    Route::get('/werkgebieden/{specialism}', 'SpecialismController@show')->name('specialisms.show');
    Route::get('/werkgebieden/{specialism}/bewerken', 'SpecialismController@edit')->name('specialisms.edit');
    Route::patch('/werkgebieden/{specialism}', 'SpecialismController@update')->name('specialisms.update');
    Route::delete('/werkgebieden/{specialism}', 'SpecialismController@destroy')->name('specialisms.destroy');

    Route::get('/klachten', 'ComplaintController@index')->name('complaints.index');
    Route::get('/klachten/nieuw', 'ComplaintController@create')->name('complaints.create');
    Route::post('/klachten/nieuw', 'ComplaintController@store')->name('complaints.store');
    Route::get('/klachten/{complaint}', 'ComplaintController@show')->name('complaints.show');
    Route::get('/klachten/{complaint}/bewerken', 'ComplaintController@edit')->name('complaints.edit');
    Route::patch('/klachten/{complaint}', 'ComplaintController@update')->name('complaints.update');
    Route::delete('/klachten/{complaint}', 'ComplaintController@destroy')->name('complaints.destroy');

    Route::get('/therapieen', 'TherapyController@index')->name('therapies.index');
    Route::get('/therapieen/nieuw', 'TherapyController@create')->name('therapies.create');
    Route::post('/therapieen/nieuw', 'TherapyController@store')->name('therapies.store');
    Route::get('/therapieen/{therapy}', 'TherapyController@show')->name('therapies.show');
    Route::get('/therapieen/{therapy}/bewerken', 'TherapyController@edit')->name('therapies.edit');
    Route::patch('/therapieen/{therapy}', 'TherapyController@update')->name('therapies.update');
    Route::delete('/therapieen/{therapy}', 'TherapyController@destroy')->name('therapies.destroy');

    Route::get('/diversen', 'DiverseController@index')->name('diverse.index');
    Route::get('/diversen/nieuw', 'DiverseController@create')->name('diverse.create');
    Route::post('/diversen/nieuw', 'DiverseController@store')->name('diverse.store');
    Route::get('/diversen/{diverse}', 'DiverseController@show')->name('diverse.show');
    Route::get('/diversen/{diverse}/bewerken', 'DiverseController@edit')->name('diverse.edit');
    Route::patch('/diversen/{diverse}', 'DiverseController@update')->name('diverse.update');
    Route::delete('/diversen/{diverse}', 'DiverseController@destroy')->name('diverse.destroy');

    Route::get('/gebruikers', "UserController@index")->name('umgmt.index')->middleware('CheckFIlterType');
    Route::get('/gebruikers/toevoegen', "UserController@create")->name('umgmt.create');
    Route::post('/gebruikers/toevoegen', "UserController@store")->name('umgmt.store');
    Route::get('/gebruikers/{user}', "UserController@show")->name('umgmt.show');
    Route::get('/gebruikers/{user}/bewerken', "UserController@edit")->name('umgmt.edit');
    Route::patch('/gebruikers/{user}', 'UserController@update')->name('umgmt.update');
    Route::delete('/gebruikers/{user}', "UserController@destroy")->name('umgmt.destroy');
    Route::patch('/gebruikers/{user}/herstellen', "UserController@restore")->name('umgmt.restore');
    Route::get('/gebruikers/{user}/toegang', "UserController@access")->name('umgmt.access');
    Route::patch('/gebruikers/{user}/toegang', "UserController@storeAccess")->name('umgmt.storeAccess');
    Route::patch('/gebruikers/{user}/activeren', "UserController@activate")->name('umgmt.activate');
    Route::patch('/gebruikers/{user}/deactiveren', "UserController@deactivate")->name('umgmt.deactivate');
    Route::delete('/gebruikers/{user}/vergeten', "UserController@forget")->name('umgmt.forget');

    Route::get('/statistieken', 'StatsController@index')->name('stats.index');

    Route::get('/logs', 'LogsController@index')->name('logs.index');

    Route::get('/taken', 'TaskController@index')->name('tasks.index');
    Route::get('/taken/nieuw', 'TaskController@create')->name('tasks.create');
    Route::post('/taken/nieuw', 'TaskController@store')->name('tasks.store');
    Route::get('/taken/{task}', 'TaskController@show')->name('tasks.show');
    Route::get('/taken/{task}/bewerken', 'TaskController@edit')->name('tasks.edit');
    Route::patch('/taken/{task}', 'TaskController@update')->name('tasks.update');
    Route::delete('/taken/{task}', 'TaskController@destroy')->name('tasks.destroy');
    Route::patch('/taken/{task}/status', 'TaskController@updateStatus')->name('tasks.updateStatus');
    Route::patch('/taken/{task}/afronden', 'TaskController@finishTask')->name('tasks.finishTask');
    Route::patch('/taken/{task}/reviseren', 'TaskController@needsRevision')->name('tasks.needsRevision');

    route::get('/webmaster', 'WebmasterController@index')->name('webmaster.index');
    route::post('/webmaster/batch', 'WebmasterController@batchUpload')->name('webmaster.batch');
});
