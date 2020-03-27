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
Route::prefix('admin')->group(function () {
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('medicos', 'MedicoController');
    Route::resource('pacientes', 'PacienteController');
    Route::resource('unidades', 'UnidadesController');
    // rotas para a edição de pacientes
    Route::post('pacientes/edit', 'PacienteController@edit')->name('pacientes.edit');
    Route::post('UpdatePaciente','PacienteController@update');
    // rotas para edição de médicos
    Route::post('medicos/edit', 'MedicoController@edit')->name('medicos.edit');
    Route::post('UpdateMedico','MedicoController@update');
    Route::post('medicos/edit/us', 'MedicoController@editUs')->name('medicos.editUs');
    Route::post('UpdateUsuario','MedicoController@updateUs');
    Route::post('medicos/desativar/us', 'MedicoController@editUsDes')->name('medicos.desativaUs');
    Route::post('DesativaUsuario','MedicoController@desativaUs');
    // rotas para edição de unidades
    Route::post('unidades/edit', 'UnidadesController@edit')->name('unidades.edit');
    Route::post('UpdateUnidade','UnidadesController@update');
    Route::get('pacientes/api/list', 'PacienteController@list')->name('pacientes.list');
    Route::get('unidades/api/list', 'UnidadesController@list')->name('unidades.list');
    Route::get('unidades/api/change', 'HomeController@changeUnidade')->name('unidades.change');
    Route::get('formularios', 'FormularioController@index')->name('formulario.index');
    Route::post('formularios', 'FormularioController@store')->name('formulario.store');
    Route::get('formulario/{id}', 'FormularioController@formulario')->name('formulario.forms');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    
    Route::get('formularios/lista', 'FormularioController@list')->name('formulario.list');
    Route::get('formularios/lista/edit', 'FormularioController@editresposta')->name('formulario.update_respostas');
    Route::post('AtualizarResposta', 'FormularioController@update');
    

    Route::get('formulario/pdf/{id}', 'FormularioController@pdf')->name('formulario.pdf');
    Route::delete('formulario/delete', 'FormularioController@destroy')->name('formulario.destroy');
});

Route::post('/contact', 'HomeController@mail')->name('contact.send');
Route::get('user/unidades', 'HomeController@getUnidades')->name('get.unidades');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/cron', 'HomeController@cron')->name('cron');
Route::get('/ajaxUnidade', 'PacienteController@ajaxUnidade')->name('ajaxUnidade');
Route::get('/saveForm','FormularioController@stepAjaxUpdate')->name('saveForm');
