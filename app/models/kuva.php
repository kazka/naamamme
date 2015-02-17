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
        $rivit = DB::query('SELECT * FROM Kuva WHERE id = :id LIMIT 1',
            array('id' => $id));

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
        $kuvat = DB::query("SELECT COUNT(*) as kuvia FROM Kuva WHERE kayttaja_id = :kayttaja_id",
            array('kayttaja_id' => $kayttaja_id));

        if(($kuvat[0]['kuvia']) >= 1) {
            $paakuva = 'false';
        }

        DB::query("INSERT INTO Kuva (kayttaja_id, url, aika, paakuva) VALUES (:kayttaja_id, :url, 'NOW()', :paakuva) RETURNING id",
            array('kayttaja_id' => $kayttaja_id, 'url' => $url, 'paakuva' => $paakuva));
    }

    public static function upload($file) {
        define("UPLOAD_DIR", "/home/kazkaupp/htdocs/tsoha/uploads/");

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

    public static function set_paakuva($uusi_paakuva_id, $kayttaja_id) {
        $rivit = DB::query("SELECT * FROM Kuva WHERE kayttaja_id = :kayttaja_id AND paakuva = 'true'",
            array('kayttaja_id' => $kayttaja_id));

        if (count($rivit) > 0) {
            $rivi = $rivit[0];

            $vanha_paakuva_id = $rivi['id'];

            if ($vanha_paakuva_id != $uusi_paakuva_id) {
                DB::query("UPDATE Kuva SET paakuva = 'false' WHERE id = :vanha_paakuva_id",
                    array('vanha_paakuva_id' => $vanha_paakuva_id));
                DB::query("UPDATE Kuva SET paakuva = 'true' WHERE id = :uusi_paakuva_id",
                    array('uusi_paakuva_id' => $uusi_paakuva_id));
            }
        }
    }

    public static function find_paakuva($kayttaja_id) {
        $rivit = DB::query("SELECT * FROM Kuva WHERE kayttaja_id = :kayttaja_id AND paakuva = 'true'",
            array('kayttaja_id' => $kayttaja_id));

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

    // haetaan tietyn käyttäjän kuvat
    public static function find_by_kayttaja($kayttaja_id) {
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

    public static function destroy($id) {
        DB::query("DELETE FROM Kuva WHERE id = :id", array('id' => $id));
    }

    public static function destroy_from_kayttaja($kayttaja_id) {
        DB::query("DELETE FROM Kuva WHERE kayttaja_id = :kayttaja_id",
            array('kayttaja_id' => $kayttaja_id));
    }

    public function tykkaykset() {
        $tykkaykset = Tykkays::find_by_kuva($this->id);

        return count($tykkaykset);
    }

    public static function validate_kuva($file) {
        $errors = array();

        if (empty($file)) {
            $errors[] = 'Kuva ei saa olla tyhjä.';
        }
        if(!preg_match("/\.(gif|png|jpg|jpeg)$/", $file)) {
            $errors[] = 'Kuva on väärää muotoa.';
        }

        return $errors;
    }

}

?>