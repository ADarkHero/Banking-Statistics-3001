<?php 
/********************
DEPENDS ON
 * inc/index/lastPaycheck.php
********************/

//There is no page, that is smaller than 1
if($customPaycheckDay > 0){
    $pageback = $customPaycheckDay-1;
}
else{
    $pageback = 0;
}

//There is a maximum amount of pages
$maxpages = sizeof($lastPaycheckDates);
if($customPaycheckDay == ceil($maxpages)-1){
    $pageforward = $customPaycheckDay;
}
else{
    $pageforward = $customPaycheckDay+1;
}


//Displays the buttons to switch the page and the current page number
function getPagedisplay($conn, $headline, $page, $pageback, $pageforward, $lastPaycheckDate){
    echo '<div class="container"><div class="row">'; //Generate div containers
    //Display "Dashboard", if on top of the page
    if($headline){
        echo '<div class="col-12 col-md-7"><h1 class="mt-3">Dashboard</h1></div>';
    }
    else{
        echo '<div class="col-0 col-md-8"></div>';
    }
    

    //Display the current page and buttons to move to the next one
    ?>   
        <div class="col-2 col-md-1"><h1 class="mt-3 monospace">
            <a href="index.php?paycheckDate=<?php echo $pageforward; ?>"><</a>
        </h1></div> 
        <div class="col-2 col-md-3"><h1 class="mt-3 monospace"><?php echo $lastPaycheckDate; ?></h1></div> 
        <div class="col-2 col-md-1"><h1 class="mt-3 monospace">
            <a href="index.php?paycheckDate=<?php echo $pageback; ?>">></a>
        </h1></div>
        </div></div>
     <?php
}
    
