ALTER TABLE accounts ADD vacMd5Password VARCHAR( 32 ) NOT NULL default '0' AFTER vacPassword;
