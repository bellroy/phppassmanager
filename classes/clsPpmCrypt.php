<?php

class clsPpmCrypt {


	function createIV() {

                $resEncDes = mcrypt_module_open('rijndael-256', '', 'cbc', '');
                $strInitialVector = mcrypt_create_iv(mcrypt_enc_get_iv_size($resEncDes), MCRYPT_DEV_URANDOM);
                mcrypt_module_close($resEncDes);

		return $strInitialVector;

	}

	function CheckIV ($strInitialVector) {

		$strEscapeInitialVector = mysql_real_escape_string($strInitialVector);

		if (strlen($strEscapeInitialVector) != 32 ) {
			return FALSE;
		} else {
			return TRUE;
		}

	}

	function encrypt ($strValue, $strPassword, $strInitialVector) {

                $resEncDes = mcrypt_module_open('rijndael-256', '', 'cbc', '');
                mcrypt_generic_init($resEncDes, $strPassword, $strInitialVector);
                $strEncrypted = mcrypt_generic($resEncDes, $strValue);
                mcrypt_generic_deinit($resEncDes);

		return $strEncrypted;

	}

	function decrypt($strEncrypted, $strPassword, $strInitialVector) {

                $resEncDes = mcrypt_module_open('rijndael-256', '', 'cbc', '');
                mcrypt_generic_init($resEncDes, $strPassword, $strInitialVector);
                $strDecrypted = mdecrypt_generic($resEncDes, $strEncrypted);
                mcrypt_generic_deinit($resEncDes);
                mcrypt_module_close($resEncDes);
                $strDecrypted = trim($strDecrypted);

		return $strDecrypted;

	}

	function checkCryptModule () {

		$resEncDes = mcrypt_module_open('rijndael-256', '', 'cbc', '');

		if ($resEncDes == FALSE )  {
			return FALSE;
		} else {
			return TRUE;
		}

	}

        function checkEncryptedPass ($strEncryptedPass) {

                $strEscapedEncryptedPass = mysql_real_escape_string($strEncryptedPass);

                if (strlen($strEscapedEncryptedPass) != strlen($strEncryptedPass) ) {
                        return FALSE;
                } else {
                        return TRUE;
                }

        }

}

?>

