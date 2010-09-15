<?php

  require_once("constants.inc");
  require_once(CONFIG_FILE);
  require_once("functions/db.php");
  require_once("functions/pagedesign.php");
  require_once("classes/clsPpmCrypt.php");
  require_once("classes/clsPpmConfig.php");
  require_once("classes/clsPpmAccount.php");

  StartRenderTimer();

	$clsAccount = new clsAccount;
	$objCrypt = new clsPpmCrypt;

  // database connect
  $dbh = OpenDatabase($DBHost, $DbUser, $DbPass, $DbName);

	// get vars
	$intAccountId = $_POST["accountid"];
	$intDecode = $_POST["decode"];
	$intDelete = $_POST["delete"];
	$strMasterpass = $_POST["masterpass"];
	$strSortKey = $_POST["skey"];
	$strSortOrder = $_POST["sorder"];
	$strGroup = $_POST["group"];
	$strSearch = $_POST["search"];
	$intPage = $_POST["page"];


	$intAccountId_get = $_GET["id"];

	if ( $intAccountId_get != "" ) {
		$intAccountId = $intAccountId_get;
	}

	if ( $intDecode == 1 ) {
        	$clsAccount->incrementDecryptCounter($intAccountId);
	} else {
        	$clsAccount->incrementViewCounter($intAccountId);
	}

	$clsAccount->getAccount($intAccountId);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
	<TITLE><?php echo (HTML_TITLE) ?></TITLE>
  <LINK REL="stylesheet" HREF="styles.css" TYPE="text/css">
  <SCRIPT TYPE="text/javascript" SRC="javascript/zeroclipboard/ZeroClipboard.js"></SCRIPT>
</HEAD>
<BODY ONLOAD="javascript:document.showaccount.masterpass.focus()">

<?php

        PrintHeader();

?>

<DIV ALIGN="center">

<?php

	if ( $intDelete == 1 ) {
		print "<h2>delete account</h2>";
	} else {
		print "<h2>show account</h2>";
	}

	if ( $intDecode == 1 ) {
		if ( $strMasterpass == "" && COMMON_MASTER_PASS == false) {

?>

<H1>to decode you have to use a 'Masterpassword'!</H1>
<P>click <I><A HREF="javascript:history.back()">back</A></I> to go back</P>
</DIV>

<?php
			die;
		}
	}

//	$query = "SELECT intAccountId, vacName, vacGroupName, vacLogin, vacUrl, vacPassword, vacInitialValue, txtNotice, intCountView, intCountDecrypt, datAdded, datChanged FROM accounts LEFT JOIN groups ON accounts.intGroupFid=groups.intGroupId WHERE intAccountId = $intAccountIdid";
//	$result = mysql_query($query) or die("query failed: " . mysql_error());

//	$row = mysql_fetch_array($result, MYSQL_ASSOC);

	if ( $intDecode == 1 ) {
		$strDecrypted = $objCrypt->decrypt($clsAccount->strPassword, $strMasterpass, $clsAccount->strInitialVector);
	}

?>

<TABLE WIDTH="80%">
	<TR CLASS="odd">
		<TD ALIGN="right">Name:</TD>
		<TD><?php echo ($clsAccount->strName) ?></TD>
	</TR>
	<TR CLASS="even">
		<TD WIDTH="25%" ALIGN="right">Group:</TD>
		<TD><?php echo ($clsAccount->strGroupName) ?></TD>
	</TR>
	<TR CLASS="odd">
		<TD WIDTH="25%" ALIGN="right">Login:</TD>
		<TD><?php echo ($clsAccount->strLogin) ?></TD>
	</TR>
        <TR CLASS="even">
                <TD WIDTH="25%" ALIGN="right">URL:</TD>
                <TD><?php echo ("<A HREF=\"". $clsAccount->strUrl . "\" target=\"_blank\">" . $clsAccount->strUrl . "</A>") ?></TD>
        </TR>
	<TR CLASS="odd">
		<TD WIDTH="25%" ALIGN="right">Password:</TD>
		<TD>
			<TABLE CLASS="altTable" WIDTH="100%"><TR><TD>
<?php

	 if ( $intDecode == 1 ) {

		$clsConfig = new clsConfig;

		$blnNoMd5 = FALSE;
		if ( $clsConfig->getConfigValue("md5_pass") == "TRUE" ) {

			if ($clsAccount->strMd5Password != "0") {

				if (md5($strDecrypted) == $clsAccount->strMd5Password) {	
					$blnDecryptCheck = TRUE;

					if ( $clsConfig->getConfigValue("password_show") == "FALSE" ) {
						$strPasswordOutput = "password not shown - can only copy to clipboard";
					} 

          else {
			 			$strPasswordOutput = $strDecrypted;
					}

				}
        else {
					$strPasswordOutput = "<B CLASS=\"altTextRed\">Wrong Masterpassword!</B>";
					$blnDecryptCheck = FALSE;
				}

			}
      else {
				$blnDecryptCheck = TRUE;
				$blnNoMd5 = TRUE;
				$strPasswordOutput = htmlspecialchars($strDecrypted) . "<B CLASS=\"altTextRed\">**</B>";
			}
		} 
    else {

			if ( $clsConfig->getConfigValue("password_show") == "FALSE" ) {
				$blnDecryptCheck = TRUE;
				$strPasswordOutput = "password not shown - can only copy to clipboard";
			} 

      else {
				$blnDecryptCheck = TRUE;
				$strPasswordOutput = htmlspecialchars($strDecrypted);
			}
		}

		echo '<input type=text value="' . $strPasswordOutput . '" readonly=true></input>';

	 } 
   else {
		 echo ("not available - decrypted");} ?>

			<FORM ACTION="">

<?php if ( $intDecode == 1 AND $blnDecryptCheck == TRUE ) { ?>
			</TD>

      <?php
        // in here would go the button to copy password to clipboard
      ?>

<?php } ?>

			</TR></TABLE>
			</FORM>
		</TD>
	</TR>
	<TR CLASS="even">
		<TD WIDTH="25%" ALIGN="right">Notice:</TD>
		<TD><pre><?php echo ($clsAccount->strNotice) ?></pre></TD>
	</TR>
        <TR CLASS="odd">
                <TD WIDTH="25%" ALIGN="right">views:</TD>
                <TD><?php echo ($clsAccount->intCountView) ?></TD>
        </TR>
        <TR CLASS="even">
                <TD WIDTH="25%" ALIGN="right">decrypts:</TD>
                <TD><?php echo ($clsAccount->intCountDecrypt) ?></TD>
        </TR>
        <TR CLASS="odd">
                <TD WIDTH="25%" ALIGN="right">added:</TD>
                <TD><?php echo ($clsAccount->strDatAdded) ?></TD>
        </TR>
        <TR CLASS="even">
                <TD WIDTH="25%" ALIGN="right">changed:</TD>
                <TD><?php echo ($clsAccount->strDatChanged) ?></TD>
        </TR>
</TABLE>

<?php

	if ( $blnNoMd5 == TRUE ) {

?>

	<TABLE WIDTH="80%" CLASS="altTable">
		<TR>
			<TD ALIGN="right">
				<B CLASS="altTextRed">
					** can't verify password, because internal checksum not available.<BR>
					To write checksum press the button.
				</B>
			</TD>
			<TD>
		                        <FORM ACTION="ppm_account_md5_save.php" METHOD="post">
		                                <INPUT TYPE="hidden" NAME="accountid" VALUE="<?php echo ($intAccountId) ?>">
                		                <INPUT TYPE="hidden" NAME="md5sum" VALUE="<?php echo (md5($strDecrypted)) ?>">
		                                <INPUT TYPE="submit" VALUE="write checksum" CLASS="altButtonFormat" ACCESSKEY="d">
					</FORM>
			</TD>
		</TR>
	</TABLE>

<?php

	}

?>

<BR><BR>

<TABLE WIDTH="80%">
	<TR ALIGN="center">

<?php

	if ( $intDelete == 0 AND $intDecode == 0 ) {

?>

		<TD WIDTH="50%">
			<FORM ACTION="ppm_account_view.php" METHOD="post" NAME="showaccount">
				<INPUT TYPE="hidden" NAME="accountid" VALUE="<?php echo ($clsAccount->intAccountId) ?>">
				<INPUT TYPE="hidden" NAME="decode" VALUE="1">
				<INPUT TYPE="hidden" NAME="skey" VALUE="<?php echo ($strSortKey) ?>">
				<INPUT TYPE="hidden" NAME="sorder" VALUE="<?php echo ($strSortOrder) ?>">
				<INPUT TYPE="hidden" NAME="group" VALUE="<?php echo ($strGroup) ?>">
				<INPUT TYPE="hidden" NAME="search" VALUE="<?php echo ($strSearch) ?>">
				<INPUT TYPE="hidden" NAME="page" VALUE="<?php echo ($intPage) ?>">
				<INPUT TYPE="submit" VALUE="decode" CLASS="altButtonFormat" ACCESSKEY="d">
				<?php if (COMMON_MASTER_PASS == false) { ?>
        Masterpassword:
				<INPUT TYPE="password" NAME="masterpass">
        <?php } ?>
			</FORM>
		</TD>

<?php

	}
	if ( $intDelete == 1 ) {

?>

		<TD WIDTH="50%">
			<FORM ACTION="ppm_account_save.php" METHOD="post">
				<INPUT TYPE="hidden" NAME="accountid" VALUE="<?php echo ($clsAccount->intAccountId) ?>">
				<INPUT TYPE="hidden" NAME="savetyp" VALUE="3">
				<INPUT TYPE="hidden" NAME="skey" VALUE="<?php echo ($strSortKey) ?>">
				<INPUT TYPE="hidden" NAME="sorder" VALUE="<?php echo ($strSortOrder) ?>">
				<INPUT TYPE="hidden" NAME="group" VALUE="<?php echo ($strGroup) ?>">
				<INPUT TYPE="hidden" NAME="search" VALUE="<?php echo ($strSearch) ?>">
				<INPUT TYPE="hidden" NAME="page" VALUE="<?php echo ($intPage) ?>">
				<INPUT TYPE="submit" VALUE="delete" CLASS="altButtonFormat" ACCESSKEY="d">
			</FORM>
		</TD>

<?php

	}

?>

		<TD WIDTH="50%">
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

<?php

	if ( $intDelete == 0 AND $intDecode == 0 ) {

?>

                        <B>alt&d:</B> decode
                        <B>alt&b:</B> back

<?php

	} elseif ( $intDelete == 1 ) {

?>

                        <B>alt&d:</B> delete
                        <B>alt&b:</B> back

<?php

	} else {

?>

                        <B>alt&b:</B> back

<?php

	}

?>

                </TD>
        </TR>
</TABLE>

<?php

//	mysql_free_result($result);

	mysql_close($dbh);

        PrintFooter();

        $intRenderTime=StopRendertimer();
        PrintRenderTime ($intRenderTime);

?>

</DIV>

</BODY>
</HTML>
