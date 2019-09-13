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

<div class="input-group">
    <input type="text" class="form-control col-4" id="tan" placeholder="TAN">
    <div class="input-group-append">
        <button class="btn btn-outline-light" type="button" onclick="sendTAN()">Send</button>
    </div>
</div>



<?php
/* * ******************
  Success Message
 * ****************** */
if (isSet($_POST["updateDB"])) {
    if ($newEntriesCounter > 0) {
        echo "<p class='newEntries inline'><b class='successMessage'>" . $newEntriesCounter . "</b> new transaction";
        if ($newEntriesCounter !== 1) {
            echo "s";
        }
        echo " got inserted into the database!</p>";
    } else {
        echo "<p class='newEntries inline errorMessage'>No new transactions!</p>";
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