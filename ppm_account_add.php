<?php

        require_once("constants.inc");
        require_once(CONFIG_FILE);
        require_once("functions/db.php");
        require_once("functions/pagedesign.php");

        StartRenderTimer();

        // database connect
        $dbh = OpenDatabase($DBHost, $DbUser, $DbPass, $DbName);

	$strSortKey = $_POST["skey"];
	$strSortOrder = $_POST["sorder"];
	$strGroup = $_POST["group"];
	$strSearch = $_POST["search"];
	$intPage = $_POST["page"];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
	<TITLE><?php echo (HTML_TITLE) ?></TITLE>
        <LINK REL="stylesheet" HREF="styles.css" TYPE="text/css">
	<SCRIPT src="javascript/randompass.js" LANGUAGE="javascript" TYPE="text/javascript"></SCRIPT>
</HEAD>
<BODY ONLOAD="document.addaccount.name.focus()">

<?php

        PrintHeader();

?>

<DIV ALIGN="center">
<H2>add account</H2>

<FORM ACTION="ppm_account_save.php" METHOD="post" NAME="addaccount">
<TABLE WIDTH="80%">
	<TR CLASS="odd">
		<TD WIDTH="25%" ALIGN="right">Name:</TD>
		<TD WIDTH="75%">
				<INPUT NAME="name" TYPE="text" SIZE="30" MAXLENGTH="255">
		</TD>
	</TR>

	<TR CLASS="even">
		<TD WIDTH="25%" ALIGN="right">Group:</TD>
		<TD WIDTH="75%">
			<SELECT NAME="groupname" SIZE="1" CLASS="altButtonFormatDD">

<?php

	$strQuery = "SELECT intGroupId, vacGroupName FROM groups";
	$resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());

	while ($arrRow = mysql_fetch_array($resResult, MYSQL_ASSOC)) { ?>
		<OPTION><?php echo ($arrRow["vacGroupName"]) ?></OPTION> <?php
	}

	mysql_free_result($resResult);

	mysql_close($dbh);

?>

			</SELECT>
		</TD>
	</TR>

	<TR CLASS="odd">
		<TD WIDTH=25% ALIGN=right>Login:</TD>
		<TD WIDTH=75%>
			<INPUT NAME="login" TYPE="text" SIZE="30" MAXLENGTH="255">
		</TD>
	</TR>

	<TR CLASS="even">
		<TD WIDTH=25% ALIGN=right>URL:</TD>
		<TD WIDTH=75%>
			<INPUT NAME="url" TYPE="text" SIZE="30" MAXLENGTH="255">
		</TD>
	</TR>

	<TR CLASS="odd">
		<TD WIDTH=25% ALIGN=right>Password:</TD>
		<TD WIDTH=75%>
			<INPUT NAME="password" TYPE="password" SIZE="30" MAXLENGTH="255">
		</TD>
	</TR>

	<TR CLASS="even">
		<TD WIDTH=25% ALIGN=right>Password (verfy):</TD>
		<TD WIDTH=75%>
			<INPUT NAME="password2" TYPE="password" SIZE="30" MAXLENGTH="255">
		</TD>
	</TR>

	<TR CLASS="odd">
		<TD WIDTH=25% ALIGN=right>Masterpassword:</TD>
		<TD WIDTH=75%>
			<INPUT NAME="masterpassword" TYPE="password" SIZE="30" MAXLENGTH="255">
		</TD>
	</TR>

	<TR CLASS="even">
		<TD WIDTH=25% ALIGN=right>Masterpassword (verify):</TD>
		<TD WIDTH=75%>
			<INPUT NAME="masterpassword2" TYPE="password" SIZE="30" MAXLENGTH="255">
		</TD>
	</TR>

	<TR CLASS="odd">
		<TD WIDTH=25% ALIGN=right>Notice:</TD>
		<TD WIDTH=75%>
			<TEXTAREA NAME="notice" TYPE="text" COLS="30" ROWS="5" MAXLENGTH="255"></TEXTAREA>
		</TD>
	</TR>

</TABLE>

<BR><BR>

<TABLE WIDTH="80%">
	<TR ALIGN="center">
		<TD WIDTH="50%">
			<INPUT TYPE="hidden" NAME="savetyp" value="1">
			<INPUT TYPE="submit" value="save" class="altButtonFormat" ACCESSKEY="s">
			</FORM>
		</TD>
		<TD WIDTH="50%">
			<FORM ACTION="index.php" METHOD="get">
				<INPUT TYPE="hidden" NAME="skey" VALUE="<?php echo ($strSortKey) ?>">
				<INPUT TYPE="hidden" NAME="sorder" VALUE="<?php echo ($strSortOrder) ?>">
				<INPUT TYPE="hidden" NAME="group" VALUE="<?php echo ($strGroup) ?>">
				<INPUT TYPE="hidden" NAME="search" VALUE="<?php echo ($strSearch) ?>">
				<INPUT TYPE="hidden" NAME="page" VALUE="<?php echo ($intPage) ?>">
				<INPUT TYPE="submit" value="back" CLASS="altButtonFormat" ACCESSKEY="b">
			</FORM>
		</TD>
	</TR>
</TABLE>

</FORM>

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

        PrintFooter();

        $intRenderTime=StopRendertimer();

        PrintRenderTime ($intRenderTime);

?>

</DIV>

</BODY>
</HTML>
