<?php
        require_once("constants.inc");
        require_once(CONFIG_FILE);
        require_once("classes/clsPpmAccount.php");
        require_once("functions/db.php");
        require_once("functions/pagedesign.php");

        StartRenderTimer();

	// get vars
  $username = $_SERVER["PHP_AUTH_USER"];
  $password = $_POST["password"];
  $confirm  = $_POST["confirm"];

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
		print "<h2>generate password hash</h2>";
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

?>

<FORM ACTION="ppm_password_change.php" METHOD="post">
  <TABLE WIDTH="80%">
    <TR CLASS="even">
      <TD WIDTH="25%" ALIGN="right">Password:</TD>
      <TD><input type="password" maxlength="255" size="30" name="password"></TD>
    </TR>
    <TR CLASS="odd">
      <TD WIDTH="25%" ALIGN="right">Confirm Password:</TD>
      <TD><input type="password" maxlength="255" size="30" name="confirm"></TD>
    </TR>
  </TABLE>

  <br>

  <TABLE WIDTH="80%">
    <TR>
      <TD align="center"><INPUT TYPE="submit" VALUE="generate hash" CLASS="altButtonFormat" ACCESSKEY="g"></TD>
    <TR>
  </TABLE>
</FORM>

<?php

if ( strlen($username) && strlen($password) && $password == $confirm ) {

  $hash = "$username:" . crypt($password, 'rl');

?>

  <BR>
	<TABLE WIDTH="80%">
	<TR CLASS="odd">
		<TD ALIGN="right">Your password hash to email to <?php echo SITE_ADMIN ?>:</TD>
		<TD width="75%" CLASS="altTextRed"><b><?php echo $hash ?></b></TD>
	</TR>

	</TABLE>

<?php

}
elseif ($password != $confirm) {

?>


  <BR>
	<TABLE WIDTH="80%">
	<TR CLASS="odd">
		<TD CLASS="altTextRed"><b>Your passwords do not match</b></TD>
	</TR>

	</TABLE>

<?php

}


        PrintFooter();

        $intRenderTime=StopRendertimer();
        PrintRenderTime ($intRenderTime);

?>

</DIV>

</BODY>
</HTML>
