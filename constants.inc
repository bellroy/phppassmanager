<?php

define("PROJECT_VERSION","0.90.20");
define("PROJECT_NAME","phpPasswordManager");
define("PROJECT_COPYRIGHT","© 2006");
define("PROJECT_AUTHOR","hollow");
define("PROJECT_AUTHOR_EMAIL","hollow_@users.sourceforge.net");
define("PROJECT_HP_SF","http://sourceforge.net/projects/phppassmanager");

$domain_parts = split('\.', $_SERVER['SERVER_NAME']);
$title = ucwords($domain_parts[0]);

define("HTML_HEADER", "$title Passwords");
define("HTML_TITLE","$title Passwords");
?>
