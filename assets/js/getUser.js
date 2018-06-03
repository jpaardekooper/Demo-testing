function showUser(str) {
    if (str == "") {
        document.getElementById("showUser").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("showUser").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getUser.php?u="+str,true);
        xmlhttp.send();
    }
}

function showForm(str) {
    if (str == "") {
        document.getElementById("showForm").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("showForm").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getForm.php?f="+str,true);
        xmlhttp.send();
    }
}