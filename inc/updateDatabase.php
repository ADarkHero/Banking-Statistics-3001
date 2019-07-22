<?php
if(isSet($_POST["updateDB"])){

/********************
Download the account statement & balance via mschindler83/fints-hbci-php
********************/
require_once 'fints/saldo.php';
require_once 'fints/statement.php';


}
?>
<form action="index.php" class="inline" method="post">
	<input type="hidden" name="updateDB" value="true">
	<input type="submit" class="inline btn 
            <?php 
                if(!isSet($newEntriesCounter)){ echo "btn-light"; } 
                else if($newEntriesCounter > 0){ echo "btn-success"; } 
                else if($newEntriesCounter == 0){ echo "btn-warning"; } 
            ?>" value="Update Database">
</form>

<?php
/********************
Success Message
********************/
if(isSet($_POST["updateDB"])){
    if($newEntriesCounter > 0){
        echo "<p class='newEntries inline'><b class='successMessage'>".$newEntriesCounter."</b> new transaction";
        if($newEntriesCounter !== 1){
            echo "s";
        }
        echo " got inserted into the database!</p>";
    }
    else{
        echo "<p class='newEntries inline errorMessage'>No new transactions!</p>";
    }
}
?>