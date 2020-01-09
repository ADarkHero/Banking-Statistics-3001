<?php

/* * ******************
  Database connection variables
 * ****************** */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";



/* * ******************
  Create database connection
 * ****************** */
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


/* * ******************
  Read settings from Database
 * ****************** */
$sql = "SELECT * FROM settings";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        switch ($row["SettingID"]) {
            /*
             *   PAYCHECK
             */
            case "1":
                $payCheckAccount = $row["SettingValue"]; //IBAN of the person, that gives you your paycheck


            /*
             *   GENERAL OPTIONS
             */

            case "2":
                $currency = $row["SettingValue"]; //Which currency do you want to use?


            /*
             * CHART OPTIONS
             */
            case "51":
                $chartFill = $row["SettingValue"]; //How dark is the chart background color? (0.4 - 1)

            case "52":
                $chartBorder = $row["SettingValue"]; //Darkness of the chart borders (0.4 - 1)

            case "53":
                $chartBorderWidth = $row["SettingValue"]; //Thickness of the charts borders

            case "54":
                $chartFontSize = $row["SettingValue"]; //Font size, obviously.

            case "55":
                $colorPaycheck = $row["SettingValue"];

            case "56":
                $colorMoneyLeft = $row["SettingValue"];

            case "57":
                $colorMoneySpent = $row["SettingValue"];

            case "58":
                $colorMoneyOverTime = $row["SettingValue"];

            case "59":
                $colorMoneyToSave = $row["SettingValue"];

            case "60":
                $colorCurrentMoney = $row["SettingValue"];

            case "61":
                $colorContractCosts = $row["SettingValue"];

            case "71":
                $moneySaveRatio = $row["SettingValue"]; //Based on your (last) paycheck: How much money do you want to save?

            /*
             * STATEMENTS
             */

            case "101":
                $pagesize = $row["SettingValue"]; //How many statements are displayed?

            /*
             * CONTRACTS
             */
            case "201":
                $contractsOrder = $row["SettingValue"]; //1: Order contracts in this schema: 1) !   2) a-z   3) (   4) [   5) {

            /*
             * CREDIT CARD IMPORT
             */
            case "501":
                $uploadPath = $row["SettingValue"]; //Upload path for credit card csv import 
            case "502":
                $creditCardCategory = $row["SettingValue"]; //Category for credit card imports


            /*
             * DARK MODE
             */
            case "666":
                $darkMode = $row["SettingValue"];


                break;

            default:
                break;
        }
    }
}






/* * ******************
  Formatting options
 * ****************** */

function bankNumberFormat($number) { //How should numbers be formatted?
    return number_format($number, 2, ",", ".");
}

//This method is used for numbers, that have a comma like 123,42
function bankNumberFormatComma($number) { //How should numbers be formatted?
    return bankNumberFormat(doubleval(str_replace(",", ".", $number)));
}

/* * ******************
  Search options
 * ****************** */
$searchString = ""; //Generetes searchstring for statements
if (isset($_GET["search"])) {
    $s = $_GET["search"];

//Split search after each &
    $searchArray = preg_split("/(\&|\|)/", $s); //Split the search by characters
    $searchHelpers = preg_replace("/[^\&\|]/", "", $s); //Split the special characters

    if (!(sizeof($searchArray) > 1)) {
        $searchArray[0] = $s;
    }

    $searchString = "WHERE ";
    $closeBracket = false;
    for ($i = 0; $i < sizeof($searchArray); $i++) {
        $searchPart = trim($searchArray[$i]);

        if ($i > 0) {
            switch ($searchHelpers[$i - 1]) {
                case "&":
                    if (!$closeBracket) {
                        $closeBracket = true;
                    } else {
                        $searchString .= ") ";
                    }
                    $searchString .= "AND (";
                    break;
                case "|":
                    $searchString .= "OR";
                    break;
            }
            $searchString .= " ";
        }

        $searchString .= "EntryDate LIKE '%" . $searchPart . "%' "
                . "OR AcctNo LIKE '%" . $searchPart . "%' "
                . "OR BankCode LIKE '%" . $searchPart . "%' "
                . "OR Name1 LIKE '%" . $searchPart . "%' "
                . "OR Name2 LIKE '%" . $searchPart . "%' "
                . "OR PaymtPurpose LIKE '%" . $searchPart . "%' "
                . "OR Value LIKE '%" . $searchPart . "%' "
                . "OR CategoryName LIKE '%" . $searchPart . "%' ";
    }

    if ($closeBracket) {
        $searchString .= ")";
    }
}





