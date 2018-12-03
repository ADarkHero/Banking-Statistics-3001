<?php
require_once ('inc/template.php');
echo '<h1 class="mt-5">Dashboard</h1>';


/********************
When did you get your last paycheck?
********************/

require_once('inc/index/lastPaycheck.php');



/********************
Which contracts do you have to pay?
********************/
require_once('inc/contract/paidContracts.php');



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

