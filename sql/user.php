<?php

$users = array
(
    array("henk",22-12-2010,1123456788,"admin"),
    array("Klaas",15-5-2009,1123456783,"user"),
    array("Saab",5-2-2003,12345678,"user"),

);

class User
{
    private $id;
    private $name;
    private $age;

    function __construct($userName, $userAge)
    {

        $this ->name = $userName;
        $this->age  = $userAge;
    }

    public function DoSomething()
    {
        echo('Error ich bin deadead');
    }

}

