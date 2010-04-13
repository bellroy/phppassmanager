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
        $strMd5Sum = $_POST["md5sum"];
        $strSortKey = $_POST["skey"];
        $strSortOrder = $_POST["sorder"];
        $strGroup = $_POST["group"];
        $strSearch = $_POST["search"];
        $intPage = $_POST["page"];

	$objAccount->writeAccountMd5Pass($strMd5Sum,$intAccountId);

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
<H2>save password checksum</H2>

<DIV ALIGN="center">

<TABLE WIDTH="80%">
        <TR BGCOLOR="#DDDDDD">
                <TD ALIGN="center">
                        <B>Password checksum written</B>
                </TD>
        </TR>
</TABLE>

<BR><BR>

<TABLE WIDTH="80%">
        <TR>
                <TD ALIGN="center">
                        <FORM ACTION="index.php">
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
