<?php 
# THIS FILE DOES NOT WORK BECAUSE OF THIS:
#      From APACHE ITSELF:
#      
#      "http://httpd.apache.org/docs/howto/auth.html"
#      
#      How do I log out?
#      Since browsers first started implementing basic authentication, website administrators have wanted to know how to let the user log out. Since the browser caches the username and password with the authentication realm, as described earlier in this tutorial, this is not a function of the server configuration, but is a question of getting the browser to forget the credential information, so that the next time the resource is requested, the username and password must be supplied again. There are numerous situations in which this is desirable, such as when using a browser in a public location, and not wishing to leave the browser logged in, so that the next person can get into your bank account.
#      
#      However, although this is perhaps the most frequently asked question about basic authentication, thus far none of the major browser manufacturers have seen this as being a desirable feature to put into their products.
#      
#      Consequently, the answer to this question is, you can't. Sorry.

$_SERVER['PHP_AUTH_USER'] = ''; 
$_SERVER['PHP_AUTH_PW'] = ''; 

header("Location: http://" . $_SERVER['HTTP_HOST'])

?>
