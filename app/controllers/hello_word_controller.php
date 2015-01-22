<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      self::render_view('home.html');
    }

//    public static function tiedot(){
//      self::render_view('/kayttaja/tiedot.html');
//    }

//    public static function muokkaus(){
//      self::render_view('/kayttaja/muokkaus.html');
//    }

//    public static function liity(){
//      self::render_view('/kayttaja/liity.html');
//    }

    public static function sandbox(){
      // Testaa koodiasi täällä	
      $kayttajat = Kayttaja::all();
      print_r($kayttajat);
    }
  }
