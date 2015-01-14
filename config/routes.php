<?php

  $app->get('/', function() {
    HelloWorldController::index();
  });

  $app->get('/tiedot', function() {
    HelloWorldController::tiedot();
  });

  $app->get('/muokkaus', function() {
    HelloWorldController::muokkaus();
  });

  $app->get('/liity', function() {
    HelloWorldController::liity();
  });

  $app->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
