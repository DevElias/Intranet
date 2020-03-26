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


Route::get('/dashboard-admin', ['uses' => 'DashboardController@index']);
Route::get('/dashboard-cliente', ['uses' => 'DashboardController@cliente']);
// Route::view('/', 'starter')->name('starter');
Route::get('large-compact-sidebar/starter/blank-compact', function () {
    // set layout sesion(key)
    session(['layout' => 'compact']);
    return view('starter.blank-compact');
})->name('compact');

Route::get('large-sidebar/starter/blank-large', function () {
    // set layout sesion(key)
    session(['layout' => 'normal']);
    return view('starter.blank-large');
})->name('normal');

Route::get('horizontal-bar/starter/blank-horizontal', function () {
    // set layout sesion(key)
    session(['layout' => 'horizontal']);
    return view('starter.blank-horizontal');
})->name('horizontal');

Route::get('vertical/starter/blank-vertical', function () {
    // set layout sesion(key)
    session(['layout' => 'vertical']);
    return view('starter.blank-vertical');
})->name('vertical');


Route::get('/aprovacoes/empresas', 'EmpresaController@aprovacoes');
Route::get('/aprovacoes/clientes', 'EmpresaController@aprovacliente');
Route::get('/empresa', 'EmpresaController@index');
Route::get('/empresa/vinculo', 'EmpresaController@listagem');
Route::view('/empresa/nova', 'empresa.nova')->name('nova');

 // sessions
 Route::view('/', 'sessions.login')->name('login');
 Route::view('/cadastro', 'sessions.cadastro')->name('cadastro');
 Route::view('/esqueci', 'sessions.esqueci')->name('esqueci');
 Route::view('/404', 'dashboard.404')->name('404');

 //User Actions
 Route::post('/cadastrar', ['uses' => 'UsuarioController@create']);
 Route::post('/login', ['uses' => 'UsuarioController@login']);
 Route::get('/logout', ['uses' => 'UsuarioController@logout']);
 Route::post('/notificacoes', ['uses' => 'UsuarioController@notificacoes']);
 Route::post('/atualiza/notificacoes', ['uses' => 'UsuarioController@atualizanotificacoes']);
 Route::get('/minha-conta/{id}', ['uses' => 'UsuarioController@profile']);
 Route::post('/atualizar', ['uses' => 'UsuarioController@update']);
 Route::post('/enviar/senha', ['uses' => 'UsuarioController@esqueci']);
 //Company
 Route::post('/lista/empresa', ['uses' => 'EmpresaController@index']);
 Route::post('/cadastrar/empresa', ['uses' => 'EmpresaController@create']);
 Route::post('/buscar/empresa', ['uses' => 'EmpresaController@search']);
 Route::post('/aprovar/empresa', ['uses' => 'EmpresaController@aprovar']);
 Route::post('/reprovar/empresa', ['uses' => 'EmpresaController@reprovar']);
 Route::get('/empresa/{id}/my-drive', ['uses' => 'EmpresaController@conteudo']);
 Route::get('/empresa/{id}/folders/{pasta}', ['uses' => 'EmpresaController@pasta']);
 Route::post('/solicitar/empresa', ['uses' => 'EmpresaController@solicitar']);
 Route::post('/responsavel/empresa', ['uses' => 'EmpresaController@responsavel']);
 Route::post('/addusuario/empresa', ['uses' => 'EmpresaController@addusuario']);
 Route::post('/atualizar/empresa', ['uses' => 'EmpresaController@update']);
 //Folders
 Route::post('/criar/pasta', ['uses' => 'EmpresaController@criarpasta']);
 Route::post('/envia/arquivo', ['uses' => 'EmpresaController@arquivo'])->name('envia.arquivo');
 //Requests
 Route::post('/aprovar/solicitacao', ['uses' => 'EmpresaController@aprovarsolicitacao']);
 Route::post('/reprovar/solicitacao', ['uses' => 'EmpresaController@reprovarsolicitacao']);

//dados
Route::get('/dados/clientes', ['uses' => 'DadosController@index']);
Route::get('/dados/empresas', ['uses' => 'DadosController@empresas']);
