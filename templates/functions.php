<?php
include_once("config.php");


function getHeader($description, $title ="Webshop de vrolijke snuiter")
{
    $header = "<!DOCTYPE html>
    <html lang=\"nl\">
        <head>
            <meta charset=\"iso-8859-1\">
            <meta name=\"description\" content=\"$description\">
            <meta name=\"author\" content=\"Jasper, David, Marnix, Luuk\">
            <title> $title </title>
            <link rel=\"stylesheet\" href=\"../assets/css/custom.css\"\">
        </head>
        <body>";
    echo $header;
}

function getFooter()
{
    $footer = "	
	  <script src=\"../assets/js/validate.js\"></script>
        </body>         
    </html>";
    echo $footer;
}
