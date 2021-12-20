$('#dodajForm').submit(function(){
    event.preventDefault();
    console.log("Dodavanje");
    const $form =$(this);
    const $input = $form.find('input, select, button, textarea');

    const serijalizacija = $form.serialize();
    console.log(serijalizacija);

    $input.prop('disabled', true);

    req = $.ajax({
        url: 'handler/add.php',
        type:'post',
        data: serijalizacija
    });

    req.done(function(res, textStatus, jqXHR){
        if(res=="Success"){
            alert("Termin uspešno zakazan");
            console.log("Dodar Termin");
            location.reload(true);
        }else console.log("Termin nije dodat "+res);
        console.log(res);
    });

    req.fail(function(jqXHR, textStatus, errorThrown){
        console.error('Sledeca greska se desila> '+textStatus, errorThrown)
    });
});

$('#btn-obrisi').click(function(){
    console.log("Brisanje");

    const checked = $('input[name=checked-donut]:checked');

    req = $.ajax({
        url: 'handler/delete.php',
        type:'post',
        data: {'id':checked.val()}
    });

    req.done(function(res, textStatus, jqXHR){
        if(res=="Success"){
           checked.closest('tr').remove();
           alert('Obrisan Termin');
           console.log('Obrisan');
        }else {
        console.log("Termin nije obrisan "+res);
        alert("Termin nije obrisan ");

        }
        console.log(res);
    });

});


$('#btn-izmeni').click(function () {
    const checked = $('input[name=checked-donut]:checked');

    request = $.ajax({
        url: 'handler/get.php',
        type: 'post',
        data: {'id': checked.val()},
        dataType: 'json'
    });


    request.done(function (response, textStatus, jqXHR) {
        console.log('Popunjena');
        $('#brojTerena').val(response[0]['brojTerena']);
        console.log(response[0]['brojTerena']);

        $('#tipTerena').val(response[0]['tipTerena'].trim());
        console.log(response[0]['tipTerena'].trim());

        $('#sektor').val(response[0]['sektor'].trim());
        console.log(response[0]['sektor'].trim());

        $('#datum').val(response[0]['datum'].trim());
        console.log(response[0]['datum'].trim());

        $('#id').val(checked.val());

        console.log(response);
    });

   request.fail(function (jqXHR, textStatus, errorThrown) {
       console.error('The following error occurred: ' + textStatus, errorThrown);
   });

});


$('#izmeniForm').submit(function () {
    event.preventDefault();
    console.log("Izmene");
    const $form = $(this);
    const $inputs = $form.find('input, select, button, textarea');
    const serializedData = $form.serialize();
    console.log(serializedData);
    $inputs.prop('disabled', true);

 

    request.done(function (response, textStatus, jqXHR) {


        if (response === 'Success') {
            console.log('Termin rezervacije je izmenjen');
            location.reload(true);

        }
        else console.log('Termin rezervacije nije izmenjen ' + response);
        console.log(response);
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });



});

$('#btn-pretraga').click(function () {

    var para = document.querySelector('#myInput');
    console.log(para);
    var style = window.getComputedStyle(para);
    console.log(style);
    if (!(style.display === 'inline-block') || ($('#myInput').css("visibility") ==  "hidden")) {
        console.log('block');
        $('#myInput').show();
        document.querySelector("#myInput").style.visibility = "";
    } else {
       document.querySelector("#myInput").style.visibility = "hidden";
    }
});

$('#btn').click(function () {
    $('#pregled').toggle();
});

$('#btnDodaj').submit(function () {
    $('#myModal').modal('toggle');
    return false;
});

$('#btnIzmeni').submit(function () {
    $('#myModal').modal('toggle');
    return false;
});

