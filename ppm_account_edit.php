<?php

        require_once("constants.inc");
        require_once(CONFIG_FILE);
        require_once("classes/clsPpmAccount.php");
        require_once("functions/db.php");
        require_once("functions/pagedesign.php");

        StartRenderTimer();

	$objAccount = new clsAccount;

        // database connect
        $dbh = OpenDatabase($DBHost, $DbUser, $DbPass, $DbName);

        // get vars
	$intAccountId = $_POST["accountid"];
	$intDecode = $_POST["decode"];
	$strMasterpass = $_POST["masterpass"];
	$strSortKey = $_POST["skey"];
	$strSortOrder = $_POST["sorder"];
	$strGroup = $_POST["group"];
	$strSearch = $_POST["search"];
	$intPage = $_POST["page"];

	$objAccount->getAccount($intAccountId);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
	<TITLE><?php echo (HTML_TITLE) ?></TITLE>
        <LINK REL="stylesheet" HREF="styles.css" TYPE="text/css">
</HEAD>
<BODY ONLOAD="document.editaccount.name.focus()">

<?php

        PrintHeader();

?>

<DIV ALIGN="center">
<H2>edit account</H2>

<FORM ACTION="ppm_account_save.php" METHOD="post" NAME="editaccount">
<TABLE WIDTH="80%">
	<TR CLASS="odd">
		<TD ALIGN="right">Name:</TD>
		<TD>
			<INPUT TYPE="text" NAME="name" SIZE="100" VALUE="<?php echo ($objAccount->strName) ?>">
		</TD>
	</TR>
	<TR CLASS="even">
		<TD WIDTH="25%" ALIGN="right">Group:</TD>
		<TD>
			<SELECT NAME="groupname" SIZE="1" CLASS="altButtonFormatDD">

<?php

	$strQuery = "SELECT intGroupId, vacGroupName FROM groups";
	$resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());

	while ($arrRow = mysql_fetch_array($resResult, MYSQL_ASSOC)) {
		if ( $objAccount->strGroupName == $arrRow["vacGroupName"] ) { ?>
			<OPTION SELECTED><?php echo ($arrRow["vacGroupName"]) ?></OPTION>
		<?php } else { ?>
		        <OPTION><?php echo ($arrRow["vacGroupName"]) ?></OPTION>
<?php
		}
	}

?>

			</SELECT>
		</TD>
	</TR>
	<TR CLASS="odd">
		<TD WIDTH="25%" ALIGN="right">Login:</TD>
		<TD>
			<INPUT TYPE="text" NAME="login" SIZE="100" VALUE="<?php echo ($objAccount->strLogin) ?>">
		</TD>
	</TR>
        <TR CLASS="even">
                <TD WIDTH="25%" ALIGN="right">URL:</TD>
                <TD>
                        <INPUT TYPE="text" NAME="url" SIZE="100" VALUE="<?php echo ($objAccount->strUrl) ?>">
                </TD>
        </TR>
	<TR CLASS="odd">
		<TD WIDTH="25%" ALIGN="right">Notice:</TD>
		<TD>
			<TEXTAREA NAME="notice" COLS="97" ROWS="5"><?php echo ($objAccount->strNotice) ?></TEXTAREA>
		</TD>
	</TR>
</TABLE>

<BR><BR>

<TABLE WIDTH="80%">
	<TR ALIGN="center">
		<TD>
			<INPUT TYPE="hidden" NAME="savetyp" VALUE="2">
			<INPUT TYPE="hidden" NAME="accountid" VALUE="<?php echo ($objAccount->intAccountId) ?>">
			<INPUT TYPE="hidden" NAME="skey" VALUE="<?php echo ($strSortKey) ?>">
			<INPUT TYPE="hidden" NAME="sorder" VALUE="<?php echo ($strSortOrder) ?>">
			<INPUT TYPE="hidden" NAME="group" VALUE="<?php echo ($strGroup) ?>">
			<INPUT TYPE="hidden" NAME="search" VALUE="<?php echo ($strSearch) ?>">
			<INPUT TYPE="hidden" NAME="page" VALUE="<?php echo ($intPage) ?>">
			<INPUT TYPE="submit" VALUE="save" CLASS="altButtonFormat" ACCESSKEY="s">
			</FORM>
		</TD>
		<TD>
			<FORM ACTION="index.php" METHOD="get">
				<INPUT TYPE="hidden" NAME="skey" VALUE="<?php echo ($strSortKey) ?>">
				<INPUT TYPE="hidden" NAME="sorder" VALUE="<?php echo ($strSortOrder) ?>">
				<INPUT TYPE="hidden" NAME="group" VALUE="<?php echo ($strGroup) ?>">
				<INPUT TYPE="hidden" NAME="search" VALUE="<?php echo ($strSearch) ?>">
				<INPUT TYPE="hidden" NAME="page" VALUE="<?php echo ($intPage) ?>">
				<INPUT TYPE="submit" VALUE="back" CLASS="altButtonFormat" ACCESSKEY="b">
			</FORM>
		</TD>
	</TR>
</TABLE>

<BR><BR>
<TABLE CLASS="altTableHelp">
        <TR>
                <TD>
                        <B>alt&s:</B> save
                        <B>alt&b:</B> back
                </TD>
        </TR>
</TABLE>

<?php

        mysql_free_result($resResult);

        mysql_close($dbh);

        PrintFooter();

        $intRenderTime=StopRendertimer();
        PrintRenderTime ($intRenderTime);

?>

</DIV>

</BODY>
</HTML>
