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
//////////////////////////////////////////////////////////////////////  
// 認証系
//////////////////////////////////////////////////////////////////////  
Auth::routes();

// ホームコントローラー（ログイン時に必要）
Route::get('/home', 'HomeController@index')->name('home');

//////////////////////////////////////////////////////////////////////        
// 画面表示
//////////////////////////////////////////////////////////////////////        
// トップ画面を表示
Route::get('/', function () {
    return view('top');
})->name('top');

// タイピング一覧画面の表示
Route::get('/list', 'DrillsController@index')->name('list');

// マイページ画面の表示
Route::get('/mypage', 'DrillsController@mypage')->name('mypage.mypage')->middleware('auth');

// タイピング登録画面の表示
Route::get('/typing/new', 'DrillsController@new')->name('typing.new')->middleware('auth');

// タイピング編集画面の表示
Route::get('/typing/{id}/edit', 'DrillsController@edit')->name('typing.edit')->middleware('auth');
//{id?}とすると任意パラメーターになる。
//任意パラメーターの場合はアクションにデフォルト値を設定しておく必要がある。

// アカウント設定画面の表示
Route::get('/account', 'AccountsController@index')->name('mypage.account')->middleware('auth');

// タイピング画面の表示
Route::get('/typing/{id}', 'DrillsController@show')->name('typing.show');


//////////////////////////////////////////////////////////////////////  
// CRUD処理
////////////////////////////////////////////////////////////////////// 

// タイピング問題の登録処理
Route::post('/typing', 'DrillsController@create')->name('typing.create')->middleware('auth');

// タイピング問題の編集処理
Route::post('/typing/{id}', 'DrillsController@update')->name('typing.update')->middleware('auth');

// タイピング削除
Route::post('/destroy', 'DrillsController@destroy')->name('typing.destroy')->middleware('auth');

// アカウント情報の更新処理（名前・メールアドレス）
Route::post('/account/prof', 'AccountsController@prof')->name('account.edit')->middleware('auth');

// パスワードの更新処理
Route::post('/account/pass', 'AccountsController@pass')->name('pass.edit')->middleware('auth');

// 退会処理
Route::post('/account/withdraw', 'AccountsController@withdraw')->name('withdraw')->middleware('auth');
