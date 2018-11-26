<?php 
$pagesize = 25;

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
$sql = 'SELECT EntryDate FROM statements;';
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
        echo '<div class="col-8"><h1 class="mt-5">Statements</h1></div>';
    }
    else{
        echo '<div class="col-8"><h1 class="mt-5"></h1></div>';
    }

    //Display the current page and buttons to move to the next one
    ?>   
        <div class="col-1"><h1 class="mt-5 monospace">
            <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-html="true" title="<?php require_once('inc/category/listCategories.php'); ?>">
                i
            </button>
        </h1></div> 
        <div class="col-1"><h1 class="mt-5 monospace">
            <a href="statement.php?page=<?php echo $pageback; ?>"><</a>
        </h1></div> 
        <div class="col-1"><h1 class="mt-5 monospace"><?php echo $page; ?></h1></div> 
        <div class="col-1"><h1 class="mt-5 monospace">
            <a href="statement.php?page=<?php echo $pageforward; ?>">></a>
        </h1></div>
     <?php
    echo '</div></div>';
}
    
