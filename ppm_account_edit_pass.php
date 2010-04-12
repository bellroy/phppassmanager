<?php

        require_once("config.php");
        require_once("constants.inc");
        require_once("functions/db.php");
        require_once("functions/pagedesign.php");
        require_once("classes/clsPpmAccount.php");

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
<BODY ONLOAD="document.editpass.password.focus()">

<?php

        PrintHeader();

?>

<DIV ALIGN="center">
<H2>edit account password</H2>

<FORM ACTION="ppm_account_save.php" METHOD="post" NAME="editpass">
<TABLE WIDTH="80%">
	<TR CLASS="odd">
		<TD ALIGN="right">Name:</TD>
		<TD><?php echo ($objAccount->strName) ?></TD>
	</TR>
	<TR CLASS="even">
		<TD WIDTH="25%" ALIGN="right">Group:</TD>
		<TD><?php echo ($objAccount->strGroupName) ?></TD>
	</TR>
	<TR CLASS="odd">
		<TD WIDTH="25%" ALIGN="right">Login:</TD>
		<TD><?php echo ($objAccount->strLogin) ?></TD>
	</TR>
        <TR CLASS="even">
                <TD WIDTH="25%" ALIGN="right">URL:</TD>
                <TD><?php echo ("<A HREF=\"" . $objAccount->strUrl . "\" target=\"_blank\">" . $objAccount->strUrl) ?></TD>
        </TR>
	<TR CLASS="odd">
		<TD width=25% ALIGN=right>Password:</TD>
		<TD>
			<INPUT TYPE="password" SIZE="100" NAME="password">
		</TD>
	</TR>
	<TR CLASS="even">
		<TD width="25%" ALIGN=right>Password (verfiy):</TD>
		<TD>
			<INPUT TYPE="password" SIZE="100" NAME="password2">
		</TD>
	</TR>
	<TR CLASS="odd">
		<TD width="25%" ALIGN="right">Masterpassword:</TD>
		<TD>
			<INPUT TYPE="password" SIZE="100" NAME="masterpassword">
		</TD>
	</TR>
	<TR CLASS="even">
		<TD width="25%" ALIGN="right">Masterpassword (verify):</TD>
		<TD>
			<INPUT TYPE="password" SIZE="100" NAME="masterpassword2">
		</TD>
	</TR>
</TABLE>

<BR><BR>

<TABLE WIDTH="80%">
	<TR ALIGN="center">
		<TD>
			<INPUT TYPE="hidden" NAME="savetyp" VALUE="4">
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

	mysql_close($dbh);

        PrintFooter();

        $intRenderTime=StopRendertimer();
        PrintRenderTime ($intRenderTime);

?>

</DIV>

</BODY>
</HTML>
