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
//General options
$currency = "€";

//Chart options
$chartFill = "0.4"; //How dark is the chart background color? (0.4 - 1)
$chartBorder = "1"; //Darkness of the chart borders (0.4 - 1)
$chartBorderWidth = "1"; //Thickness of the charts borders

$colorPaycheck = "75, 192, 192";
$colorMoneyLeft = "54, 162, 235";
$colorMoneySpent = "255, 99, 132";
$colorMoneyOverTime = "255, 87, 51";
$colorMoneyToSave = "255, 206, 86";
$colorCurrentMoney = $colorPaycheck;

//Statement options
$searchString = ""; //Generetes searchstring for statements
if(isset($_GET["search"])){ 
    $s = $_GET["search"];
    $searchString = "WHERE EntryDate LIKE '%".$s."%' "
            . "OR AcctNo LIKE '%".$s."%' "
            . "OR BankCode LIKE '%".$s."%' "
            . "OR Name1 LIKE '%".$s."%' "
            . "OR Name2 LIKE '%".$s."%' "
            . "OR PaymtPurpose LIKE '%".$s."%' "
            . "OR Value LIKE '%".$s."%' "
            . "OR CategoryName LIKE '%".$s."%'";
}
$pagesize = 25; //How many statements are displayed?