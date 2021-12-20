<?php

require "dbBroker.php";
require "model/prijava.php";

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$podaci = Prijava::getAll($conn);
if (!$podaci) {
    echo "Nastala je greška pri preuzimanju podataka";
    die();
}
if ($podaci->num_rows == 0) {
    echo "Nema rezervisanih terena";
    die();
} else {

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <link rel="shortcut icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <title>REZERVACIJA TERENA</title>

</head>

<body>


    <div class="gornjideo" style="color: black;">
        <h1>TENISKI KLUB "NOLE"</h1>
    </div>

    <div class="row1">
        <div class="col-md-4">
            <button id="btn" class="btn btn-info btn-block" style="background-color: #363636; border: 2px solid #D37506; height:50px; font-size: 18px; border-radius: 28px; "> Predstavi terene</button>
        </div>
        <div class="col-md-4">
            <button id="btn-dodaj" type="button" class="btn btn-success btn-block" style="background-color: #363636; border: 2px solid #D37506; height:50px; font-size: 18px; border-radius: 28px;" data-toggle="modal" data-target="#myModal"> Zakazi svoj termin</button>

        </div>
        <div class="col-md-4">
            <button id="btn-pretraga" class="btn btn-warning btn-block" style="background-color:  #363636; border: 2px solid #D37506; height:50px; font-size: 18px; border-radius: 28px;"> Pretrazi slobodan teren</button>
            <input type="text" id="myInput" onkeyup="funkcijaZaPretragu()" placeholder="Pronadji broj terena" hidden>
        </div>
    </div>

    <div id="pregled" class="panel" style="margin-top: 8%; background: none;">

        <div class="panel-body">
            <table id="myTable" class="table" style=" background-color: #47a64c; border: 2px solid black;">
                <thead class="thead">
                    <tr>
                        <th scope="col">Broj terena</th>
                        <th scope="col">Tip terena</th>
                        <th scope="col">Sektor</th>
                        <th scope="col">Datum zakazanog termina</th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    <?php
                    while ($red = $podaci->fetch_array()) :
                    ?>
                        <tr>
                            <td><?php echo $red["brojTerena"]?></td>
                            <td><?php echo $red["tipTerena"] ?></td>
                            <td><?php echo $red["sektor"] ?></td>
                            <td><?php echo $red["datum"] ?></td>
                            <td>
                                <label class="custom-radio-btn">
                                    <input type="radio" name="checked-donut" value=<?php echo $red["id"] ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                        </tr>
                <?php
                    endwhile;
                } #zatvaranje elsa otvorenog na liniji 21
                ?>

                </tbody>
            </table>
            <div class="row">
                <div class="col-md-1">
                    <button id="btn-izmeni" class="btn btn-warning" data-toggle="modal" data-target="#izmeniModal">Napravi izmenu</button>

                </div>

                <div class="col-md-12">
                    <button id="btn-obrisi" formmethod="post" class="btn btn-danger" style="background-color: #242424; border: 3px solid #D37506;">Izbrisi</button>
                </div>

                <div class="col-md-2">
                    <button id="btn-sortiraj" class="btn btn-normal" onclick="sortTable()">Sortiraj tabelu</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- zakazi modal -->
            <!--Sadrzaj modala-->
            <div class="modal-content" style="background-clip: revert; width:1000px; height:700px; box-shadow: 50px 50px 50px 50px rgba(0,0,0,.5); border: 5px black">
                <div class="modal-header" style="padding:5px; border-bottom:0px" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container prijava-form">
                        <form action="#" method="post" id="dodajForm">
                            <h3 style="color: black; text-align: left; font-size: 55px; font-weight: bold">Rezervisi svoj teren:</h3>
                            <div class="row">
                                <div class="col-md-11" style="font-size: 25px; color: black">
                                    <div class="form-group">
                                        <label for=""style="background-color:#7EABC5">Broj terena</label>
                                        <input type="text" style="border: 2px solid black; height: 45px; " name="brojTerena" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="" style="background-color:#7EABC5">Tip terena</label>
                                        <input type="text" style="border: 2px solid black ; height: 45px;" name="tipTerena" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="sala" style="background-color:#7EABC5">Sektor</label>
                                        <input type="sala" style="border: 2px solid black ; height: 45px;" name="sektor" class="form-control" />
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="" style="margin-left: -15px; background-color:#7EABC5" >Datum rezervisanja </label>
                                            <input type="date" style="border: 2px solid black ; height: 45px; margin-left: -15px; width: 105%;" name="datum" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button id="btnDodaj" type="submit" class="btn btn-success btn-block" tyle="background-color: orange; border: 1px solid black;">Zakazi</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>



    </div>
    <!-- Modal -->
    <div class="modal fade" id="izmeniModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal sadrzaj-->
            <div class="modal-content" style="width: 1000px; height: 700px; box-shadow: 50px 50px 50px 50px rgba(0,0,0,.5); border: 5px black;">
                <div class="modal-header" style="padding: 5px; border-bottom: 0px" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container prijava-form">
                        <form action="#" method="post" id="izmeniForm">
                            <h3 style="color: black; text-align: left; font-size: 55px; font-weight: bold">Izmeni rezervisani termin:</h3>
                            <div class="row">
                                <div class="col-md-12" style="font-size: 25px; color: black">
                                    <div class="form-group">
                                        <input id="id" type="text" style="font-size: 20px; border: 2px solid black; height: 45px; " name="id" class="form-control" placeholder="Id *" value="" readonly />
                                    </div>
                                    <div class="form-group">
                                        <input id="brojTerena" type="text" style="font-size: 20px; border: 2px solid black; height: 45px; " name="brojTerena" class="form-control" placeholder="BrTerena*" value="" />
                                    </div>
                                    <div class="form-group">
                                        <input id="tipTerena" type="text" style="font-size: 20px; border: 2px solid black; height: 45px; " name="tipTerena" class="form-control" placeholder="TipTerena *" value="" />
                                    </div>
                                    <div class="form-group">
                                        <input id="sektor" type="text" style="font-size: 20px; border: 2px solid black; height: 45px; " name="sektor" class="form-control" placeholder="Sektor *" value="" />
                                    </div>
                                    <div class="form-group">
                                        <input id="datum" type="date" style="font-size: 20px; border: 2px solid black; height: 45px; " name="datum" class="form-control" placeholder="Datum *" value="" />
                                    </div>
                                    <div class="form-group">
                                        <button id="btnIzmeni" type="submit" class="btn btn-success btn-block" style="background-color: orange; border: 1px solid black;"> Izmeni
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer" style="border: 0px">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-family: -webkit-pictograph; color: white; font-weight: bold; padding: 1px 5px; font-size: 25px; letter-spacing: 2px; width: 30%; margin-left: 230px; margin-top: 15px; background-color: black">Zatvori</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>


    <script>
        function sortTable() {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("myTable");
            switching = true;

            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[1];
                    y = rows[i + 1].getElementsByTagName("TD")[1];
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }

        function funkcijaZaPretragu() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>