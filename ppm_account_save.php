<?php

        require_once("config.php");
        require_once("constants.inc");
        require_once("classes/clsPpmCrypt.php");
        require_once("classes/clsPpmAccount.php");
        require_once("classes/clsPpmGroupMgmt.php");
        require_once("functions/db.php");
        require_once("functions/pagedesign.php");

        StartRenderTimer();

	$objAccount = new clsAccount;
	$objGroupMgmt = new clsGroupMgmt;

        // database connect
        $dbh = OpenDatabase($DBHost, $DbUser, $DbPass, $DbName);

        // get vars
	$accountid = $_POST["accountid"];
	$name = $_POST["name"];
	$group = $_POST["groupname"];
	$login = $_POST["login"];
	$url = $_POST["url"];
	$password = $_POST["password"];
	$password2 = $_POST["password2"];
	$masterpassword = $_POST["masterpassword"];
	$masterpassword2 = $_POST["masterpassword2"];
	$notice = $_POST["notice"];
	$savetyp = $_POST["savetyp"];
	$ssearch = $_POST["ssearch"];
	$sgroup = $_POST["sgroup"];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
        <TITLE><?php echo (HTML_TITLE) ?></TITLE>
        <LINK REL="stylesheet" HREF="styles.css" TYPE="text/css">
</HEAD>
<BODY>

<?php

        PrintHeader();

	$blnError = FALSE;

	if ( $savetyp == 1 ) {
		$strHeader = "add account";
        	if ( $name == "" ) {
			$strOutputText = "you have to use a accountname";
			$blnError = TRUE;
	         } elseif ( $login == "" ) {
			$strOutputText = "you have to use a login";
			$blnError = TRUE;
	        } elseif ( $password == "" ) {
			$strOutputText = "you have to use a password";
			$blnError = TRUE;
		} elseif ( $password != $password2 ) {
			$strOutputText = "the passwords doesn't match";
			$blnError = TRUE;
		} elseif ( $masterpassword == "" ) {
			$strOutputText = "you have to use a masterpassword";
			$blnError = TRUE;
		} elseif ( $masterpassword != $masterpassword2 ) {
			$strOutputText = "the masterpasswords doesen't match";
			$blnError = TRUE;
		}
	}

	if ( $savetyp == 2 ) {
		$strHeader = "change account";
	        if ( $name == "" ) {
			$strOutputText = "you have to use a accountname";
			$blnError = TRUE;
	        } elseif ( $login == "" ) {	
			$strOutputText = "you have to use a login";
			$blnError = TRUE;
	        }

}	

	if ( $savetyp == 3 ) {
		$strHeader = "delete account";
	}
	
	if ( $savetyp == 4 ) {
		$strHeader = "change account password";
	        if ( $password != $password2 ) {
			$strOutputText = "the passwords doesn't match";
			$blnError = TRUE;
	        } elseif ( $masterpassword == "" ) {	
			$strOutputText = "you have to use a masterpassword";
			$blnError = TRUE;
	        } elseif ( $masterpassword != $masterpassword2 ) {
			$strOutputText = "the masterpasswords doesn't match";
			$blnError = TRUE;
	        }
        	$changepass = 1;
	}

?>

<DIV ALIGN="center">
<H2><?php echo ($strHeader) ?></H2>
</DIV>

<?php

	if ( $blnError == TRUE ) {

?>

<DIV ALIGN="center">

<TABLE WIDTH="80%">
        <TR BGCOLOR="#dddddd">
                <TD ALIGN="center">
                        <B>ERROR: <?php echo ($strOutputText) ?></B>
                </TD>
        </TR>
</TABLE>

<BR><BR>


<TABLE WIDTH="80%">
        <TR>
                <TD ALIGN="center">
                        <FORM ACTION="index.php">
                                <INPUT TYPE="button" VALUE="back" CLASS="altButtonFormat" ONCLICK="javascript:history.back()">
                        </FORM>
                </TD>
        </TR>
</TABLE>

</DIV>

<?php

		die;
	}

	if ( $savetyp == 1 OR $savetyp == 4 ) {
		$objCrypt = new clsPpmCrypt;
		$blnCryptModule = $objCrypt->checkCryptModule();
		if ($blnCryptModule == FALSE ) {
			echo ("ERROR: can't use crypt module<BR><BR>");
			echo ("possible reasons:<BR>php-mcrypt module not installed<BR>problems with library libmcrypt");
			die;
		}
		$intCounter == 0;
		do {

			do {
				$strInitialVector = $objCrypt->createIV();
				$blnCheckIv = $objCrypt->checkIV($strInitialVector);
			} while ($blnCheckIv == FALSE);
			$password_encrypted = $objCrypt->encrypt($password, $masterpassword, $strInitialVector);
			$blnCheckEncrypted = $objCrypt->checkEncryptedPass($password_encrypted);
		} while ($blnCheckEncrypted == FALSE );
	}

	if ( $savetyp == 1 OR $savetyp == 2 ) {
		$groupid = $objGroupMgmt->GetGroupIdByGroupName($group);
	}

	switch ($savetyp) {
		case 1:
			$objAccount->strName = $name;
			$objAccount->intGroupId = $groupid;
			$objAccount->strLogin = $login;
			$objAccount->strUrl = $url;
			$objAccount->strPassword = $password_encrypted;
			$objAccount->strMd5Password = md5($password);
			$objAccount->strInitialVector = $strInitialVector;
			$objAccount->strNotice = $notice;
			$objAccount->createAccount();
			$strOutputText = "account created";
			break;
		case 2:
			$objAccount->intAccountId = $accountid;
			$objAccount->strName = $name;
			$objAccount->intGroupId = $groupid;
			$objAccount->strLogin = $login;
			$objAccount->strUrl = $url;
			$objAccount->strNotice = $notice;
			$objAccount->updateAccount();
			$strOutputText = "account updated";
			break;
		case 3:
			$objAccount->deleteAccount($accountid);
			$strOutputText = "account deleted";
			break;
		case 4:
			$objAccount->intAccountId = $accountid;
			$objAccount->strPassword = $password_encrypted;
			$objAccount->strMd5Password = md5($password);
			$objAccount->strInitialVector = $strInitialVector;
			$objAccount->updateAccountPass();
			$strOutputText = "account password updated";
			break;
	}

?>

<DIV ALIGN="center">

<TABLE WIDTH="80%">
        <TR BGCOLOR="#dddddd">
                <TD ALIGN="center">
                        <B><?php echo ($strOutputText) ?></B>
                </TD>
        </TR>
</TABLE>

<BR><BR>

<TABLE WIDTH="80%">
        <TR>
                <TD ALIGN="center">
                        <FORM ACTION="index.php">
                                <INPUT TYPE="submit" VALUE="back" CLASS="altButtonFormat" ACCESSKEY="b">
                        </FORM>
                </TD>
        </TR>
</TABLE>

<BR><BR>
<TABLE CLASS="altTableHelp">
        <TR>
                <TD>
                        <B>alt&b:</B> back
                </TD>
        </TR>
</TABLE>

</DIV>

<?php

        mysql_close($dbh);

        PrintFooter();

        $intRenderTime=StopRendertimer();
        PrintRenderTime ($ininttRenderTime);

?>

</BODY>
</HTML>
