CREATE TABLE config (
  vacParameter varchar(50) NOT NULL,
  vacValue varchar(50) NOT NULL,
  KEY vacParameter (vacParameter)
)

INSERT INTO config (vacParameter, vacValue) VALUES ('password_show', 'FALSE');

