<?php
/********************
DEPENDS ON
 * inc/settings/changeSettingsDialog.php
********************/

    if(isSet($_POST["settingsChangeName"]) && isSet($_POST["settingsChangeValue"])){        
        $sql = "UPDATE settings SET  "
            . "SettingName = '".htmlspecialchars($_POST["settingsChangeName"])."', "
            . "SettingValue = '".htmlspecialchars($_POST["settingsChangeValue"])."' "
            . "WHERE SettingID = '".htmlspecialchars($_POST["settingsChangeID"])."'"; //SQL statement
                
        if ($conn->query($sql) === TRUE) {
                echo "<p class='successMessage'>The setting \"".htmlspecialchars($_POST["settingsChangeName"])."\" was edited.</p>";
        } 
        else{
                echo "<p class='errorMessage'>Error while editing the setting from the database.</p>";
        }

        echo "<br>";
    }

?>