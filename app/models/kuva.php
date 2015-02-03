<?php

class Kuva extends BaseModel{

    public $id, $kayttaja_id, $url, $aika, $paakuva;

    public function __construct($attributes){
        parent::__construct($attributes);
    }

    public static function all() {
        $kuvat = array();

        $rivit = DB::query('SELECT * FROM Kuva');

        foreach ($rivit as $rivi) {
            $kuvat[] = new Kuva(array(
                'id' => $rivi['id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'url' => $rivi['url'],
                'aika' => $rivi['aika'],
                'paakuva' => $rivi['paakuva']
            ));
        }

        return $kuvat;
    }

    public static function find($id) {
        $rivit = DB::query('SELECT * FROM Kuva WHERE id = :id LIMIT 1', array('id' => $id));

        if (count($rivit) > 0) {
            $rivi = $rivit[0];

            $kuva = new Kuva(array(
                'id' => $rivi['id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'url' => $rivi['url'],
                'aika' => $rivi['aika'],
                'paakuva' => $rivi['paakuva']
            ));

            return $kuva;
        }

        return null;
    }

    public static function create($kayttaja_id, $url) {
        $paakuva = 'true';
        $kuvat = DB::query("SELECT COUNT(*) FROM Kuva WHERE kayttaja_id = :kayttaja_id", array('kayttaja_id' => $kayttaja_id));

        if(count($kuvat) >= 1) {
            $paakuva = 'false';
        }

        DB::query("INSERT INTO Kuva (kayttaja_id, url, aika, paakuva) VALUES ('$kayttaja_id', '$url', 'NOW()', '$paakuva')");
    }

    public static function upload($file) {
        define("UPLOAD_DIR", "/home/kazkaupp/htdocs/tsoha/uploads/");

        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo "<p>Virhe kuvan latauksessa.</p>";
            exit;
        }

        $name = preg_replace("/[^A-Z0-9._-]/i", "_", $file['name']);

        $i = 0;
        $parts = pathinfo($name);
        while (file_exists(UPLOAD_DIR . $name)) {
            $i++;
            $name = $parts['filename'] . "-" . $i . "." . $parts['extension'];
        }

        $success = move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $name);

        if (!$success) {
            echo "<p>Kuvaa ei voitu tallentaa.</p>";
            exit;
        }

        chmod(UPLOAD_DIR . $name, 0644);

        $url = 'http://kazkaupp.users.cs.helsinki.fi/tsoha/uploads/' . $name;

        return $url;
    }

    // haetaan tietyn käyttäjän kuvat
    public static function kayttajankuvat($kayttaja_id) {
        $kuvat = array();

        $rivit = DB::query('SELECT * FROM Kuva WHERE kayttaja_id = :kayttaja_id', array('kayttaja_id' => $kayttaja_id));

        foreach ($rivit as $rivi) {
            $kuvat[] = new Kuva(array(
                'id' => $rivi['id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'url' => $rivi['url'],
                'aika' => $rivi['aika'],
                'paakuva' => $rivi['paakuva']
            ));
        }

        return $kuvat;
    }

}

?>