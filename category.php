<?php

require_once ('inc/template.php');
echo '<div class="col-12"><h1 class="mt-3">Categories</h1></div>';



/********************
List/Change categories
********************/

require_once('inc/category/changeCategory.php');
require_once('inc/category/listCategories.php');
echo "<br><br><br>";



/********************
Form to add new categories
********************/

require_once('inc/category/addNewCategory.php');
echo "<br>";




/********************
Form to delete categories
********************/

require_once('inc/category/deleteCategory.php');
echo "<br><br>";



require_once ('inc/template_end.php');