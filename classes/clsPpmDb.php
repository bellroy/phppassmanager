<?php

class clsPpmDb {

        function checkEncryptedPass ($strEncryptedPass) {

                $strEscapeInitialVector = mysql_real_escape_string($strInitialVector);

                if (strlen($strEscapeInitialVector) != 32 ) {
                        return FALSE;
                } else {
                        return TRUE;
                }

        }

}

?>

