<?php

define("PROJECT_VERSION","0.91.0");
define("PROJECT_NAME","phpPasswordManager");
define("PROJECT_COPYRIGHT","© 2010");
define("PROJECT_AUTHOR","hollow, Jon Higgs");
define("PROJECT_AUTHOR_EMAIL","hollow_@users.sourceforge.net");
define("PROJECT_HP_SF","http://sourceforge.net/projects/phppassmanager");
define("PROJECT_HP_GH","http://github.com/tricycle/phppassmanager");

$domain_parts = split('\.', $_SERVER['SERVER_NAME']);
$site_name = ucwords($domain_parts[0]);

define("HTML_HEADER", "$site_name Passwords");
define("HTML_TITLE","$site_name Passwords");
define("CONFIG_FILE", "config-" . strtolower($site_name) . ".php"); 
define("COMMON_MASTER_PASS", TRUE); 
define("MASTER_PASS", ' ');
?>
