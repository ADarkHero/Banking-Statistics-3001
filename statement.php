<?php

require_once ('inc/template.php');



?>

<br>
<form action="statement.php" method="get" class="form-horizontal">
  <input type="text" name="search" placeholder="Search..." <?php if(isset($_GET["search"])){ echo 'value="'.$_GET["search"].'"'; } ?> class="form-control search" >
</form>

<?php

/********************
Shows a menu to switch pages
********************/
require_once ('inc/statement/pageFunctions.php');
getPagedisplay($conn, true, $page, $pageback, $pageforward);




/********************
List all transactions
Tag transactions.
********************/
//TODO:
//Search function
require_once('inc/statement/listTransactions.php');

getPagedisplay($conn, false, $page, $pageback, $pageforward);


require_once ('inc/template_end.php');