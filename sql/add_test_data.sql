
INSERT INTO Kayttaja (nick, nimi, salasana) VALUES ('kae', 'Kaisa', 'kaka123');

INSERT INTO Kuva (kayttaja_id, url, aika) VALUES (1, 'http://eslblogcafe.com/skr/frank11270/files/2014/07/1.jpg', NOW());

INSERT INTO Kommentti (kayttaja_id, kuva_id, kommenttiteksti, aika) VALUES (1, 1, 'siisti kuva', NOW());