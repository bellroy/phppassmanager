<?php

$AuthUserFile = file($_SERVER['DOCUMENT_ROOT'].'/htpasswd-'. SITE_NAME);
$realm = "Members";

function authenticate(){
    header("WWW-Authenticate: Basic realm=\"$realm\"");
    header('HTTP/1.0 401 Unauthorized');
    echo "You must enter a valid user name and password to access the requested resource.";
    exit;
}

for(; 1; authenticate()){
    if (!isset($HTTP_SERVER_VARS['PHP_AUTH_USER']))
        continue;

    $user = $HTTP_SERVER_VARS['PHP_AUTH_USER'];
    if(!($authUserLine = array_shift(preg_grep("/$user:.*$/", $AuthUserFile))))
        continue;

    preg_match("/$user:((..).*)$/", $authUserLine, $matches);
    $authPW = $matches[1];
    $salt = $matches[2];
    $submittedPW = crypt($HTTP_SERVER_VARS['PHP_AUTH_PW'], $salt);
    if($submittedPW != $authPW)
        continue;


    break;
}

?>
