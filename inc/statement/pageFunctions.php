<?php
/* * ******************
  DEPENDS ON
 * inc/categories/listCategoriesSimple.php
 * ****************** */


//If no page is set, the current page is "1"
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

//There is no page, that is smaller than 1
if ($page > 1) {
    $pageback = $page - 1;
} else {
    $pageback = 1;
}

//There is a maximum amount of pages
$sql = 'SELECT EntryDate FROM statements LEFT JOIN categories ON statements.CategoryID = categories.CategoryID ' . $searchString;
$result = $conn->query($sql);
$maxpages = mysqli_num_rows($result) / $pagesize;
if ($page == ceil($maxpages)) {
    $pageforward = $page;
} else {
    $pageforward = $page + 1;
}

//Displays the buttons to switch the page and the current page number
function getPagedisplay($conn, $headline, $page, $pageback, $pageforward) {
    echo '<div class="container"><div class="row">'; //Generate div containers
    //Display "Statements", if on top of the page
    if ($headline) {
        echo '<div class="col-12 col-md-4"><h1 class="mt-3">Statements</h1></div>';
    }

    if (isset($_GET["search"])) {
        $search = $_GET["search"];
    } else {
        $search = "";
    }

    //Display the current page and buttons to move to the next one
    ?>   
    <div class="col-12 <?php
    if ($headline) {
        echo "col-md-4";
    } else {
        echo "col-md-8";
    }
    ?>">
        <form action="statement.php" method="get" class="form-horizontal">
            <input type="text" name="search" placeholder="Search..." <?php
            if (isset($_GET["search"])) {
                echo 'value="' . $_GET["search"] . '"';
            }
            ?> class="form-control search mt-4" >
        </form>
    </div>
    <div class="col-12 col-md-4">
        <nav aria-label="Statement Navigation">
            <ul class="pagination mt-4 center justify-content-center justify-content-md-end">
                <li class="page-item">
                    <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-html="true" title="<?php require('inc/category/listCategoriesSimple.php'); ?>">
                        Info
                    </button>
                </li>
                <li class="page-item <?php
                if ($page == $pageback) {
                    echo "disabled";
                }
                ?>"><a class="page-link" href="statement.php?page=<?php echo $pageback; ?>&search=<?php echo urlencode($search); ?>">Previous</a></li>
                <li class="page-item disabled"><a class="page-link" href="#"><b><?php echo $page; ?></b></a></li>
                <li class="page-item <?php
                if ($page == $pageforward) {
                    echo "disabled";
                }
                ?>"><a class="page-link" href="statement.php?page=<?php echo $pageforward; ?>&search=<?php echo urlencode($search); ?>">Next</a></li>
            </ul>
        </nav>
    </div>

    </div></div>
    <?php
}
