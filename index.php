<?php
require_once ('inc/template.php');


/********************
When did you get your last paycheck?
********************/

require_once('inc/index/lastPaycheck.php');



/********************
Pages for paychecks
********************/
require_once('inc/index/pageFunctions.php');
getPagedisplay($conn, true, $customPaycheckDay, $pageback, $pageforward, $lastPaycheckDate);



/********************
Which contracts do you have to pay?
********************/
if($customPaycheckDay == 0){
    require_once('inc/contract/paidContracts.php');
}
else{
    $contractCosts = 0;
}



/********************
How much money do you have?
********************/

require_once('inc/index/getCurrentMoney.php');
echo "<br><br>";



/********************
How much money did you spent since your last paycheck?
********************/

require_once('inc/index/moneySpent.php');



/********************
Generate some neat Charts
********************/
require_once ('inc/index/chartMaker.php');




require_once ('inc/template_end.php');


/********************
 * Checks, if we are in the current month, or if we are in a past one.
********************/
function isCurrentMonth(){
    if(isset($_GET["paycheckDate"])){
        if($_GET["paycheckDate"] == 0){
            return true;
        } 
        return false;
    }
    return true;
}
