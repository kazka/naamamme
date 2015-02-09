<?php

class KayttajaController extends BaseController {

    public static function index() {
        $kayttajat = Kayttaja::all();
        $kuvat = Kuva::all();

        self::render_view('home.html', array('kayttajat' => $kayttajat, 'kuvat' => $kuvat));
    }

    public static function find($id, $valittukuva) {
        $kayttaja = Kayttaja::find($id);
        $kuvat = Kuva::find_by_kayttaja($id);
        $kommentit = Kommentti::find_by_kuva($valittukuva->id);

        self::render_view('kayttaja/tiedot.html', array('kayttaja' => $kayttaja, 'kuvat' => $kuvat, 'valittukuva' => $valittukuva, 'kommentit' => $kommentit));
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

        if (empty($_FILES['kuva']['name'])) {
            $errors[] = 'Kuva ei saa olla tyhjä.';
        }
        //if (!getimagesize($_FILES['kuva'])) {
        //    $errors[] = 'Kuva on väärää muotoa.';
        //}

        //$errors[] = Kuva::check_filetype($_FILES['kuva']['name']);

        if(count($errors) == 0) {
            $id = Kayttaja::create($attributes);

            $url = Kuva::upload($_FILES['kuva']);
            Kuva::create($id, $url);

            $_SESSION['kayttaja'] = $id;

            self::redirect_to('/kayttaja/' . $id, array('message' => 'Kiitos liittymisestä!'));
        } else {
            self::render_view('kayttaja/liity.html', array('errors' => $errors, 'attributes' => $attributes));
        }

    }

    public static function destroy($id) {
        Kuva::destroy_from_kayttaja($id);
        Kayttaja::destroy($id);

        self::redirect_to('/', array('message' => 'Käyttäjä on poistettu.'));
    }

    public static function add() {
        self::render_view('kayttaja/liity.html');
    }

    public static function edit($id){
        self::check_logged_in();
        $kayttaja = Kayttaja::find($id);

        self::render_view('kayttaja/muokkaus.html', array('attributes' => $kayttaja));
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            //'nick' => $params['nick'],
            'nimi' => $params['nimi'],
            'salasana' => $params['salasana']
        );

        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->validate_nimi();

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