<?php
class Prijava{
    public $id;   
    public $brojTerena;   
    public $tipTerena;   
    public $sektor;   
    public $datum;
    
    public function __construct($id=null, $brojTerena=null, $tipTerena=null, $sektor=null, $datum=null)
    {
        $this->id = $id;
        $this->brojTerena = $brojTerena;
        $this->tipTerena = $tipTerena;
        $this->sektor = $sektor;
        $this->datum = $datum;
    }

    #funkcija prikazi sve getAll

    public static function getAll(mysqli $conn)
    {
        $query = "SELECT * FROM rezervacije";
        return $conn->query($query);
    }

    #funkcija getById

    public static function getById($id, mysqli $conn){
        $query = "SELECT * FROM rezervacije WHERE id=$id";

        $myObj = array();
        if($msqlObj = $conn->query($query)){
            while($red = $msqlObj->fetch_array(1)){
                $myObj[]= $red;
            }
        }

        return $myObj;

    }

    #deleteById

    public function deleteById(mysqli $conn)
    {
        $query = "DELETE FROM rezervacije WHERE id=$this->id";
        return $conn->query($query);
    }

    #update
    public function update($id, mysqli $conn)
    {
        $query = "UPDATE rezervacije set brojTerena = $this->brojTerena,tipTerena = $this->tipTerena,sektor = $this->sektor,datum = $this->datum WHERE id=$id";
        return $conn->query($query);
    }

    #insert add
    public static function add(Prijava $prijava, mysqli $conn)
    {
        $query = "INSERT INTO rezervacije(brojTerena, tipTerena, sektor, datum) VALUES('$prijava->brojTerena','$prijava->tipTerena','$prijava->sektor','$prijava->datum')";
        return $conn->query($query);
    }
}

?>