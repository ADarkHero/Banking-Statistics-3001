<?php
/********************
DEPENDS ON
 * inc/category/listCategories.php
********************/

    if(isSet($_POST["categoryChangeName"]) && isSet($_POST["categoryChangeColor"])){
        $sql = "UPDATE categories SET  "
            . "CategoryName = '".htmlspecialchars($_POST["categoryChangeName"])."', "
            . "CategoryColor = '".htmlspecialchars($_POST["categoryChangeColor"])."' "
            . "WHERE CategoryName = '".htmlspecialchars($_POST["categoryChangeNameOld"])."'"; //SQL statement
        
        if ($conn->query($sql) === TRUE) {
                echo "<p class='successMessage'>The category \"".htmlspecialchars($_POST["categoryChangeName"])."\" was edited.</p>";
        } 
        else{
                echo "<p class='errorMessage'>Error while editing the category from the database.</p>";
        }

        echo "<br>";
    }

?>