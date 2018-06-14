$(document).ready( function () {
    $('#table_id').DataTable();
} );


function succes() {
    d = document.getElementById("select-form").value;

    document.getElementById("form-succes").style.display = "block";
    document.getElementById("warning").style.display = "none";
}

function succes2() {
    d = document.getElementById("select-company").value;

    document.getElementById("form-succes2").style.display = "block";
    document.getElementById("warning2").style.display = "none";
}

function succes3() {
    d = document.getElementById("select-date").value;

    document.getElementById("form-succes3").style.display = "block";
    document.getElementById("warning3").style.display = "none";
}