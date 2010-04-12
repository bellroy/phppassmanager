CREATE TABLE accounts (
  intAccountId smallint(5) unsigned NOT NULL auto_increment,
  vacName varchar(255) NOT NULL,
  intGroupFid tinyint(3) unsigned NOT NULL,
  vacLogin varchar(255) NOT NULL,
  vacUrl varchar(255) NULL,
  vacPassword varchar(255) NOT NULL,
  vacMd5Password varchar(32) NOT NULL default '0',
  vacInitialValue varchar(255) NOT NULL,
  txtNotice text,
  intCountView int(10) unsigned NOT NULL default '0',
  intCountDecrypt int(10) unsigned NOT NULL default '0',
  datAdded datetime NOT NULL,
  datChanged datetime NOT NULL,
  PRIMARY KEY (intAccountId)
);

CREATE TABLE config (
  vacParameter varchar(50) NOT NULL,
  vacValue varchar(50) NOT NULL,
  KEY vacParameter (vacParameter)
);

INSERT INTO config (vacParameter, vacValue) VALUES ('password_show', 'TRUE');
INSERT INTO config (vacParameter, vacValue) VALUES ('account_link', 'TRUE');
INSERT INTO config (vacParameter, vacValue) VALUES ('account_count', '5');
INSERT INTO config (vacParameter, vacValue) VALUES ('md5_pass', 'TRUE');

CREATE TABLE groups (
  intGroupId smallint(5) unsigned NOT NULL auto_increment,
  vacGroupName varchar(255) NOT NULL,
  PRIMARY KEY (intGroupId)
);

INSERT INTO groups (intGroupId, vacGroupName) VALUES (1, 'eMail');

