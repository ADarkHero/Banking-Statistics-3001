<b>Change category</b>:
<form action="category.php" method="post">
  Category name:
  <input type="text" name="categoryChangeName"><br>
  Category color:
  <input type="color" name="categoryChangeColor"><br>
  <input type="submit" value="Submit">
</form>
<?php
	
    if(isSet($_POST["categoryChangeName"]) && isSet($_POST["categoryChangeColor"])){
        $sql = "UPDATE categories SET CategoryName = '".$_POST["categoryChangeName"]."', "
                . "CategoryColor = '".$_POST["categoryChangeColor"]."' WHERE CategoryName = '".$_POST["categoryChangeName"]."'"; //SQL statement

        if ($conn->query($sql) === TRUE) {
                echo "<p class='successMessage'>The category \"".$_POST["categoryChangeName"]."\" was edited.</p>";
        } 
        else{
                echo "<p class='errorMessage'>Error while editing the category from the database.</p>";
        }

        echo "<br>";
    }

?>