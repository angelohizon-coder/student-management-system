<?php
    #this is similar to a header template wherein it can be used multiple times in different pages

    function connection() {
        #in practice it is best to declare the variable 
        $host = "localhost";
        $username = "root";
        $password = "@Ngelo4199483";
        $database = "student_schema";

        #mysqli is used for PHP 7+
        #mysql is used for below PHP 7
        #mysqli requires the following parameters: hostname, username, password, database
        $connection = new mysqli($host, $username, $password, $database);

        return $connection;

        #prints array
        #print_r($row);
        #echo count($row);
    }
?>