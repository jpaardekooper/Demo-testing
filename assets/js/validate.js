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

$(document).ready(function() {

    $("#send").prop('disabled',true);

    $('#select-form').change(function() {
        if ($('#select-form').val() == "") {
            $("#send").prop('disabled',true);
            document.getElementById("form-succes").style.display = "none";
        }
        if ($('#select-form').val() != "" && $('#select-company').val() != "" && $('#select-date').val() != "") {
            $("#send").prop('disabled',false);
        }
        else {
            $("#send").prop('disabled',true);

        }
    });
    $('#select-company').change(function() {
        if ($('#select-company').val() == "") {
            $("#send").prop('disabled',true);
            document.getElementById("form-succes2").style.display = "none";
        }
        if ($('#select-form').val() != "" && $('#select-company').val() != "" && $('#select-date').val() != "") {
            $("#send").prop('disabled',false);
        }
        else {
            $("#send").prop('disabled',true);
        }
    });
    $('#select-date').change(function() {
        if ($('#select-date').val() == "") {
            $("#send").prop('disabled',true);
            document.getElementById("form-succes3").style.display = "none";
        }
        if ($('#select-form').val() != "" && $('#select-company').val() != "" && $('#select-date').val() != "") {
            $("#send").prop('disabled',false);
        }
        else {
            $("#send").prop('disabled',true);
        }
    });

});