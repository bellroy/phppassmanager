<?php

	require_once("config.php");
	require_once("constants.inc");
	require_once("functions/db.php");
	require_once("functions/pagedesign.php");
	require_once("classes/clsPpmConfig.php");
	require_once("classes/clsPpmAccount.php");

	StartRenderTimer();

	// database connect
	$dbh = OpenDatabase($DBHost, $DbUser, $DbPass, $DbName);

	$clsConfig = new clsConfig;
	$clsAccount = new clsAccount;
	$blnAccountLink = $clsConfig->getConfigValue("account_link");
	$intAccountCount = $clsConfig->getConfigValue("account_count");

	// get group an searchstring
	$strSortKey = $_GET["skey"];
	$strSortOrder = $_GET["sorder"];
	$strGroup = $_GET["group"];
	$strSearch = $_GET["search"];
	$intPage = $_GET["page"];

	// first website call, set group = all
	if ( $strGroup == "" ) {
	        $strGroup = "all";
	}

	if ( $strSortKey == "" ) {
		$strSortKey = 1;
	}

	if ( $strSortOrder == "" ) {
		$strSortOrder = "ASC";
	}

	if ( $intPage == "" ) {
		$intPage = 1;
	}

	$strNameLink = "skey=1&sorder=ASC&group=$strGroup&search=$strSearch";
	$strGroupLink = "skey=2&sorder=ASC&group=$strGroup&search=$strSearch";
	$strLoginLink = "skey=3&sorder=ASC&group=$strGroup&search=$strSearch";
	$strUrlLink = "skey=4&sorder=ASC&group=$strGroup&search=$strSearch";

	switch ($strSortKey) {
		case 1:
			$strOrder = "vacName $strSortOrder";
			if ($strSortOrder == "ASC") {
				$strNameLink = "skey=1&sorder=DESC&group=$strGroup&search=$strSearch";
			}
			break;
                case 2:
                        $strOrder = "vacGroupName $strSortOrder";
                        if ($strSortOrder == "ASC") {
                                $strGroupLink = "skey=2&sorder=DESC&group=$strGroup&search=$strSearch";
                        }
			break;
                case 3:
                        $strOrder = "vacLogin $strSortOrder";
                        if ($strSortOrder == "ASC") {
                                $strLoginLink = "skey=3&sorder=DESC&group=$strGroup&search=$strSearch";
                        }
			break;
                case 4:
                        $strOrder = "vacUrl $strSortOrder";
                        if ($strSortOrder == "ASC") {
                                $strUrlLink = "skey=4&sorder=DESC&group=$strGroup&search=$strSearch";
                        }
			break;
	}

	$intLimitStart = (($intPage - 1) * $intAccountCount) ;
	$intLimitCount = $intAccountCount;

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

<TABLE WIDTH="80%">
	<TR>
		<TD WIDTH="50%" ALIGN="right">
			<FORM ACTION="index.php" METHOD="get">
				group:
				<INPUT TYPE="hidden" NAME="skey" VALUE="<?php echo ($strSortKey) ?>">
				<INPUT TYPE="hidden" NAME="sorder" VALUE="<?php echo ($strSortOrder) ?>">
				<SELECT NAME="group" SIZE="1" CLASS="altButtonFormatDD">
				<OPTION SELECTED>all</OPTION>

<?php

	$intFilterId = 0;
	$strQuery = "SELECT intGroupId, vacGroupName FROM groups";
	$resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());

	while ($arrRow = mysql_fetch_array($resResult, MYSQL_ASSOC)) {
		if ( $strGroup == $arrRow["vacGroupName"] ) { ?>
				<OPTION SELECTED><?php echo ($arrRow["vacGroupName"]) ?></OPTION>
<?php
			if ( $strGroup == $arrRow["vacGroupName"] ) {
				$intFilterId = $arrRow["intGroupId"];
			}
		} else { ?>
				<OPTION><?php echo ($arrRow["vacGroupName"]) ?></OPTION>
<?php
		}
	}

	mysql_free_result($resResult);

?>

				</SELECT>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;search keyword:
				<INPUT TYPE="text" NAME="search" VALUE="<?php echo ($strSearch) ?>" ACCESSKEY="k">
				<INPUT TYPE="hidden" NAME="page" VALUE="1">
				<INPUT TYPE="submit" VALUE="search" CLASS="altButtonFormat" ACCESSKEY="s">
			</FORM>
		</TD>
		</TD>
		<TD ALIGN=LEFT>
			<FORM ACTION="index.php" METHOD="get">
				<INPUT TYPE="hidden" NAME="skey" VALUE="<?php echo ($strSortKey) ?>">
				<INPUT TYPE="hidden" NAME="sorder" VALUE="<?php echo ($strSortOrder) ?>">
				<INPUT TYPE="hidden" NAME="group" VALUE="all">
				<INPUT TYPE="hidden" NAME="search" VALUE="">
				<INPUT TYPE="hidden" NAME="page" VALUE="1">
				<INPUT TYPE="submit" VALUE="clear" CLASS="altButtonFormat" ACCESSKEY="c">
			</FORM>
		</TD>
		<TD ALIGN="center">
			<TABLE CLASS="altTable">
				<TR>
					<TD>
						<FORM ACTION="ppm_account_add.php" METHOD="post">
							<INPUT TYPE="hidden" NAME="skey" VALUE="<?php echo ($strSortKey) ?>">
							<INPUT TYPE="hidden" NAME="sorder" VALUE="<?php echo ($strSortOrder) ?>">
							<INPUT TYPE="hidden" NAME="group" VALUE="<?php echo ($strGroup) ?>">
							<INPUT TYPE="hidden" NAME="search" VALUE="<?php echo ($strSearch) ?>">
							<INPUT TYPE="hidden" NAME="page" VALUE="<?php echo ($intPage) ?>">
							<INPUT TYPE="submit" VALUE="add account" CLASS="altButtonFormat" ACCESSKEY="a">
						</FORM>
					</TD>
					<TD>
						<FORM ACTION="ppm_config.php" METHOD="post">
							<INPUT TYPE="hidden" NAME="skey" VALUE="<?php echo ($strSortKey) ?>">
							<INPUT TYPE="hidden" NAME="sorder" VALUE="<?php echo ($strSortOrder) ?>">
							<INPUT TYPE="hidden" NAME="group" VALUE="<?php echo ($strGroup) ?>">
							<INPUT TYPE="hidden" NAME="search" VALUE="<?php echo ($strSearch) ?>">
							<INPUT TYPE="hidden" NAME="page" VALUE="<?php echo ($intPage) ?>">
							<INPUT TYPE="submit" VALUE="ppm config" CLASS="altButtonFormat" ACCESSKEY="g">
						</FORM>
					</TD>
				</TR>
			</TABLE>
		</TD>
	</TR>
</TABLE>

<BR>

<TABLE WIDTH="80%">
	<TR CLASS="header">
		<TH WIDTH="15%"><A HREF="index.php?<?php echo ($strNameLink) ?>">Name</A></TH>
		<TH WIDTH="10%"><A HREF="index.php?<?php echo ($strGroupLink) ?>">Group</A></TH>
		<TH WIDTH="15%"><A HREF="index.php?<?php echo ($strLoginLink) ?>">Login</A></TH>
		<TH WIDTH="20%"><A HREF="index.php?<?php echo ($strUrlLink) ?>">URL</A></TH>
		<TH WIDTH="20%">Notice</TH>
		<TH WIDTH="20%">Commands</TH>

<?php

	if ( $strSearch != "" ) {
		$strSearchstring = " vacName LIKE '%$strSearch%' OR vacLogin LIKE '%$strSearch%' ";
		$strSearchstring .= "OR vacUrl LIKE '%$strSearch%' OR txtNotice LIKE '%$strSearch%'";
	}
	if ( $strGroup == "all" ) {
		$strQuery = "SELECT intAccountId, vacName, vacGroupName, vacLogin, vacUrl, txtNotice FROM accounts ";
		$strQuery .= "LEFT JOIN groups ON accounts.intGroupFid=groups.intGroupId";
		$strQuery2 = "SELECT COUNT(intAccountId) AS Number FROM accounts";
		if ( $strSearch != "" ) {
			$strQuery = $strQuery . " WHERE " . $strSearchstring;
			$strQuery2 = $strQuery2 . " WHERE " . $strSearchstring;
		}
		$strQuery .= " ORDER BY $strOrder";
		if ($intAccountCount != 99 ) {
			$strQuery .= " LIMIT $intLimitStart, $intLimitCount";
		}
	} else {
		$strQuery = "SELECT intAccountId, vacName, vacGroupName, vacLogin, vacUrl, txtNotice FROM accounts ";
		$strQuery .= "LEFT JOIN groups ON accounts.intGroupFid=groups.intGroupId WHERE intGroupId = $intFilterId";
		$strQuery2 = "SELECT COUNT(intAccountId) AS Number FROM accounts WHERE intGroupFid = $intFilterId";
		if ( $strSearch != "" ) {
			$strQuery = $strQuery . " AND (" . $strSearchstring . ")";
			$strQuery2 = $strQuery2 . " AND (" . $strSearchstring . ")";
		}
		$strQuery .= " ORDER BY $strOrder";
		if ($intAccountCount != 99 ) {
			$strQuery .= " LIMIT $intLimitStart, $intLimitCount";
		}
	}

	$resResult = mysql_query($strQuery2) or die("query failed: " . mysql_error());
	$arrRow = mysql_fetch_array($resResult, MYSQL_ASSOC);
	$intAccountMax = $arrRow["Number"];
	$intPageMax = ceil($intAccountMax / $intAccountCount);
        mysql_free_result($resResult);

	$resResult = mysql_query($strQuery) or die("query failed: " . mysql_error());

	$strTableClass = "odd";
	while ($arrRow = mysql_fetch_array($resResult, MYSQL_ASSOC)) {
		$strNotice = $arrRow["txtNotice"];
		if (strlen($strNotice) > 100 ) {
			$strNotice = substr($strNotice, 0, 97) . "...";
		}

?>	

	<TR CLASS="<?php echo ($strTableClass) ?>">
		<TD>

<?php

	if ( $blnAccountLink == "TRUE" ) {
		$intAccountId = $arrRow["intAccountId"];
		$strName = $arrRow["vacName"];
		echo ("<A HREF=\"ppm_account_view.php?id=$intAccountId\">$strName</A>");
	} else {
		echo ($arrRow["vacName"]);
	}

 ?>
		</TD>
		<TD><?php echo ($arrRow["vacGroupName"]) ?></TD>
		<TD><?php echo ($arrRow["vacLogin"]) ?></TD>
		<TD><?php echo ("<A HREF=\"" . $arrRow["vacUrl"] . "\" target=\"_blank\">" . $arrRow["vacUrl"]) ?></TD>
		<TD><?php echo ($strNotice) ?></TD>
		<TD ALIGN="center">
			<TABLE CLASS="altTable">
				<TR>
					<TD>
						<FORM ACTION="ppm_account_view.php" METHOD="post">
							<INPUT TYPE="hidden" NAME="accountid" VALUE="<?php echo ($arrRow["intAccountId"]) ?>">
							<INPUT TYPE="hidden" NAME="decode" VALUE="0">
							<INPUT TYPE="hidden" NAME="skey" VALUE="<?php echo ($strSortKey) ?>">
							<INPUT TYPE="hidden" NAME="sorder" VALUE="<?php echo ($strSortOrder) ?>">
							<INPUT TYPE="hidden" NAME="group" VALUE="<?php echo ($strGroup) ?>">
							<INPUT TYPE="hidden" NAME="search" VALUE="<?php echo ($strSearch) ?>">
							<INPUT TYPE="hidden" NAME="page" VALUE="<?php echo ($intPage) ?>">
							<INPUT TYPE="submit" VALUE="View" CLASS="altButtonFormat">
						</FORM>
					</TD>

					<TD>
						<FORM ACTION="ppm_account_edit.php" method="post">
							<INPUT TYPE="hidden" NAME="accountid" VALUE="<?php echo ($arrRow["intAccountId"]) ?>">
							<INPUT TYPE="hidden" NAME="decode" VALUE="0">
							<INPUT TYPE="hidden" NAME="skey" VALUE="<?php echo ($strSortKey) ?>">
							<INPUT TYPE="hidden" NAME="sorder" VALUE="<?php echo ($strSortOrder) ?>">
							<INPUT TYPE="hidden" NAME="group" VALUE="<?php echo ($strGroup) ?>">
							<INPUT TYPE="hidden" NAME="search" VALUE="<?php echo ($strSearch) ?>">
							<INPUT TYPE="hidden" NAME="page" VALUE="<?php echo ($intPage) ?>">
							<INPUT TYPE="submit" VALUE="Edit" CLASS="altButtonFormat">
						</FORM>
					</TD>

					<TD>
						<FORM ACTION="ppm_account_edit_pass.php" METHOD="post">
							<INPUT TYPE="hidden" NAME="accountid" VALUE="<?php echo ($arrRow["intAccountId"]) ?>">
							<INPUT TYPE="hidden" NAME="decode" VALUE="0">
							<INPUT TYPE="hidden" NAME="skey" VALUE="<?php echo ($strSortKey) ?>">
							<INPUT TYPE="hidden" NAME="sorder" VALUE="<?php echo ($strSortOrder) ?>">
							<INPUT TYPE="hidden" NAME="group" VALUE="<?php echo ($strGroup) ?>">
							<INPUT TYPE="hidden" NAME="search" VALUE="<?php echo ($strSearch) ?>">
							<INPUT TYPE="hidden" NAME="page" VALUE="<?php echo ($intPage) ?>">
							<INPUT TYPE="submit" VALUE="Edit pass" CLASS="altButtonFormat">
						</FORM>
					</TD>

					<TD>
						<FORM ACTION="ppm_account_view.php" METHOD="post">
							<INPUT TYPE="hidden" NAME="accountid" VALUE="<?php echo ($arrRow["intAccountId"]) ?>">
							<INPUT TYPE="hidden" NAME="delete" VALUE="1">
							<INPUT TYPE="submit" VALUE="Delete" CLASS="altButtonFormat">
							<INPUT TYPE="hidden" NAME="skey" VALUE="<?php echo ($strSortKey) ?>">
							<INPUT TYPE="hidden" NAME="sorder" VALUE="<?php echo ($strSortOrder) ?>">
							<INPUT TYPE="hidden" NAME="group" VALUE="<?php echo ($strGroup) ?>">
							<INPUT TYPE="hidden" NAME="search" VALUE="<?php echo ($strSearch) ?>">
							<INPUT TYPE="hidden" NAME="page" VALUE="<?php echo ($intPage) ?>">
						</FORM>
					</TD>
				</TR>
			</TABLE>
		</TD>
	</TR>

<?php

	if ($strTableClass == "odd") {
		$strTableClass = "even";
	} else {
		$strTableClass = "odd";
	}
}

?>

</TABLE>

<TABLE WIDTH="80%" CLASS="altTable">
	<TR>
		<TD ALIGN="LEFT">

<?php

	echo ("Page " . $intPage . " / " . $intPageMax . " - filter: ");
	if ( $strSearch != "" OR $strGroup != "all"  ) {

?>

		<B CLASS="altTextRed">on</B>

<?php

	} else {

?>

		<B CLASS="altTextGreen">off</B>

<?php

	}
	echo (" - accounts: " . $intAccountMax);
	echo (" / " . $clsAccount->getAccountMax());

?>

		</TD>

		<TD ALIGN="right">

<?php

	if ( $intPage > 1 ) {

?>

			<A HREF="index.php
				?skey=<?php echo ($strSortKey) ?>
				&sorder=<?php echo ($strSortOrder) ?>
				&group=<?php echo ($strGroup) ?>
				&search=<?php echo ($strSearch) ?>
				&page=1" ACCESSKEY="f">&laquo;</A>

			<A HREF="index.php
				?skey=<?php echo ($strSortKey) ?>
				&sorder=<?php echo ($strSortOrder) ?>
				&group=<?php echo ($strGroup) ?>
				&search=<?php echo ($strSearch) ?>
				&page=<?php echo ($intPage - 1 ) ?>" ACCESSKEY="-">&lt;</A>
<?php

	} else {
		echo ("&laquo; &lt; ");
}

	for ( $intCounter = 1; $intCounter <= 10; $intCounter++) {
		if ( $intCounter > $intPageMax ) {
			break;
		}
		if ( $intCounter != $intPage ) {
?>

			<A HREF="index.php
				?skey=<?php echo ($strSortKey) ?>
				&sorder=<?php echo ($strSortOrder) ?>
				&group=<?php echo ($strGroup) ?>
				&search=<?php echo ($strSearch) ?>
				&page=<?php echo ($intCounter) ?>"><?php echo ($intCounter) ?></A>

<?php

		} else {
#			echo ("<B>$intCounter</B>");
			echo ("$intCounter");
		}
	}

	if ( $intPage < $intPageMax ) {
?>

			<A HREF="index.php
				?skey=<?php echo ($strSortKey) ?>
				&sorder=<?php echo ($strSortOrder) ?>
				&group=<?php echo ($strGroup) ?>
				&search=<?php echo ($strSearch) ?>
				&page=<?php echo ($intPage + 1 ) ?>" ACCESSKEY="+">&gt;</A>

			<A HREF="index.php
				?skey=<?php echo ($strSortKey) ?>
				&sorder=<?php echo ($strSortOrder) ?>
				&group=<?php echo ($strGroup) ?>
				&search=<?php echo ($strSearch) ?>
				&page=<?php echo ($intPageMax) ?>" ACCESSKEY="l">&raquo;</A>

<?php

	} else {
		echo (" &gt; &raquo;");
	}

?>

		</TD>
	</TR>
</TABLE>

<BR><BR>
<TABLE CLASS="altTableHelp">
	<TR>
		<TD>
			<B>alt&k:</B> search keyword
			<B>alt&s:</B> search
			<B>alt&c:</B> clear
			<B>alt&a:</B> add account
			<B>alt&g:</B> config
			<B>alt&+:</B> page forward
			<B>alt&-:</B> page back
			<B>alt&f:</B> first page
			<B>alt&l:</B> last page
		</TD>
	</TR>
</TABLE>

</DIV>

<?php

	mysql_free_result($resResult);

	mysql_close($dbh);

	PrintFooter();

	$intRenderTime=StopRendertimer();
	PrintRenderTime ($intRenderTime);

?>

</BODY>
</HTML>
