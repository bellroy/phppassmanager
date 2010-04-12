<?php

        require_once("config.php");
        require_once("constants.inc");
        require_once("classes/clsPpmConfig.php");
        require_once("classes/clsPpmVersion.php");
        require_once("functions/db.php");
        require_once("functions/pagedesign.php");

        StartRenderTimer();

        // database connect
        $dbh = OpenDatabase($DBHost, $DbUser, $DbPass, $DbName);

        $strMasterpass = $_POST["masterpass"];
        $strSortKey = $_POST["skey"];
        $strSortOrder = $_POST["sorder"];
        $strGroup = $_POST["group"];
        $strSearch = $_POST["search"];
        $intPage = $_POST["page"];

	$clsConfig = new clsConfig;

	$intAccountCount = $clsConfig->getConfigValue("account_count");

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
<H2>config</H2>


<TABLE WIDTH="80%" CLASS="altTable">
	<TR>
		<TD>groupconfig</TD>
	</TR>
</TABLE>

<TABLE WIDTH="80%">
        <TR CLASS="odd">
                <TD WIDTH="25%" ALIGN="right">add group:</TD>
                <TD WIDTH="75%">
				<FORM ACTION="ppm_group_mgmt.php" METHOD="post">
	                                <INPUT TYPE="text" NAME="GroupName" SIZE="28" MAXLENGTH="255">
	                                <INPUT TYPE="hidden" NAME="GroupFunction" VALUE="1">
					<INPUT TYPE="submit" VALUE="add" CLASS="altButtonFormat">
				</FORM>
                </TD>
        </TR>

        <TR CLASS="even">
                <TD WIDTH="25%" ALIGN="right">change group:</TD>
                <TD WIDTH="75%">
                                <FORM ACTION="ppm_group_mgmt.php" METHOD="post">
                                       <SELECT NAME="GroupName" SIZE="1" CLASS="altButtonFormatDD">

<?php

        $query = "SELECT intGroupId, vacGroupName FROM groups";
        $result = mysql_query($query) or die("query failed: " . mysql_error());

        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) { ?>
                                	        <OPTION><?php echo ($row["vacGroupName"]) ?></OPTION> <?php
        }

        mysql_free_result($result);

?>

                                        </SELECT>
                                        <INPUT TYPE="text" NAME="GroupNameNew" SIZE="15">
                                        <INPUT TYPE="hidden" NAME="GroupFunction" VALUE="2">
                                        <INPUT TYPE="submit" VALUE="change" CLASS="altButtonFormat">
                                </FORM>
                </TD>
        </TR>

        <TR CLASS="odd">
                <TD WIDTH="25%" ALIGN="right">delete group:</TD>
                <TD WIDTH="75%">
                                <FORM ACTION="ppm_group_mgmt.php" METHOD="post">
                                       <SELECT NAME="GroupName" SIZE="1" CLASS="altButtonFormatDD">

<?php

        $query = "SELECT intGroupId, vacGroupName FROM groups";
        $result = mysql_query($query) or die("query failed: " . mysql_error());

        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) { ?>
			                	<OPTION><?php echo ($row["vacGroupName"]) ?></OPTION> <?php
        }

        mysql_free_result($result);

?>

		                        </SELECT>
                                        <INPUT TYPE="hidden" NAME="GroupFunction" VALUE="3">
                                        <INPUT TYPE="submit" VALUE="delete" CLASS="altButtonFormat">
                                </FORM>
                </TD>
        </TR>
</TABLE>

<BR><BR>

<FORM ACTION="ppm_config_save.php" METHOD="post">

<TABLE WIDTH="80%" CLASS="altTable">
	<TR>
		<TD>other config</TD>
	</TR>
</TABLE>

<TABLE WIDTH="80%">
	<TR CLASS="odd">
                <TD WIDTH="25%" ALIGN="right">show encrypted password</TD>
		<TD>
			<SELECT NAME="password_show" SIZE="1" CLASS="altButtonFormatDD">

<?php

	if ( $clsConfig->getConfigValue("password_show") == "TRUE" ) {

?>

				<OPTION SELECTED>TRUE</OPTION>
				<OPTION>FALSE</OPTION>

<?php

	} else {

?>

				<OPTION>TRUE</OPTION>
				<OPTION SELECTED>FALSE</OPTION>

<?php

	}

?>
			</SELECT>
		</TD>
		
	</TR>

	<TR CLASS="even">
		<TD WIDTH="25%" ALIGN="right">use account name as link</TD>
		<TD>
                        <SELECT NAME="account_link" SIZE="1" CLASS="altButtonFormatDD">

<?php

        if ( $clsConfig->getConfigValue("account_link") == "TRUE" ) {

?>

                                <OPTION SELECTED>TRUE</OPTION>
                                <OPTION>FALSE</OPTION>

<?php

        } else {

?>

                                <OPTION>TRUE</OPTION>
                                <OPTION SELECTED>FALSE</OPTION>

<?php

        }

?>
                        </SELECT>
		</TD>
	</TR>

	<TR CLASS="odd">
		<TD WIDTH="25%" ALIGN="right">show accounts per page</TD>
		<TD>
			<SELECT NAME="account_count" SIZE="1" CLASS="altButtonFormatDD">
				<OPTION <?php if ($intAccountCount == 1 ) { echo ("SELECTED"); } ?>>1</OPTION>
				<OPTION <?php if ($intAccountCount == 2 ) { echo ("SELECTED"); } ?>>2</OPTION>
				<OPTION <?php if ($intAccountCount == 3 ) { echo ("SELECTED"); } ?>>3</OPTION>
				<OPTION <?php if ($intAccountCount == 5 ) { echo ("SELECTED"); } ?>>5</OPTION>
				<OPTION <?php if ($intAccountCount == 10 ) { echo ("SELECTED"); } ?>>10</OPTION>
				<OPTION <?php if ($intAccountCount == 15 ) { echo ("SELECTED"); } ?>>15</OPTION>
				<OPTION <?php if ($intAccountCount == 20 ) { echo ("SELECTED"); } ?>>20</OPTION>
				<OPTION <?php if ($intAccountCount == 25 ) { echo ("SELECTED"); } ?>>25</OPTION>
				<OPTION <?php if ($intAccountCount == 30 ) { echo ("SELECTED"); } ?>>30</OPTION>
				<OPTION <?php if ($intAccountCount == 50 ) { echo ("SELECTED"); } ?>>50</OPTION>
				<OPTION <?php if ($intAccountCount == 99 ) { echo ("SELECTED"); } ?>>all</OPTION>
			</SELECT>
		</TD>
	</TR>

        <TR CLASS="even">
                <TD WIDTH="25%" ALIGN="right">on decode check password</TD>
                <TD>
			<INPUT TYPE="hidden" NAME="md5_pass_old" VALUE="<?php echo ($clsConfig->getConfigValue("md5_pass")) ?>">
                        <SELECT NAME="md5_pass" SIZE="1" CLASS="altButtonFormatDD">

<?php

        if ( $clsConfig->getConfigValue("md5_pass") == "TRUE" ) {

?>

                                <OPTION SELECTED>TRUE</OPTION>
                                <OPTION>FALSE</OPTION>

<?php

        } else {

?>

                                <OPTION>TRUE</OPTION>
                                <OPTION SELECTED>FALSE</OPTION>

<?php

        }

?>
                        </SELECT>
                </TD>
        </TR>

</TABLE>

<BR><BR>

<TABLE WIDTH="80%">
        <TR>
		<TD ALIGN="center">
			<INPUT TYPE="submit" VALUE="save" CLASS="altButtonFormat" ACCESSKEY="s">
			</FORM>

		</TD>
                <TD ALIGN="center">
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


<?php

/*	$objVersion = new clsVersion;
	$strVersion = $objVersion->getVersion();

	echo ("aktuelle Version: " . $strVersion);
*/
?>


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

