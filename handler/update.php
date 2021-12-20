<?php

require "../dbBroker.php";
require "../model/prijava.php";

if(isset($_POST['tipTerena']) && isset($_POST['brojTerena']) 
&& isset($_POST['sektor']) && isset($_POST['datum'])){
    $prijava = new Prijava(null,$_POST['brojTerena'],$_POST['tipTerena'],$_POST['sektor'],$_POST['datum'] );
    $status = Prijava::add($prijava, $conn);

    if($status){
        echo 'Success';
    }else{
        echo $status;
        echo "Failed";
    }
}


?>