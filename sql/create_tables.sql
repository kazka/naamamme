CREATE TABLE Kayttaja(
  id SERIAL PRIMARY KEY,
  nick varchar(255) NOT NULL,
  nimi varchar(255) NOT NULL,
  salasana varchar(255) NOT NULL
);
CREATE TABLE Kuva(
  id SERIAL PRIMARY KEY,
  kayttaja_id INTEGER REFERENCES Kayttaja(id),
  url varchar(255) NOT NULL,
  aika timestamp
);
CREATE TABLE Kommentti(
  id SERIAL PRIMARY KEY,
  kayttaja_id INTEGER REFERENCES Kayttaja(id),
  kuva_id INTEGER REFERENCES Kuva(id),
  kommenttiteksti text,
  aika timestamp
);
CREATE TABLE Tykkays(
  tykkaaja_id INTEGER NOT NULL,
  tykattava_id INTEGER NOT NULL,
  PRIMARY KEY (tykkaaja_id, tykattava_id),
  FOREIGN KEY (tykkaaja_id) REFERENCES Kayttaja(id),
  FOREIGN KEY (tykattava_id) REFERENCES Kuva(id)
);