<?php


/********************
Database connection variables
********************/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";



/********************
Create database connection
********************/
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



/********************
Paycheck variables
********************/
$payCheckAccount = ""; //IBAN of the person, that gives you your paycheck



