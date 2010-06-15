<?php

require_once("classes/clsPpmConfig.php");

class clsAccount {

	var $intAccountId;	
	var $strName;
	var $intGroupId;
	var $strGroupName;
	var $strLogin;
	var $strUrl;
	var $strPassword;
	var $strMd5Password;
	var $strInitialVector;
	var $strNotice;
	var $intView;
	var $intViewDecrypt;
	var $strDatAdded;
	var $strDatChanged;

	function getAccount ($intAccountId) {

		$strQuery = "SELECT intAccountId, vacName, intGroupFid, vacGroupName, vacLogin, vacUrl, vacPassword, ";
		$strQuery .= "vacMd5Password, vacInitialValue, txtNotice, intCountView, intCountDecrypt,datAdded, datChanged ";
		$strQuery .= "FROM accounts LEFT JOIN groups ON accounts.intGroupFid=groups.intGroupId WHERE intAccountId = $intAccountId";
                $resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());
                $arrRow = mysql_fetch_array($resResult, MYSQL_ASSOC);

		$this->intAccountId = $arrRow["intAccountId"];
		$this->strName = $arrRow["vacName"];
		$this->intGroupId = $arrRow["intGroupFid"];
		$this->strGroupName = $arrRow["vacGroupName"];
		$this->strLogin = $arrRow["vacLogin"];
		$this->strUrl = $arrRow["vacUrl"];
		$this->strPassword = $arrRow["vacPassword"];
		$this->strMd5Password = $arrRow["vacMd5Password"];
		$this->strInitialVector = $arrRow["vacInitialValue"];
		$this->strNotice = '<pre>' . $arrRow["txtNotice"] . '</pre>';
		$this->intCountView = $arrRow["intCountView"];
		$this->intCountDecrypt = $arrRow["intCountDecrypt"];
		$this->strDatAdded = $arrRow["datAdded"];
		$this->strDatChanged = $arrRow["datChanged"];

		mysql_free_result($resResult);

	}

	function updateAccount () {

		$strQuery = "UPDATE accounts SET ";
		$strQuery .= "vacName = '$this->strName', ";
		$strQuery .= "intGroupFid = $this->intGroupId, ";
		$strQuery .= "vacLogin = '$this->strLogin', ";
		$strQuery .= "vacUrl = '$this->strUrl', ";
		$strQuery .= "txtNotice = '$this->strNotice' ";
		$strQuery .= "WHERE intAccountId = $this->intAccountId";

		$resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());
		
	}

	function updateAccountPass () {

		$clsConfig = new clsConfig;

		$strQuery = "UPDATE accounts SET ";
		$strQuery .= "vacPassword = '$this->strPassword', ";
		if ( $clsConfig->getConfigValue("md5_pass") == TRUE ) {
			$strQuery .= "vacMd5Password = '$this->strMd5Password', ";
		}
		$strQuery .= "vacInitialValue = '$this->strInitialVector', ";
		$strQuery .= "datChanged = NOW() ";
		$strQuery .= "WHERE intAccountId = $this->intAccountId";
		$resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());

	}

	function createAccount () {

		$clsConfig = new clsConfig;

		$strQuery = "INSERT INTO accounts ";
		if ( $clsConfig->getConfigValue("md5_pass") == TRUE ) {;
			$strQuery .= "(vacName, intGroupFid, vacLogin, vacUrl, vacPassword, vacMd5Password, vacInitialValue, ";
			$strQuery .= "txtNotice, datAdded, datChanged)";
		} else {
			$strQuery .= "(vacName, intGroupFid, vacLogin, vacUrl, vacPassword, vacInitialValue, ";
			$strQuery .= "txtNotice, datAdded, datChanged)";
		}
		$strQuery .= "VALUES(";
		$strQuery .= "'$this->strName', ";
		$strQuery .= "$this->intGroupId, ";
		$strQuery .= "'$this->strLogin', ";
		$strQuery .= "'$this->strUrl', ";
		$strQuery .= "'$this->strPassword', ";
		if ( $clsConfig->getConfigValue("md5_pass") == TRUE ) {
			$strQuery .= "'$this->strMd5Password', ";
		}
		$strQuery .= "'$this->strInitialVector', ";
		$strQuery .= "'$this->strNotice', ";
		$strQuery .= "NOW(), NOW())";

		$resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());

	}

	function deleteAccount ($intAccountId) {

		$strQuery = "DELETE FROM accounts WHERE intAccountId = $intAccountId";
		$resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());

	}

	function incrementViewCounter ($intAccountId) {

		$strQuery = "SELECT intCountView FROM accounts WHERE intAccountId = $intAccountId";
                $resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());
                $arrRow = mysql_fetch_array($resResult, MYSQL_ASSOC);
                $intCounter = $arrRow["intCountView"];
		mysql_free_result($resResult);

		$intCounter++;

		$strQuery = "UPDATE accounts SET intCountView = $intCounter WHERE intAccountId = $intAccountId";
                $resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());

	}

        function incrementDecryptCounter ($intAccountId) {

                $strQuery = "SELECT intCountDecrypt FROM accounts WHERE intAccountId = $intAccountId";
                $resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());
                $arrRow = mysql_fetch_array($resResult, MYSQL_ASSOC);
                $intCounter = $arrRow["intCountDecrypt"];
		mysql_free_result($resResult);

                $intCounter++;

                $strQuery = "UPDATE accounts SET intCountDecrypt = $intCounter WHERE intAccountId = $intAccountId";
                $resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());

        }

	function getAccountMax () {

                $strQuery = "SELECT COUNT(intAccountId) AS Number FROM accounts";
                $resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());
                $arrRow = mysql_fetch_array($resResult, MYSQL_ASSOC);
                $intAccountMax = $arrRow["Number"];
                mysql_free_result($resResult);

		return $intAccountMax;

	}

        function ResetAllAccountMd5Pass () {

                $strQuery = "UPDATE accounts SET vacMd5Password = '0'";
                $resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());

        }

        function writeAccountMd5Pass ($strMd5Password, $intAccountId) {

                $strQuery = "UPDATE accounts SET vacMd5Password = '$strMd5Password' WHERE intAccountId = $intAccountId";
                $resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());

        }

}

?>

