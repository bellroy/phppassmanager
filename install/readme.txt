README
======

IMPORTANT:
==========
In the accountview you have the possibility to copy the decrytped password to your clipboard.
If you use the firefox/mozilla browser you have to change your firefox security settings to use this feature.
Therefor add the fallowing line to your firefox/mozilla configfile (prefs.js). This file is located under your firefox user profile directory.
	user_pref("signed.applets.codebase_principal_support", true);
Another way is to change this setting directly over your browser interface.
Therefor call the URL "about:config", press the right button and insert a new boolean value
with name "signed.applets.codebase_principal_support" and the value "true".

It also make sense to protect the the phpPassManager pages with "htaccess" and use SSL to access the pages!



Requirements:
=============
- Apache
- PHP
- MySQL
- PHP mcrypt module



Install:
========

1: extract package
Extract the file phppassmanager-x.yy.zz.tgz in your webserver root directory.
On your shell you can do this with: tar -xfvz phppassmanager-x.yy.zz.tgz

2: create database
Create a MySQL database or use a already existing one.
For example on your shell you can create a databse this with command: echo "create database phppassmanager" | mysql -u username --password=password

3: create tables
Use the file "install/tables.sql" to create the tables.
You can do this for example with phpMyAdmin or on your shell: mysql -u username --password=password phppassmanager < tables.sql

4: create a db user
create a db user or use a existing one

5: edit config.php
Edit the file "config.php"
Fill in there your dbusername, dbpassword an the database you want to use

6: ready
Call the website with http://www.your.address/phppassmanager/



Upgrade:
========

0.90.10 => 0.90.20
extract the file "phppassmanager-0.90.20.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.

0.90.00 => 0.90.10
extract the file "phppassmanager-0.90.10.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.
Use the sql file "install/tables_update_0.90.00-0.90.10.sql" to update your DB data.

0.89.85 => 0.90.00
extract the file "phppassmanager-0.90.00.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.
Use the sql file "install/tables_update_0.89.85-0.90.00.sql" to update your DB data.

0.89.75 => 0.89.85
extract the file "phppassmanager-0.89.85.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.

0.89.55 => 0.89.75
extract the file "phppassmanager-0.89.75.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.

0.89.45 => 0.89.55
extract the file "phppassmanager-0.89.55.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.

0.89.35 => 0.89.45
extract the file "phppassmanager-0.89.45.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.

0.89.15 => 0.89.35
extract the file "phppassmanager-0.89.35.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.

0.89.10 => 0.89.15
extract the file "phppassmanager-0.89.15.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.

0.89.00 => 0.89.10
extract the file "phppassmanager-0.89.10.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.

0.88.20 => 0.89.00
extract the file "phppassmanager-0.89.00.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.
Use the sql file "install/tables_update_0.88.20-0.89.00.sql" to update your DB data.

0.88.10 => 0.88.20
extract the file "phppassmanager-0.88.20.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.

0.88.00 => 0.88.10
extract the file "phppassmanager-0.88.10.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.

0.87.00 => 0.88.00
extract the file "phppassmanager-0.88.00.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.

0.82.00 => 0.87.00
extract the file "phppassmanager-0.87.00.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.
Use the sql file "install/tables_update_0.82.00-0.87.00.sql" to update your DB data.

0.81.10 => 0.82.00:
extract the file "phppassmanager-0.82.00.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.
Use the sql file "install/tables_update_0.81.10-0.82.00.sql" to update your DB data.

0.81.00 => 0.81.10:
extract the file "phppassmanager-0.81.10.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.

0.80.00 => 0.81.00
extract the file "phppassmanager-0.81.00.tgz" in the same directory where you installed the old version.
Edit the file "config.php" an fill in there dbuser, dbpass and the database.

