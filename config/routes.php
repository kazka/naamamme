<?php

//  $app->get('/', function() {
//    HelloWorldController::index();
//  });

//  $app->get('/tiedot', function() {
//    HelloWorldController::tiedot();
//  });

  $app->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });


  $app->get('/', function(){
    KayttajaController::index();
  });

  $app->get('/kayttaja', function(){
    KayttajaController::index();
  });

  $app->get('/add', function() {
    KayttajaController::add();
  });

  $app->get('/kayttaja/:id', function($id){
    KayttajaController::find($id, Kuva::find_paakuva($id));
  });

  $app->get('/kayttaja/:id/edit', function($id) {
    KayttajaController::edit($id);
  });

  $app->post('/kayttaja/:id/edit', function($id) {
    KayttajaController::update($id);
  });

  $app->post('/kayttaja', function(){
    KayttajaController::store();
  });

  $app->post('/kayttaja/:id/destroy', function($id){
    KayttajaController::destroy($id);
  });

  $app->get('/login', function(){
    KayttajaController::login();
  });

  $app->post('/login', function(){
    KayttajaController::handle_login();
  });

  $app->post('/logout', function() {
    KayttajaController::logout();
  });

  $app->get('/kayttaja/:id/kuva/edit', function($id) {
    KuvaController::manage($id);
  });

  $app->post('/kayttaja/:id/kuva/edit', function($id) {
    KuvaController::update($id);
  });

  $app->post('/kayttaja/:id/kuva/add', function($id){
    KuvaController::store($id);
  });

  $app->get('/kayttaja/:id/kuva/:kuva_id', function($id, $kuva_id) {
    KayttajaController::find($id, Kuva::find($kuva_id));
  });

  $app->post('/kayttaja/:id/kuva/:kuva_id/kommentti/add', function($id, $kuva_id){
    KommenttiController::store($id, $kuva_id);
  });