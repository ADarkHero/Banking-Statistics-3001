<?php
if (isSet($_POST["updateDB"])) {

    /*     * ******************
      Download the account statement & balance via mschindler83/fints-hbci-php
     * ****************** */
    require_once 'fints/saldo.php';
    require_once 'fints/statement.php';
}
?>
<form action="index.php" method="post">
    <input type="hidden" name="updateDB" value="true">
    <input type="submit" class="btn 
<?php
if (!isSet($newEntriesCounter)) {
    echo "btn-light";
} else if ($newEntriesCounter > 0) {
    echo "btn-success";
} else if ($newEntriesCounter == 0) {
    echo "btn-warning";
}
?>" value="Update Database">
</form>

&nbsp;





<?php
/* * ******************
  Success Message
 * ****************** */
if (isSet($_POST["updateDB"])) {	
    if ($newEntriesCounter > 0) {
        echo "<span class='newEntries inline'><b class='successMessage'>" . $newEntriesCounter . "</b> new transaction";
        if ($newEntriesCounter !== 1) {
            echo "s";
        }
        echo " got inserted into the database!</span>";
		
		
		
		$sql = "UPDATE settings SET SettingValue = '" . date("Y-m-d", strtotime("yesterday")) . "' WHERE SettingID = 3";
		if ($conn->query($sql) === TRUE) {
			$newEntriesCounter++;
		}
        
        //Redirect to the statement page, if new entries got inserted
        ?>
        <script type="text/javascript">
            setTimeout("location.href = 'statement.php';", 2000);
        </script>
        <?php
    } else {
        echo "<span class='newEntries inline errorMessage'>No new transactions!</span>";
    }
}
?>

<script>
    function sendTAN(){
        var tan = $( "#tan" ).val(); //Reads tan from text input
        
        $.ajax({
            type: "POST",
            url: 'inc/fints/writeTan.php',
            data: {tan: tan},
            success: function(data){
                alert(data);
            }
        });
    }
</script>