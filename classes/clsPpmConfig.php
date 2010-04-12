<?php

class clsConfig {

	var $arrConfigValue;

	function getConfigValue ($strConfigValue) {

                $strQuery = "SELECT vacValue FROM config WHERE vacParameter = '$strConfigValue'";
                $resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());
                $arrRow = mysql_fetch_array($resResult, MYSQL_ASSOC);
                $strValue = $arrRow["vacValue"];

                return $strValue;

	}

	function getConfig () {

        	$strQuery = "SELECT vacParameter, vacValue FROM config";
	        $resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());
	        while ($arrRow = mysql_fetch_array($resResult, MYSQL_ASSOC)) {
			$strKey = $arrRow["vacParameter"];
			$strValue = $arrRow["vacValue"];
			$this->arrConfigValue[$strKey] = $strValue;
		}

        	mysql_free_result($resResult);

	}

	function writeConfig () {

		$arrKeys = array_keys($this->arrConfigValue);

		foreach ($arrKeys as $strKey) {
			$strValue = $this->arrConfigValue[$strKey];
			$strQuery = "UPDATE config SET vacValue = '$strValue' WHERE vacParameter = '$strKey'";
			$resResult = mysql_query($strQuery);
		}

	}

}

?>

