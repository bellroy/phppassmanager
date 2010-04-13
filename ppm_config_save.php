<?php

        require_once("constants.inc");
        require_once(CONFIG_FILE);
        require_once("classes/clsPpmAccount.php");
        require_once("classes/clsPpmConfig.php");
        require_once("functions/db.php");
        require_once("functions/pagedesign.php");

        StartRenderTimer();

        // database connect
        $dbh = OpenDatabase($DBHost, $DbUser, $DbPass, $DbName);

        // get vars
	$blnPasswordShow = $_POST["password_show"];
	$blnAccountLink = $_POST["account_link"];
	$blnMd5Password = $_POST["md5_pass"];
	$blnMd5PasswordOld = $_POST["md5_pass_old"];
	if ( $_POST["account_count"] == "all" ) {
		$intAccountCount = 99;
	} else {
		$intAccountCount = $_POST["account_count"];
	}

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

?>


<DIV ALIGN="center">
<H2><?php echo ($strHeader) ?></H2>
</DIV>


<?php

	$clsConfig = new clsConfig;

	$clsConfig->arrConfigValue["password_show"] = $blnPasswordShow;
	$clsConfig->arrConfigValue["account_link"] = $blnAccountLink;
	$clsConfig->arrConfigValue["account_count"] = $intAccountCount;
	$clsConfig->arrConfigValue["md5_pass"] = $blnMd5Password;
	$clsConfig->writeConfig();

	if ($blnMd5Password == "FALSE" AND $blnMd5PasswordOld == "TRUE") {
		$clsAccount = new clsAccount;
		$clsAccount->ResetAllAccountMd5Pass();
	}

	$strOutputText = "config saved";

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
        PrintRenderTime ($intRenderTime);

?>

</BODY>
</HTML>
