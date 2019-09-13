<?php
try{
    $tan = htmlspecialchars($_POST["tan"]);
    
    file_put_contents("tan.txt", $tan);

    echo "Tan input with \"".$tan."\" sucessful!";
} catch (Exception $ex) {

}
