<?php 
/********************
DEPENDS ON
 * inc/categories/listCategoriesSimple.php
********************/


//If no page is set, the current page is "1"
if(isset($_GET["page"])){
    $page = $_GET["page"];
}
else{
    $page = 1;
}

//There is no page, that is smaller than 1
if($page > 1){
    $pageback = $page-1;
}
else{
    $pageback = 1;
}

//There is a maximum amount of pages
$sql = 'SELECT EntryDate FROM statements LEFT JOIN categories ON statements.CategoryID = categories.CategoryID '.$searchString;
$result = $conn->query($sql);
$maxpages = mysqli_num_rows($result) / $pagesize;
if($page == ceil($maxpages)){
    $pageforward = $page;
}
else{
    $pageforward = $page+1;
}


//Displays the buttons to switch the page and the current page number
function getPagedisplay($conn, $headline, $page, $pageback, $pageforward){
    echo '<div class="container"><div class="row">'; //Generate div containers
    //Display "Statements", if on top of the page
    if($headline){
        echo '<div class="col-12 col-md-8"><h1 class="mt-3">Statements</h1></div>';
    }
    else{
        echo '<div class="col-0 col-md-8"></div>';
    }
    
    if(isset($_GET["search"])){
        $search = $_GET["search"];
    }
    else{
        $search = "";
    }

    //Display the current page and buttons to move to the next one
    ?>   
        <div class="col-6 col-md-1"><h1 class="mt-3 monospace">
            <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-html="true" title="<?php require_once('inc/category/listCategoriesSimple.php'); ?>">
                i
            </button>
        </h1></div> 
        <div class="col-2 col-md-1"><h1 class="mt-3 monospace">
            <a href="statement.php?page=<?php echo $pageback; ?>&search=<?php echo $search; ?>"><</a>
        </h1></div> 
        <div class="col-2 col-md-1"><h1 class="mt-3 monospace"><?php echo $page; ?></h1></div> 
        <div class="col-2 col-md-1"><h1 class="mt-3 monospace">
            <a href="statement.php?page=<?php echo $pageforward; ?>&search=<?php echo $search; ?>">></a>
        </h1></div>
        </div></div>
     <?php
}
    
