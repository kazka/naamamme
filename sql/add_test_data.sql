INSERT INTO Kayttaja (nick, nimi, salasana) VALUES ('kae', 'Kaisa', md5('kaka123'));
INSERT INTO Kuva (kayttaja_id, url, aika) VALUES (1, 'http://kazkaupp.users.cs.helsinki.fi/tsoha/uploads/chi-1.jpg', NOW());
INSERT INTO Kommentti (kayttaja_id, kuva_id, kommenttiteksti, aika) VALUES (1, 1, 'siisti kuva', NOW());
INSERT INTO Kuva (kayttaja_id, url, aika, paakuva) VALUES (1, 'http://kazkaupp.users.cs.helsinki.fi/tsoha/uploads/hilloh.jpg', NOW(), false);
INSERT INTO Tykkays (tykkaaja_id, tykattava_id) VALUES (1, 1);