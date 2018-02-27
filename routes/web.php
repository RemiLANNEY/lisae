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

Route::resource('user', 'UserController');

Route::get('promo/trombi', [ "uses" => "PromoController@trombi" , "as" => "promo.trombi" ])->middleware('auth');
Route::get('promo/selec', [ "uses" => "PromoController@selec" , "as" => "promo.selec" ])->middleware('auth');
Route::get('promo/display', ["uses" =>"PromoController@display" , "as" => "promo.display" ])->middleware('auth');
Route::resource('promo', 'PromoController');

Route::post('candidat/updateSelection/{id}', ["uses" =>"CandidatController@updateAjax" , "as" => "candidat.updateAjax" ])->middleware('auth');
Route::post('candidat/displayCom/{id}', ["uses" =>"CandidatController@display" , "as" => "candidat.display" ])->middleware('auth');
Route::post('candidat/Selec/{id}', ["uses" =>"CandidatController@Selec" , "as" => "candidat.Selec" ])->middleware('auth');
Route::get('candidat/ClearPromo/{id}', ["uses" =>"CandidatController@clearPromo" , "as" => "candidat.clearPromo" ])->middleware('auth');
Route::post('candidat/insert', [ "uses" => "CandidatController@insert" , "as" => "candidat.insert" ])->middleware('auth');
Route::get('candidat/import', [ "uses" => "CandidatController@import" , "as" => "candidat.import" ])->middleware('auth');
Route::get('candidat/liste', [ "uses" => "CandidatController@liste" , "as" => "candidat.liste" ])->middleware('auth');
Route::post('candidat/portrait', [ "uses" => "CandidatController@portrait" , "as" => "candidat.portrait" ])->middleware('auth');
Route::get('question/{candidat}/{id}', [ "uses" => "CandidatController@formUpdateQuestion" , "as" => "candidat.formUpdateQuestion" ])->where(['id' => '[0-9]+', 'candidat' => '[0-9]+'])->middleware('auth');
Route::post('question/update', [ "uses" => "CandidatController@updateQuestion" , "as" => "candidat.updateQuestion" ])->middleware('auth');
Route::post('candidat/docAdmin', [ "uses" => "CandidatController@docAdmin" , "as" => "candidat.docAdmin" ])->middleware('auth');

Route::resource('candidat', 'CandidatController');

Route::get('eval/{candidat}/{id}', [ "uses" => "EvaluationsController@formEditEval" , "as" => "eval.formEditEval" ])->where(['id' => '[0-9]+', 'candidat' => '[0-9]+'])->middleware('auth');
Route::get('eval/destroy/{candidat}/{id}', [ "uses" => "EvaluationsController@destroyEval" , "as" => "eval.destroyEval" ])->where(['id' => '[0-9]+', 'candidat' => '[0-9]+'])->middleware('auth');
Route::resource('eval', 'EvaluationsController');

Route::post('abs/', [ "uses" => "AbsencesController@selectCal" , "as" => "absences.selectCal" ])->middleware('auth');
Route::get('absences/stats/', [ "uses" => "AbsencesController@stats" , "as" => "absences.stats" ])->middleware('auth');
Route::get('absences/{date}/', [ "uses" => "AbsencesController@selectDate" , "as" => "absences.selectDate" ])->middleware('auth');
Route::get('absences/destroyJustif/{id}/', [ "uses" => "AbsencesController@destroyPiece" , "as" => "absences.destroyPiece" ])->where(['id' => '[0-9]+'])->middleware('auth');
Route::resource('absences', 'AbsencesController');

Route::post('retard/', [ "uses" => "RetardsController@selectCal" , "as" => "retards.selectCal" ])->middleware('auth');
Route::get('retards/stats/', [ "uses" => "RetardsController@stats" , "as" => "retards.stats" ])->middleware('auth');
Route::get('retards/{date}/', [ "uses" => "RetardsController@selectDate" , "as" => "retards.selectDate" ])->middleware('auth');
Route::resource('retards', 'RetardsController');


Route::post('planning/', [ "uses" => "GeneralController@selectCal" , "as" => "planning.selectCal" ])->middleware('auth');
Route::get('planning/', [ "uses" => "GeneralController@planning" , "as" => "planning" ])->middleware('auth');
Route::get('planning/{numSemaine}', [ "uses" => "GeneralController@otherSemaine" , "as" => "planning.otherSemaine" ])->middleware('auth');

Route::get('stats/', [ "uses" => "StatsController@index" , "as" => "stats" ])->middleware('auth');
Route::get('docAdmin/', [ "uses" => "StatsController@docAdmin" , "as" => "docAdmin" ])->middleware('auth');

Route::resource('structure', 'StructureController');
Route::resource('contacts', 'ContactsController');

Route::get('structure/{id}/HistoContact/add', [ "uses" => "HistoContactController@Add" , "as" => "HistoContact.Add" ])->middleware('auth');
Route::resource('HistoContact', 'HistoContactController');

Route::post('search', [ "uses" => "GeneralController@searchMotot" , "as" => "searchMotot" ])->middleware('auth');
Route::get('pdfListe', [ "uses" => "PromoController@pdfview" , "as" => "pdfview" ])->middleware('auth');

Route::get('/', [ "uses" => "GeneralController@index" , "as" => "Home" ])->middleware('auth');


