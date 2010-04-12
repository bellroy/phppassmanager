<?php

class clsGroupMgmt

{

	function GetGroupIdByGroupName ($strGroupName) {

        	$strQuery = "SELECT intGroupId FROM groups WHERE vacGroupName = '$strGroupName'";
	        $resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());
		$intRowCount = mysql_num_rows($resResult); 
		if ( $intRowCount == 0 ) {
			$intGroupId = 0;
		} else {
			$arrRow = mysql_fetch_array($resResult, MYSQL_ASSOC);
			$intGroupId = $arrRow["intGroupId"];
		}

		return $intGroupId;

	}


	function GroupAdd($strGroupName) {

	        $strQuery = "INSERT INTO groups (vacGroupName) VALUES ('$strGroupName')";
	        $resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());

        	return $resResult;

	}

	function IsGroupInUse($intGroupId) {

                $strQuery = "SELECT COUNT(intGroupFid) AS number FROM accounts WHERE intGroupFid = $intGroupId";
                $resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());
                $row = mysql_fetch_array($resResult, MYSQL_ASSOC);
                $intGroupCount = $row["number"];

                return $intGroupCount;

	}

	function GroupDelete($intGroupId) {

		$strQuery = "DELETE FROM groups WHERE intGroupId = $intGroupId";
		$resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());

	}

	function GroupChangeByGroupId($intGroupId, $strGroupNameNew) {

		$strQuery = "UPDATE groups SET vacGroupName = '$strGroupNameNew' WHERE intGroupId = $intGroupId";
		$resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());

	}

}


?>
