<?php

class clsVersion {

        function getVersion () {

		$resHandle = fopen ("http://phppassmanager.sourceforge.net/version2.php", "r");
		if ( $resHandle == FALSE ) {
			echo ("Fehler!");
		}
		$strVersion = fread($resHandle, 4096);
		fclose ($resHandle);

		return $strVersion;

        }

}

?>

