<?php

define("PROJECT_VERSION","0.91.0");
define("PROJECT_NAME","phpPasswordManager");
define("PROJECT_COPYRIGHT","© 2010");
define("PROJECT_AUTHOR","hollow, Jon Higgs");
define("PROJECT_AUTHOR_EMAIL","hollow_@users.sourceforge.net");
define("PROJECT_HP_SF","http://sourceforge.net/projects/phppassmanager");
define("PROJECT_HP_GH","http://github.com/tricycle/phppassmanager");

$domain_parts = preg_split("/\./", $_SERVER['SERVER_NAME']);

define("SITE_NAME", $domain_parts[0]);
define("SITE_ADMIN", "Jon");

define("HTML_HEADER", ucwords(SITE_NAME) . " Passwords");
define("HTML_TITLE", ucwords(SITE_NAME) . " Passwords");
define("CONFIG_FILE", "config-" . strtolower(SITE_NAME) . ".php"); 
define("COMMON_MASTER_PASS", TRUE); 
define("MASTER_PASS", ' ');


include $_SERVER['DOCUMENT_ROOT']."/ppm_auth.php"; 
?>
