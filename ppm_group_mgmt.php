<?php

        require_once("constants.inc");
        require_once(CONFIG_FILE);
        require_once("functions/db.php");
        require_once("functions/pagedesign.php");
        require_once("classes/clsPpmGroupMgmt.php");

        StartRenderTimer();

        // database connect
        $dbh = OpenDatabase($DBHost, $DbUser, $DbPass, $DbName);

	// get vars
	$intGroupFunction = $_POST["GroupFunction"];
	$strGroupName = $_POST["GroupName"];
	$strGroupNameNew = $_POST["GroupNameNew"];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
	<TITLE><?php echo (HTML_TITLE) ?></TITLE>
        <LINK REL="stylesheet" HREF="styles.css" TYPE="text/css">
	<SCRIPT SRC="clipboard.js" LANGUAGE="javascript" TYPE="text/javascript"></SCRIPT>
</HEAD>
<BODY>

<?php

        PrintHeader();

?>

<DIV ALIGN="center">
<H2>group config</H2>
</DIV>

<?php

	$clsGroupMgmt = new clsGroupMgmt;

	switch ($intGroupFunction) {
		case 1:
			if ( $strGroupName == "" ) {
				$strOutputText = "you have to use an group name";
			} else {
				$intGroupId = $clsGroupMgmt->GetGroupIdByGroupName($strGroupName);
				if ( $intGroupId == 0 ) {
					$clsGroupMgmt->GroupAdd($strGroupName);
					$strOutputText = "group added";
				} else {
					$strOutputText = "a already exists a group with that name";
				}
			}
			break;
		case 2:
                        if ( $strGroupNameNew == "" ) {
                                $strOutputText = "you must use a groupname";
                        } else {
                                $intGroupId = $clsGroupMgmt->GetGroupIdByGroupName($strGroupName);
				$intGroupNewId = $clsGroupMgmt->GetGroupIdByGroupName("$strGroupNameNew");
				if ( $intGroupNewId != 0 ) {
					$strOutputText = "it already exists a group with that name";
				} else {
	                                $clsGroupMgmt->GroupChangeByGroupId($intGroupId, $strGroupNameNew);
        	                        $strOutputText = "Groupname changed";
				}
                        }
                        break;
		case 3:
                        $intGroupId = $clsGroupMgmt->GetGroupIdByGroupName($strGroupName);
                        $intGroupCount = $clsGroupMgmt->IsGroupInUse($intGroupId);
                        if ( $intGroupCount != 0 ) {
                                $strOutputText = "Group is in use, delete not possible";
                        } else {
                                $clsGroupMgmt->GroupDelete($intGroupId);
                                $strOutputText = "Group deleted";
                        }
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
                        <FORM ACTION="ppm_config.php">
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

</DIV>

</BODY>
</HTML>
