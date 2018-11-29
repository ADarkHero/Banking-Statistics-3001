<?php

require_once ('inc/template.php');
echo '<h1 class="mt-5">Contracts</h1>';

require_once('inc/index/lastPaycheck.php');



/********************
Which contracts do you have? Did they already get paid?
********************/
require_once('inc/contract/paidContracts.php');
require_once('inc/contract/listContracts.php');
echo '<br><br><br>';



/********************
Form to add new contracts
********************/

require_once('inc/contract/addNewContract.php');
echo "<br>";



/********************
Form to delete contracts
********************/

require_once('inc/contract/deleteContract.php');



require_once ('inc/template_end.php');