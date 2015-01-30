<?php

class KayttajaController extends BaseController {

    public static function index() {
        $kayttajat = Kayttaja::all();

        self::render_view('home.html', array('kayttajat' => $kayttajat));
    }

    public static function find($id) {
        $kayttaja = Kayttaja::find($id);
        $kuvat = Kuva::kayttajankuvat($id);

        self::render_view('kayttaja/tiedot.html', array('kayttaja' => $kayttaja, 'kuvat' => $kuvat));
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            'nick' => $params['nick'],
            'nimi' => $params['nimi'],
            'salasana' => $params['salasana']
        );

        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->errors();

        if(count($errors) == 0) {
            $id = Kayttaja::create($attributes);

            self::redirect_to('/kayttaja/' . $id, array('message' => 'Kiitos liittymisestä!'));
        } else {
            self::render_view('kayttaja/liity.html', array('errors' => $errors, 'attributes' => $attributes));
        }

    }

    public static function destroy($id) {
        Kayttaja::destroy($id);

        self::redirect_to('/', array('message' => 'Käyttäjä on poistettu.'));
    }

    public static function add() {
        self::render_view('kayttaja/liity.html');
    }

    public static function edit($id){
        $kayttaja = Kayttaja::find($id);

        self::render_view('kayttaja/muokkaus.html', array('attributes' => $kayttaja));
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'nick' => $params['nick'],
            'nimi' => $params['nimi'],
            'salasana' => $params['salasana']
        );

        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->errors();

        if(count($errors) > 0) {
            self::render_view('kayttaja/muokkaus.html', array('errors' => $errors, 'attributes' => $attributes));
        } else  {
            Kayttaja::update($id, $attributes);

            self::redirect_to('/kayttaja/' . $id, array('message' => 'Tietosi on päivitetty.'));
        }
    }

    public static function login() {
        self::render_view('kayttaja/kirjaudu.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $kayttaja =  Kayttaja::authenticate($params['nick'], $params['salasana']);

        if(!$kayttaja) {
            self::redirect_to('/login', array('error' => 'Väärä käyttäjätunnus tai salasana.'));
        } else {
            $_SESSION['kayttaja'] = $kayttaja->id;

            self::redirect_to('/', array('message' => 'Tervetuloa ' . $kayttaja->nick . ' :3'));
        }

    }

    public static function logout() {
        $_SESSION['kayttaja'] = null;

        self::redirect_to('/', array('message' => "Olet kirjautunut ulos 3:"));
    }
}

?>