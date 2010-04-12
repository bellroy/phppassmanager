ALTER TABLE accounts ADD vacUrl VARCHAR( 255 ) NOT NULL AFTER vacLogin;
ALTER TABLE accounts ADD intCountView INT UNSIGNED NOT NULL AFTER txtNotice;
ALTER TABLE accounts ADD intCountDecrypt INT UNSIGNED NOT NULL AFTER intCountView;
ALTER TABLE accounts ADD datAdded INT UNSIGNED NOT NULL AFTER intCountDecrypt;
ALTER TABLE accounts ADD datChanged INT UNSIGNED NOT NULL AFTER datAdded;

INSERT INTO config (vacParameter, vacValue) VALUES ('account_link', 'TRUE');

