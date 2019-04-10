<?php
/********************
DEPENDS ON
 * inc/category/listCategories.php
********************/

    if(isSet($_POST["categoryChangeName"]) && isSet($_POST["categoryChangeColor"])){
        if(isset($_POST["categoryChangeExcludeStats"])){
            $moneyBy = 1;
        }
        else { $moneyBy = 0; }
        
        
        $sql = "UPDATE categories SET  "
            . "CategoryName = '".htmlspecialchars($_POST["categoryChangeName"])."', "
            . "CategoryColor = '".htmlspecialchars($_POST["categoryChangeColor"])."', "
            . "CategoryExcludeStats = '".$moneyBy."' "
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