<?php

require_once ('inc/template.php');

require_once ('inc/statement/pageFunctions.php');
getPagedisplay(true, $page, $pageback, $pageforward);

/********************
List all transactions
Tag transactions.
********************/

//TODO:
//Search function
//Multiple pages
//Add/change/remove categories
require_once('inc/statement/listTransactions.php');

getPagedisplay(false, $page, $pageback, $pageforward);


require_once ('inc/template_end.php');