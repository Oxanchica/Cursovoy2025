До начала работы была экспортирована база данных в phpPgAdmin:
CREATE SCHEMA applicationSystem;
CREATE TABLE camcorders(
  ID varchar(100),
  AdmArea varchar,
  District varchar,
  Address varchar(700),
  SimpleAddress varchar(500),
  Photo text,
  UNOM varchar(11),
  global_id bigint UNIQUE,
  geoData point,
  geodata_center point,
  PRIMARY KEY (ID)
);
