<?php

function PrintHeader() {

        echo ("<DIV ALIGN=\"center\">");
        echo ("<H1>" . HTML_HEADER. "</H1>");
        echo ("</DIV>");
}

function PrintFooter() {

	echo ("<BR><BR>");
	echo ("<DIV ALIGN=\"center\">");
	echo ("<B>" . PROJECT_NAME . "</B>, Version " . PROJECT_VERSION . "<BR>");
	echo ("Copyright " . PROJECT_COPYRIGHT . " by " . PROJECT_AUTHOR . "<BR>");
	echo ("<A HREF=\"" . PROJECT_HP_GH . "\">GitHub</A>");
	echo ("</DIV>");
}

function StartRenderTimer() {

	$RenderStartTime = microtime();
	
}

function StopRenderTimer() {

	$RenderStopTime = microtime();
	$RenderTime = $RenderStopTime - $RenderStartTime;
	return $RenderTime;
}

function PrintRenderTime($RenderTime) {

	echo ("<BR>");
	echo ("<DIV ALIGN=\"center\">");
	echo ("<P CLASS=\"footer\">[ created in  ". $RenderTime . " seconds ]</P>");
	echo ("</DIV>");
}

?>
